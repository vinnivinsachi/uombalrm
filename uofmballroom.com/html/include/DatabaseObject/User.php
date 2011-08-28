<?php

	//only tables with and Id, and auto increment that can work with database objects
	//otherwise different methods must be used. 
	//CLUBPROFILE IMAGES IS NOT INSTANTIATED IN HERE BECAUSE PRODUCT/POST/OTHERTHINGS DOES NOT NEED TO GENERATE     		    ////GENERATE CLUBPROFILE IMAGES. 
	//pg64
	
	class DatabaseObject_User extends DatabaseObject
	{
	
		static $userTypes= array('member' 	    => 'member',
								'administrator' => 'Administrator',
								'clubAdmin'     => 'clubAdmin');
								
		public $profile =null;				
		public $universityName = null;	
		public $typeName  = null;	
		public $images;
		public $orderShoppingCart;
		public $orderCartObject;
		
		public $_newPassword = null;
		
		public function __construct($db)
		{
			parent::__construct($db, 'users', 'userID');
			
			$this->add('username');
			$this->add('password');
			$this->add('first_name');
			$this->add('last_name');
			$this->add('user_type', 'member');
			$this->add('university_id');
			$this->add('status', 'D');
			//$this->add('type_id');
			$this->add('verification', 'unverified');
			$this->add('ts_created', time(), self::TYPE_TIMESTAMP);
			$this->add('ts_last_login', null, self::TYPE_TIMESTAMP);
			
			$this->profile = new Profile_User($db);
		}
		
		
		protected function preInsert()
		{
		
			//$this->_newPassword = Text_Password::create(8);
			//$this->password = $this->_newPassword;
			$this->profile->num_posts =10;
			
			return true;
		}
		
		protected function postLoad()
		{
			$this->profile->setUserId($this->getId());
			$this->profile->load();
			
	
		}
		
		protected function postInsert()
		{
			$this->profile->setUserId($this->getId());
			$this->profile->save(false);
			
			$this->sendEmail('user-register.tpl');
			
			if($this->user_type == 'clubAdmin')
			{
				DatabaseObject_StaticUtility::addClubNumber($this->_db, $this->university_id);
				DatabaseObject_StaticUtility::addTypeClubNumber($this->_db, $this->type_id);
			}
			
			//echo "message being sent";
			//$this->addToIndex();
			return true;
		}
		
		protected function postUpdate()
		{
			$this->profile->save(false);
			
			$this->addToIndex();
			return true;
		}
		
		protected function addToIndex()
		{
			//echo "added to index";
			try{
				$index = Zend_Search_Lucene::open(self::getIndexFullpath());
			}
			catch(Exception $ex)
			{
				self::RebuildIndex();
				return;
			}
			
			try{
				$query=new Zend_Search_Lucene_Search_Query_Term(new Zend_Search_Lucene_Index_Term($this->getId(), 'userID')
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
			echo "deleted from index";
			try{
				$index = Zend_Search_Lucene::open(self::getIndexFullpath());
				
				$query = new Zend_Search_Lucene_Search_Query_Term(new Zend_Search_Lucene_Index_Term($this->getId(), 'userID')
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

		
		/***********************************************************************
		**WHEN DELETING A USER, PROFILE, IMAGES, EVENTS, PRODUCTS, POSTS, MEMBERS,
		**ALL MUST BE DELETED
		************************************************************************/
		protected function preDelete() 
		{
			foreach ($this->images as $image)
			{
				$image->delete(false);
			}
		
			$this->profile->delete();
			
			$this->deleteFromIndex();
			return true;
		}
		
		
		
		public function __set($name, $value) //automatically setts things when not defined. 
		{
			switch ($name)   // if the set name is any one of these, it does the following. 
			{
				case 'password': //if trying to set password, convert to $value and then call parent
					$value = md5($value);
					break;
				case 'user_type': //if trying to set user_type that is not currenlty existant in the userType array, change $value to 'member';
					if(!array_key_exists($value, self::$userTypes))
					$value = 'member';
					break;
			}
			
			return parent::__set($name, $value);
		
		}
		
		//========================indexing the database=========================
		public function getIndexableDocument()
		{
			$doc = new Zend_Search_Lucene_Document();
			
			$doc->addField(Zend_Search_Lucene_Field::Keyword('userID', $this->getId()));
		
			$fields = array(
						'name' => $this->profile->public_club_name,
						'published' =>$this->ts_created
						);
			
			foreach($fields as $name =>$field)
			{
				$doc->addField(Zend_Search_Lucene_Field::UnStored($name, $field)
				);
			}
			
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
			$select->from(array('p' => 'users_profiles'), 'profile_value')
				   ->joinInner(array('u' =>'users'), 'p.userID = u.userID', array())
				   ->where('lower(p.profile_value) like lower(?)', '%'.$partialUser. '%')
				   ->where('p.profile_key = ?', 'public_club_name')
				   ->where('u.status = ?', 'L')
				   ->order('lower(p.profile_value)');
			
			if($limit >0)
			{
				$select->limit($limit);
			}
			
			//echo $select;
			
			return $db->fetchCol($select);
		}
				 
			
			
		
		
		
		
		//************************************************************************88
		
		
		public function usernameExists($username)
		{
			$query=sprintf('select count(*) as num from %s where username=?', $this->_table);
			//echo "$query";
			$result = $this->_db->fetchOne($query, $username);
			return $result;
		}
		
		static public function IsValidUsername($username)
		{
			$validator = new Zend_Validate_Alnum(); //validates only if the username contain alphebetical and numeric values. 
			return $validator->isValid($username);
		}
		
		
		public function createAuthIdentity()
		{
			$identity = new stdClass;
			//echo "here at stdClass";
			$identity->userID = $this->getId();
			$identity->username = $this->username;
			$identity->user_type = $this->user_type;
			$identity->first_name = $this->profile->first_name;
			$identity->last_name = $this->profile->last_name;
			$identity->email = $this->profile->email;
			
			return $identity;
		}
		
		public function loginSuccess()
		{
			$this->ts_last_login = time();
			
			unset($this->profile->new_password);
			unset($this->profile->new_password_ts);
			unset($this->profile->new_password_key);
			
			$this->save();
			
			//$message=sprintf('Successful login attempt from %s user %s', $_SERVER['REMOTE_ADDR'], $this->username);
			//$logger = Zend_Registry::get('logger');
			//$logger->notice($message);
		}
		
		static public function LoginFailure($username, $code='')
		{
			switch($code)
			{
				case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
					$reason = 'Unknown username';
					break;
				case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
					$reason = 'Multiple users found with this username';
					break;
				case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
					$reason = 'Invalid password';
					break;
				default:
					$reason = '';
			}
			
			$message = sprintf('Failed login attempt from %s user %s', $_SERVER['REMOTE_ADDR'], $username);
			
			if(strlen($reason)>0)
			$message .= sprintf('(%s)', $reason);
			
			$logger = Zend_Registry::get('logger');
			$logger->warn($message);
			
		}
		
		
		public function loadByUsername($username, $user_type, $status)
		{
			$username = trim($username);
			if(strlen($username)==0)
			{
				return false;
			}
			
			$query = sprintf('select %s from %s where user_type =? ', join(', ', $this->getSelectFields()), $this->_table, $user_type);
			
			
			$query=$this->_db->quoteInto($query, $user_type); 
			

			$query=$query.' and username = ?';
			
			$query=$this->_db->quoteInto($query, $username);
			
			$query=$query.' and status = ?';
			$query=$this->_db->quoteInto($query, $status);

			return $this->_load($query);
		}
		
		public function loadByUserId($ID)
		{
			//echo "you are here at load by user id";
			$id = (int)$ID;
			
			if(strlen($ID)<=0)
			{
				echo "your ID is invalid";
				return false;
			}
			
			$query = sprintf('select %s from %s where userID = ?', join(', ', $this->getSelectFields()), $this->_table);
			$query = $this->_db->quoteInto($query, $ID);
			
			return $this->_load($query);
		}
		
		public function getTeaser($length)
		{
			return DatabaseObject_StaticUtility::GetTeaser($this->profile->club_description, $length);
		}
		
		
		
		public function sendEmail($tpl, $secondUser='', $invoiceID='')
		{
			$templater = new Templater();
			$templater->user = $this;
			
			if($secondUser != '')
			{
			$templater->member = $secondUser;
			}
			
			

			if($invoiceID!='')
			{
				$order = new DatabaseObject_Order($this->_db);

				if($order->loadOrderByUrl($invoiceID))
				{
					if($order->promotion_code == '')
					{
						$templater->addPromo = 'true';
					}
					else
					{
						$templater->promoCode = $order->promotion_code;
						$templater->discount = $order->total_after_p-$order->total_before_p;
						$templater->finalTotal = $order->total_after_p;
					}
					
					//echo "promotion code: ";
					
					
					
					$orderProfile = new Profile_Order($this->_db);
				
					
					$result = $orderProfile->loadProifleByOrderID($order->getId());
					
					
					if($order->buyer_id>30000000)
					{
						
						$member = new DatabaseObject_Guest($this->_db);
						
						$member->loadByID($order->buyer_id-30000000);
						$templater->guest = 'true';
	
					}
					else
					{
						$member = new DatabaseObject_User($this->_db);
						
						if($type=='buyer')
						{	
							$member->loadByUserId($order->user_id);
							////echo "here at odertype buyer";
						}
					}
					
					echo "order status: ".$order->url."<br/>";
					echo "count of order in that order: ".count($result)."<br/>";
					echo $result[0]['profile_id'];
					echo $result[0]['product_name'];
					
					
					$templater->member=$member;
					$productProfile=array();
					
					foreach ($result as $k => $v)
					{
						//echo "<br/>here0<br/>";
						
						$productProfile[$result[$k]['profile_id']] = new Profile_Order($this->_db);
						
						$productProfile[$result[$k]['profile_id']]->loadOrder($result[$k]['profile_id'], $order->url);
						
						
						
						//echo "<br/>heels are for profile_id: ".$result[$k]['profile_id']." and heels are: ".$productProfileArray[$result[$k]['profile_id']]->orderAttribute->heel."<br/>";
						//echo "<br/>name: ".$productProfileArray[1]->product_name;
	
					}
				
					$templater->productsProfile=$productProfile;
	
				$templater->invoice = $invoiceID;
				$templater->dateTime= date(date("F j, Y, g:i a"), $order->ts_created);
				$templater->finalTotal = $order->total_after_p;
				
		
				
				}
			}
			//fetch teh e-amil body
			$body = $templater->render('email/'.$tpl);
			
			//extract the subject from the first line
			list($subject, $body) = preg_split('/\r|\n/', $body, 2);
			
			//now set up and send teh email
			$mail = new Zend_Mail();
			
			//set the to address and the user's full name in the 'to' line
			echo "<br/> here at user email address: ".$this->profile->email."<br/>";
			$mail->addTo($this->profile->email, trim($this->first_name.' '.$this->last_name));
			
			//get the admin 'from details form teh config
			$mail->setFrom('ballroom-no-reply@visachidesign.com', 'bt-no-reply');
			
			//set the subject and boy and send the mail
			$mail->setSubject(trim($subject));
			$mail->setBodyText(trim($body));
			$mail->send();
			
			//$logger->warn('at send email at usre.php complete<br/>');

		}
		
		
		
		
		public function fetchPassword()
		{
			if(!$this->isSaved())
			{
				return false;
			}
			
			//generate new password properties
			$this->_newPassword = Text_Password::create(8);
			
			$this->profile->new_password = md5($this->_newPassword);
			$this->profile->new_password_ts =time();
			$this->profile->new_password_key = md5(uniqid().$this->getId().$this->_newPassword);
			
			//save new password to profile and send emial
			$this->profile->save();
			
			$this->sendEmail('user-fetch-password.tpl');
			
			return true;
		}
		
		
		
		
		public function confirmNewPassword($key)
		{
			//check that valid password reset data is set
			if(!isset($this->profile->new_password) || !isset($this->profile->new_password_ts) || !isset($this->profile->new_password_key))
			{
				return false;
			}
			
			//check if the password is being confirm winthin a day
			if(time() - $this->profile->new_password_ts >86400)
			{
				return false;
			}
			
			if($this->profile->new_password_key != $key)
			{
				return false;
			}
			
			//everything is valid, nowupadte the account to use the new password
			//bypass the local setter as new_password is already an md5
			
			parent::__set('password', $this->profile->new_password);
			
			unset($this->profile->new_password);
			unset($this->profile->new_password_ts);
			unset($this->profile->new_password_key);
			
			//finally, save the updated user record and the updated profile
			return $this->save();
		}
		
		
			
		
		
		
		public static function GetObjects($db, $options=array())
		{
			$defaults = array('offset'=>8,
							  'limit'=>0,
							  'limitTotal'=>0
							  );
					
			foreach($defaults as $k=>$v)
			{
				$options[$k]=array_key_exists($k, $options)?$options[$k]:$v;
			}
			
			$select = self::_GetBaseQuery($db, $options); 
			
			//echo "<br/>before select: ".$select;
			$select->from(null,'u.*');
			
			if(!empty($options['user_type']) && strlen($options['user_type'])>0)
			{
			
				$select->where('u.user_type = ?', $options['user_type']);
			}
			
			if(!empty($options['university']) && $options['university'] != 'all')
			{
				$select->where('u.university_id = ?', $options['university']);
			}
			
			if(!empty($options['status']) && strlen($options['status'])>0)
			{
				$select->where('u.status = ?', $options['status']);
			}
			
			if(!empty($options['alphabetLink']) && strlen($options['alphabetLink'])>0)
			{
				$select->joinInner(array('p'=>'users_profiles'), 'p.userID = u.userID');
				$select->where('p.profile_key = "public_club_name"');
				$select->where('p.profile_value like "'.$options['alphabetLink'].'%"');
			}
			
 
			if($options['limit']>0)
			{
				$select->limitpage($options['limit'], $options['offset']);
			}
			
			if($options['limitTotal']>0)
			{
				//echo "here at limit total";
				$select->limit((($options['limitTotal']+3)*8),(($options['limitTotal']*8)));
			}
			
			if(!empty($options['order']))
			{
				$select->order($options['order']);
			}
			
			
			
			//echo "<br/>select: ".$select;
			
			$data=$db->fetchAll($select);
			
			
			$users = self::BuildMultiple($db,__CLASS__,$data); 
			$users_ids = array_keys($users);
			
			//users_ids[0] = 25;
			//users_ids[1] = 32;
			
			//echo "user_id one: ".$users_ids[0];
			//echo "user_id two: ".$users_ids[1];
			
			if(count($users_ids)==0)
			{
				return array();
			}
			
			
			$profiles =Profile::BuildMultiple($db, 'Profile_User', array('userID'=>$users_ids));
			
			
			//echo "<br/>test profile email: ".$profiles[25]->email;
			
			//echo "<br/>Profiles: ".count($profiles);
			foreach($users as $user_id =>$user)
			{
				if(array_key_exists($user_id, $users) && $profiles[$user_id] instanceof Profile_User)
				{
					$users[$user_id]->profile=$profiles[$user_id]; 
					
					$name = DatabaseObject_StaticUtility::loadUniversityName($db, $users[$user_id]->university_id);
					$users[$user_id]->universityName = $name;
					
					$type = DatabaseObject_StaticUtility::loadTypeName($db, $users[$user_id]->type_id);
					$users[$user_id]->typeName = $type;
					//echo "<br/>user id: ".$users[$user_id]->university_id;
						
					//echo "<br/>user name: ".$users[$user_id]->universityName;
					//echo "<br/>here at array_keyPexist<br/>";
					//echo "<br/>users priflie email: ".$users[$user_id]->profile->email;
				}
				else
				{
					$users[$user_id]->profile->setUserId($user_id);
				}
				
			}
			
			//load for the images for each post
			
			//gotta make this into all new image objects arrays, and match them with the user profile. 
			
			foreach($users_ids as $userID)
			{
				
				$options=array('user_id' =>$userID, 'limit'=>1); //loading images
				
				//echo "<br/>user_id: ".$this->getId();
				
				$images = DatabaseObject_Image::GetImages($db, $options, 'user_id', 'users_profiles_images');
				
				
				//echo "<br/>images: ".count($images);
				foreach($images as $image)
				{
					$users[$image->user_id]->images[$image->getId()] = $image;
				}
			
			}
			
			//echo "<br/>first user images: ".count($users[25]->images);
			//echo "<br/>second user images: ".count($users[32]->images);
			
			return $users;
			
		}
		
		public static function GetUsersCount($db, $options)
		{
			$select = self::_GetBaseQuery($db, $options);
			$select->from(null, 'count(*)');
			return $db->fetchOne($select);
		}
		
		private static function _GetBaseQuery($db, $options)
		{
			//initialize the options
			$defaults = array('user_id'=> array(), 'userID'=>array());
			
			foreach ($defaults as $k => $v)
			{
				$options[$k]=array_key_exists($k, $options)?$options[$k]:$v;
			}
			
			//create a query that selects from the user table
			$select = $db->select();
			$select->from(array('u' =>'users'), array());
			
			//filter results on specified user ids(if any)
			if(count($options['user_id']) >0)
			{
				$select->where('u.userID in(?)', $options['user_id']);
			}
			if(count($options['userID']) >0)
			{
				$select->where('u.userID in(?)', $options['userID']);
			}
			return $select;
		}
		
		public function setImageOrder($order)
		{	
			//echo "at user setImageOrder: ".$order;
			DatabaseObject_StaticUtility::setImageOrder($this->_db, 'users_profiles_images', $order, $this->images);
		}
		
		
	}
	
	
	//profile only works with table fields that are profile_key/profile_value colums
	
	
?>