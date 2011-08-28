<?php

	class ProductmanagerController extends CustomControllerAction
	{
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('product manager', $this->getUrl(null, 'productmanager'));
			$this->identity=Zend_Auth::getInstance()->getIdentity();
			
			$user = new DatabaseObject_User($this->db);
			if($user->loadByUserId($this->identity->userID))
			{
			$this->view->clubManager =$user;
			}
			
			////echo $user->profile->paypalEmail;
			$_SESSION['categoryType'] = 'product';

		}
	
		public function indexAction()
		{
			$tag=$this->getRequest()->getQuery('tag');
			
			$month =$this->getRequest()->getQuery('month');
			
			$cat = $this->getRequest()->getQuery('cat');

			
			//echo "cat is: ".$cat;
			
			$totalProducts = DatabaseObject_Product::GetObjectsCount($this->db, array('user_id'=>$this->identity->userID));
			if(isset($tag))
			{
				$options = array(
				'user_id' =>$this->identity->userID,
				'tag' =>$tag,
				'status' =>DatabaseObject_Product::PRODUCT_STATUS_LIVE,
				'order' =>'p.ts_created desc');
			
				$recentProducts = DatabaseObject_Product::GetObjects($this->db, $options);
				
				echo "you are here at first product tag: ".$tag;
				
				$this->view->tagProducts = $recentProducts;
				$this->view->tag = $tag;
			}
			
			if(isset($cat))
			{
				$options = array(
				'user_id' =>$this->identity->userID,
				'cat' =>$cat,
				'status' =>DatabaseObject_Product::PRODUCT_STATUS_LIVE,
				'order' =>'p.ts_created desc');
			
				$recentProducts = DatabaseObject_Product::GetObjects($this->db, $options);
				
				//echo "here";
				
				$this->view->tagProducts = $recentProducts;
				$this->view->tag = $tag;
			}
			
			
			//echo "here1";
			
			if(isset($month) && !isset($tag))
			{
				////echo "here";
				if(preg_match('/^(\d{4})-(\d{2})$/', $month, $matches))
				{
					$y = $matches[1];
					$m = max(1, min(12, $matches[2]));
				}
				else
				{
					$y = date('Y'); //current year
					$m = date('n'); //current month
				}
				
				$from=mktime(0,0,0, $m, 1, $y);
				
				$to = mktime(0,0,0,$m+1,1,$y)-1;
				
				$options=array('user_id' =>$this->identity->userID,
							   'from'=>date('Y-m-d H:i:s', $from),
							   'to' =>date('Y-m-d H:i:s', $to),
							   'order' =>'p.ts_created desc');
				
				
				$recentPosts = DatabaseObject_Product::GetObjects($this->db, $options);
				//echo "here";
				//get the total number of posts for this user
				
				
				$this->view->month = $from;
				$this->view->recentPosts = $recentPosts;
			}
			//echo "here 2";
			$this->view->totalProducts = $totalProducts;
		}
		
		
		public function editAction()
		{
			
			$request=$this->getRequest();
			
			$product_id =(int)$this->getRequest()->getQuery('id');
			////echo "at edit action: ".$product_id."<br/>";
			//$product = new DatabaseObject_Product($this->db);
			
			$fp = new FormProcessor_Product($this->db, $this->identity->userID, $product_id);
			////echo "<br/>At edit action== product->user_id: ".$fp->product->user_id;
			
			if($request->isPost())
			{
				if($fp->process($request))
				{
					//redirect this to new url
					//$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

					$url = $this->getUrl('preview').'?id='.$fp->product->getId();
					$this->_redirect($url);
				}
			}
			
			if($fp->product->isSaved())
			{
				$this->breadcrumbs->addStep('preview post: '.$fp->product->profile->name, $this->getUrl('preview').'?id='.$fp->product->getId());
				$this->breadcrumbs->addStep('Edit post');
			}
			else
			{
				$this->breadcrumbs->addStep('create new products');
			}
			
			$this->view->fp=$fp;
		}
		
		public function previewAction()
		{
		
			$product_id = (int)$this->getRequest()->getQuery('id');
			
			$product = new DatabaseObject_Product($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($product, $this->identity->userID, $product_id, 'product_id'))
			{
			
				////echo "id: ".$this->identity->userID;
				////echo "product_id: ". $product_id;
				////echo "you are here at not being able to load";
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				$this->_redirect($this->getUrl());
			}
			
			$product->getImages();
			
			$tags = DatabaseObject_StaticUtility::getTagsForObject($product, 'products_tags', 'product_id'); 
			$categories = DatabaseObject_StaticUtility::getTagsForObject($product, 'products_category','product_id');
			
			$options['order']='size';
			$options['product_id']=$product->getId();
			
			//array('order' => 'ts_created', 'product_id'=>$product->getId());
			
			$this->view->invprofile=DatabaseObject_Invprofile::GetObjects($this->db,$options);
			
			
			$this->breadcrumbs->addStep('Preview product: '.$product->profile->name);
			
			$this->view->product = $product;
			$this->view->tags = $tags;
			$this->view->categories = $categories;
		}
		
		public function setstatusAction()
		{
			$request=$this->getRequest();
			
			$product_id =(int) $request->getPost('id');
			
			$product = new DatabaseObject_Product($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($product, $this->identity->userID, $product_id, 'product_id'))
			{
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				$this->_redirect($this->getUrl());

			}
			
			$url = $this->getUrl('preview').'?id='.$product->getId();
			
			if($request->getPost('edit'))
			{
				$this->_redirect($this->getUrl('edit').'?id='.$product->getId());
			}
			else if($request->getPost('publish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($product, 'publish');
				$this->messenger->addMessage('Product sent live');
				
				$this->_redirect($url);


			}
			else if($request->getPost('unpublish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($product, 'unpublish');
				$this->messenger->addMessage('Product Unpublished');
				$this->_redirect($url);


			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($product, 'delete');
				$this->messenger->addMessage('Product Deleted');
				$this->_redirect($this->getUrl('index'));

			}

		
		}
		
		public function addinventoryAction()
		{
			$request=$this->getRequest();
			
			$invProfile= new DatabaseObject_Invprofile($this->db);
			
			$invProfile->size = $request->getPost('inv-size');
			$invProfile->heel = $request->getPost('inv-heel');
			$invProfile->color = $request->getPost('inv-color');
			$invProfile->width = $request->getPost('inv-width');
			$invProfile->price = $request->getPost('inv-price');
			$invProfile->quantity = $request->getPost('inv-quantity');
			$invProfile->product_id = $request->getPost('product_id');
			$invProfile->save();
			
			//$this->_redirect($this->getUrl('preview').'?id='.$request->getPost('product_id'));
		
		}
		
		public function tagsAction()
		{
			$request=$this->getRequest();
			
			$product_id= $request->getPost('id');
			
			$product = new DatabaseObject_Product($this->db);
		
			if(!DatabaseObject_StaticUtility::loadObjectForUser($product, $this->identity->userID, $product_id, 'product_id'))
			{
				$this->_redirect($this->getUrl());

			}
			
			$tag = $request->getPost('tag');
			
			if($request->getPost('add'))
			{
				DatabaseObject_StaticUtility::addTagsToObject('products_tags', $product, $tag, 'product_id');	
				$this->messenger->addMessage('Categories added to product');
			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::deleteTagsForObject('products_tags', $product, $tag, 'product_id');
				$this->messenger->addMessage('Categories deleted for product');
			}
			
			
			$this->_redirect($this->getUrl('preview').'?id='.$product->getId());
		}
		
		public function categoriesAction()
		{
			$request=$this->getRequest();
			
			$product_id= $request->getPost('id');
			
			$product = new DatabaseObject_Product($this->db);
		
			if(!DatabaseObject_StaticUtility::loadObjectForUser($product, $this->identity->userID, $product_id, 'product_id'))
			{
				$this->_redirect($this->getUrl());

			}
			
			$tag = $request->getPost('category');
			
			if($request->getPost('add'))
			{
				DatabaseObject_StaticUtility::addTagsToObject('products_category', $product, $tag, 'product_id');	
				$this->messenger->addMessage('Categories added to product');
			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::deleteTagsForObject('products_category', $product, $tag, 'product_id');
				$this->messenger->addMessage('Categories deleted for product');
			}
			
			$this->_redirect($this->getUrl('preview').'?id='.$product->getId());
		}
		
		
		
		public function imagesAction()
		{
		
			$request= $this->getRequest();
			$json = array();
			
			
			$product_id=(int)$request->getPost('id');
			
			
			$product = new DatabaseObject_Product($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($product, $this->identity->userID, $product_id, 'product_id'))
			{
				////echo "you can not load this product";
				$this->_redirect($this->getUrl());

			}
			////echo "here";
			if($request->getPost('upload'))
			{
				$fp=new FormProcessor_Image($product);
				if($fp->process($request))
				{
					$this->messenger->addMessage('Image uploaded');
				}
				
				else
				{
					foreach($fp->getErrors() as $error)
					{
						$this->messenger->addMessage($error);
					}
				}
				
			}
			elseif($request->getPost('reorder'))
			{
				$order = $request->getPost('post_images');
				$product->setImageOrder($order);

			}
			elseif($request->getPost('delete'))
			{
				$image_id = (int) $request->getPost('image');
				
				
				$image = new DatabaseObject_Image($this->db);
				
				if($image->loadForPost($product->getId(), $image_id))
				{
					$image->delete(); //the files are unlinked/deleted at preDelete.
					////echo "image at delete";
					
					if($request->isXmlHttpRequest())
					{
						$json = array('deleted' =>true, 'image_id' =>$image_id);
					}
					else
					{
						$this->messenger->addMessage('Image deleted');
					}
				}
			}
			
			
			if($request->isXmlHttpRequest())
			{
				$this->sendJson($json);
			}
			else
			{
			$url = $this->getUrl('preview').'?id='.$product->getId();
			$this->_redirect($url);
			}
		}
	}
?>