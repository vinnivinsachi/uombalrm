<?php
	class DatabaseObject_Product extends DatabaseObject
	{
		
		public $profile=null;
		public $images = array();
		
		const PRODUCT_STATUS_DRAFT = 'D';
		const PRODUCT_STATUS_LIVE = 'L';
		
		public function __construct($db)
		{
			parent::__construct($db, 'products', 'product_id');
			$this->add('user_id');
			$this->add('url');
			$this->add('ts_created', time(), self::TYPE_TIMESTAMP);
			$this->add('status', self::PRODUCT_STATUS_DRAFT);
			
			$this->profile = new Profile_Product($db);
		}
		
		//because of all the constraints make sure that all the profile stuff that is connected iwth the product must have something done to it when messing with the database. 
		protected function postLoad()
		{
		//$this->getImages();
			$this->profile->setProductId($this->getId());
			$this->profile->load();
			
			
		}
		
		protected function postInsert()
		{
			$this->profile->setProductId($this->getId());
			$this->profile->save(false);
			$this->addToIndex();

			return true;
		}
		
		protected function postUpdate()
		{
			$this->profile->save(false);
			$this->addToIndex();

			return true;
		}
		
		protected function preDelete()
		{
			$this->getImages();
			foreach ($this->images as $image)
			{
				$image->delete(false);
			}
			
			$this->profile->delete();
			$this->deleteFromIndex();
			return true;
		}
		
		protected function preInsert()
		{
			$this->url= DatabaseObject_StaticUtility::generateUniqueUrl($this->_db, $this->_table, $this->profile->name, $this->user_id);
			return true;
		
		}
		
		
		protected function addToIndex()
		{
			//echo "added to index";
			try{
				$index = Zend_Search_Lucene::open(self::getIndexFullpath());
				
				/*$logger = Zend_Registry::get('logger');

				$logger->warn('at addto index');*/
			}
			catch(Exception $ex)
			{
				self::RebuildIndex();
				return;
			}
			
			try{
				$query=new Zend_Search_Lucene_Search_Query_Term(new Zend_Search_Lucene_Index_Term($this->getId(), 'product_id')
				);
				
				$hits = $index->find($query);
				foreach($hits as $hit)
				{
					$index->delete($hit->id);
				}
				
				if($this->status =='L')
				{
					$index->addDocument($this->getIndexableDocument());
				}
				
				$index->commit();
			}
			catch (Exception $ex) 
			{
				$logger = Zend_Registry::get('logger');
				$logger->warn('Error updateing document in search index: '.$ex->getMessage());
			}
		}
		
		
		protected function deleteFromIndex()
		{
			//echo "deleted from index";
			try{
				$index = Zend_Search_Lucene::open(self::getIndexFullpath());
				
				$query = new Zend_Search_Lucene_Search_Query_Term(new Zend_Search_Lucene_Index_Term($this->getId(), 'product_id')
				);
				
				$hits = $index->find($query);
				foreach($hits as $hit)
				{
					$index->delete($hit->id);
				}
				
				$index->commit();
			}
			catch(Exception $ex)
			{
				$logger = Zend_Registry::get('logger');
				$logger->warn('Error removing document from search index: '.$ex->getMessage());
			}
		}
		
		public function getIndexableDocument()
		{
			$doc = new Zend_Search_Lucene_Document();
			
			$doc->addField(Zend_Search_Lucene_Field::Keyword('profile_id', $this->getId()));
		
			$fields = array(
						'name' => $this->profile->name,
						'published' =>$this->ts_created
						);
			
			foreach($fields as $name =>$field)
			{
				$doc->addField(Zend_Search_Lucene_Field::UnStored($name, $field)
				);
			}
			
		/*	$logger = Zend_Registry::get('logger');

				$logger->warn('at getindeaxable document');*/
			
			return $doc;			
			
		}
		
		public static function getIndexFullpath()
		{
			$config = Zend_Registry::get('config');
			
			$path = sprintf('%s/search-index', $config->paths->data);
			
			if(!is_dir($path))
			{
				mkdir($path, 0777, true);
				//echo "path made";
			}
			
			return $path;
		}
		
		public static function RebuildIndex()
		{
		
			try{
				$index = Zend_Search_Lucene::create(self::getIndexFullpath());
				
				$options = array('status'=>'L');
				
				$users = self::GetObjects(Zend_Registry::get('db', $options));
				
				foreach($users as $user)
				{
					$index->addDocument($user->getIndexableDocument());
				}
				
				$index->commit();
				
				/*$logger = Zend_Registry::get('logger');

				$logger->warn('Rebuild complete');*/

			}
			catch(Exception $ex)
			{
				$logger = Zend_Registry::get('logger');
				$logger->warn('Error rebuilding search index: '.$ex->getMessage());
			}
		}
		
		public static function getUserSuggestions($db, $partialUser, $limit = 15)
		{
			$partialTag = trim($partialUser);
			if(strlen($partialUser) ==0)
			{
				return array();
			}
			
			$select = $db->select();
			$select->distinct();
			$select->from(array('p' => 'products_profile'), 'profile_value')
				   ->joinInner(array('u' =>'products'), 'p.product_id = u.product_id', array())
				   ->where('lower(p.profile_value) like lower(?)', '%'.$partialUser. '%')
				   ->where('p.profile_key = ?', 'name')
				   ->where('u.status = ?', 'L')
				   ->order('lower(p.profile_value)');
			
			if($limit >0)
			{
				$select->limit($limit);
			}
			
			//echo $select;
			
			return $db->fetchCol($select);
		}
				 
			
			
		
		public function isLive()
		{
			return $this->isSaved() && $this->status==self::PRODUCT_STATUS_LIVE;
		}
	
		public function sendLive()
		{
			if($this->status != self::PRODUCT_STATUS_LIVE)
			{
				$this->status = self::PRODUCT_STATUS_LIVE;
				$this->profile->ts_published = time();
			}
		}
		
		public function sendBackToDraft()
		{
			$this->status = self::PRODUCT_STATUS_DRAFT;
		}
		
		public function getTagFromProduct()
		{
			$select = $this->_db->select();
				
				$select->from('products_tags', 'tag')
					  ->where('product_id = ?', $this->getId());
					 
				return $this->_db->fetchOne($select);
		}
		
		
		public static function getTagSummary($db, $user_id)
		{
			//echo "<br/>you are at getTagSummary in products databaseobject<br/>";
			return DatabaseObject_StaticUtility::getTagSummaryForObject($db, $user_id, 'products_tags','', 'products', self::PRODUCT_STATUS_LIVE, 'product_id');
		
		}
		
		public static function getCatSummary($db, $user_id)
		{
			return DatabaseObject_StaticUtility::getTagSummaryForObject($db, $user_id, 'products_category','', 'products', self::PRODUCT_STATUS_LIVE, 'product_id');
		
		}
		
		public static function getCatTagSummary($db, $user_id, $cat='')
		{
			return DatabaseObject_StaticUtility::getTagSummaryForObject($db, $user_id, 'products_tags', 'products_category', 'products', self::PRODUCT_STATUS_LIVE, 'product_id',$cat);
		
		}
		
		public static function getTagCatSummary($db, $user_id, $cat='')
		{
			return DatabaseObject_StaticUtility::getTagSummaryForObject($db, $user_id, 'products_category','products_tags', 'products', self::PRODUCT_STATUS_LIVE, 'product_id',$cat);
		
		}
		
		
		public static function GetObjects($db, $options=array()) //got the user, got form, got to, got order. 
		{
			$defaults = array('offset'=>12,
							  'limit'=>0,
							  'order' => 'p.ts_created'
							  );
					
			foreach($defaults as $k=>$v)
			{
				$options[$k]=array_key_exists($k, $options)?$options[$k]:$v;
			}
			
			if(!empty($options['cat']) && strlen($options['cat'])>0)
			{
				$select = self::_GetBaseQuery2($db, $options); 
				//echo "here";
			}
			else
			{
				$select = self::_GetBaseQuery($db, $options); 
			}
			
			$select->from(null,'p.*');
			
			if($options['limit']>0)
			{
				$select->limitpage($options['limit'], $options['offset']);
			}
			

			if(!empty($options['alphabetLink']) && strlen($options['alphabetLink'])>0)
			{
				$select->joinInner(array('pp'=>'products_profile'), 'pp.product_id = p.product_id');

				$select->where('pp.profile_key = "name"');
				$select->where('pp.profile_value like "'.$options['alphabetLink'].'%"');
			}
			
			if(!empty($options['brand']) && $options['brand']!="none")
			{
			
				//echo $options['brand']."<br/>";
			
				$select->joinInner(array('t'=>'products_profile'), 't.product_id = p.product_id');
				$select->where('t.profile_key = "brand"');
				$select->where('t.profile_value = ?', $options['brand']);
				
			}
			
			
			if(!empty($options['style']) && $options['style']!="none")
			{
				$select->joinInner(array('e'=>'products_profile'), 'e.product_id = p.product_id');

				$select->where('e.profile_key = "type"');
				$select->where('e.profile_value = ?', $options['style']);
			}
			
			if(!empty($options['status']) && strlen($options['status'])>0)
			{
				$select->where('p.status = ?', $options['status']);
			}
			
			if(!empty($options['search']) && strlen($options['search'])>0)
			{
			
				$select-> joinInner(array('u' =>'products_profile'), 'p.product_id = u.product_id', array())
				   ->where('lower(u.profile_value) like lower(?)', '%'.$options['search']. '%')
				   ->where('u.profile_key = ?', 'name');
			}
			
			//echo $select."<br/>";
			
			$data=$db->fetchAll($select);
			
			$products = self::BuildMultiple($db,__CLASS__,$data); 
			$products_ids = array_keys($products);
			
			//echo "count of products_ids is: ".count($products_ids)."<br/>";
			
			if(count($products_ids)==0)
			{
				return array();
			}
			
			
			$profiles =Profile::BuildMultiple($db, 'Profile_Product', array('product_id'=>$products_ids));
			
			foreach($products as $product_id =>$product)
			{
				if(array_key_exists($product_id, $profiles) && $profiles[$product_id] instanceof Profile_Product)
				{
					$products[$product_id]->profile=$profiles[$product_id]; 
				}
				else
				{
					$products[$product_id]->profile->setProductId($product_id);
				}
				
			}
			
			//load for the images for each post
			$imageOptions = array('product_id' =>$products_ids );
			
			$images = DatabaseObject_Image::GetImages($db, $imageOptions, 'product_id', 'products_images');
			
			foreach($images as $image)
			{
				//echo "image id is: ".$image->product_id."<br/>";
				$products[$image->product_id]->images[$image->getId()] = $image;
			}
			
			
			return $products;
		}
		
		
		public static function GetObjectsCount($db, $options)
		{
			$select = self::_GetBaseQuery($db, $options);
			$select->from(null, 'count(*)');
			return $db->fetchOne($select);
		}
		
		public function loadLiveObject($user_id, $url)
		{
			$query = DatabaseObject_StaticUtility::loadLiveObjects($this->_db, $user_id, $url, $this->_table, $this->getSelectFields(), self::PRODUCT_STATUS_LIVE);
			
			return $this->_load($query);
		}
		
		public function getImages()
		{
			$options=array('product_id' =>$this->getId()); //loading images
			$this->images = DatabaseObject_Image::GetImages($this->getDb(), $options, 'product_id', 'products_images');
		}
		
		private static function _GetBaseQuery($db, $options) 
		{
			return DatabaseObject_StaticUtility::_GetBaseQuery($db, $options, 'product_id', 'products', 'products_tags', 'p');
		}
		
		private static function _GetBaseQuery2($db, $options) 
		{
			return DatabaseObject_StaticUtility::_GetBaseQuery($db, $options, 'product_id', 'products', 'products_category', 'p');
		}
		
		public function getTeaser($length)
		{
			return DatabaseObject_StaticUtility::GetTeaser($this->profile->description, $length);
		}		
		
		
		public static function GetMonthlySummary($db, $options)
		{
			return DatabaseObject_StaticUtility::GetMonthlySummary($db, $options, 'product_id', 'products', 'products_tags', 'p');
		}
		
		public function setImageOrder($order)
		{	
						$this->getImages();

			DatabaseObject_StaticUtility::setImageOrder($this->_db, 'products_images', $order, $this->images);
		}
		
	}

?>