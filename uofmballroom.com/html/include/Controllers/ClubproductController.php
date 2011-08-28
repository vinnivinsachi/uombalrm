<?php
	class ClubproductController extends Profilehelper
	{
		protected $user = null;
		protected $username;
			
		public function preDispatch()
		{
			
			//call parent mehtods to perform standard predispatch tasks
			parent::preDispatch('product', 'clubproduct','clubAdmin', 'L');
			
			
		}
		
		public function indexAction()
		{
			$product = new DatabaseObject_Product($this->db);
			
			$objects = parent::index($product, DatabaseObject_Product::PRODUCT_STATUS_LIVE,"clubproductarchive"); //parent returns a string.
			
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>$this->user->username, 'action'=>'index'), "clubproduct");
				
			$this->view->posts=$objects;
			
			$this->view->SecondTier = 'Fundraising';
		}
		
					
		public function viewAction()
		{
			
			$product = new DatabaseObject_Product($this->db);
				
			parent::view($product, 'product', 'clubproduct', 'clubproductarchive');
			
			
			$this->breadcrumbs->addStep($product->profile->name);
			//make the post availableto the template
			$this->view->post=$product;
			//*/
			$this->view->SecondTier = 'Fundraising';

		}
		
		public function postnotfoundAction()
		{
			$this->breadcrumbs->addStep('Post Not Found');
		
		}
		
		public function archiveAction()
		{
		
			$request=$this->getRequest();
			
			//initialize request date or month;
			$m = (int) trim($request->getUserParam('month'));
			$y = (int) trim($request->getUserParam('year'));
			
			$product = new DatabaseObject_Product($this->db);
			
			parent::archive($product, DatabaseObject_Product::PRODUCT_STATUS_LIVE, "clubproductarchive");
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>$this->user->username, 'year'=>$y, 'month'=>$m), "clubproductarchive");
			
			$this->view->archiveTime = $m.' / '.$y;
						$this->view->SecondTier = 'Fundraising';

		}
		
		public function clubnotfoundAction()
		{
			$username=trim($this->getRequest()->getUserParam('username'));
			
			$this->breadcrumbs->addStep('Club Not Found');
			$this->view->requestedUsername = $username;	
		}
		
		public function tagAction()
		{
			$request=$this->getRequest();

			
			$product = new DatabaseObject_Product($this->db);
			$tag = trim($request->getUserParam('tag'));

			$object = parent::tag($product, $tag,  DatabaseObject_BlogPost::STATUS_LIVE, 'clubproduct');
			
			$this->breadcrumbs->addStep('Product Category: '.$tag);
			$this->view->tag = $tag;

			$this->view->posts = $object;
						$this->view->SecondTier = 'Fundraising';

		}
	}

?>