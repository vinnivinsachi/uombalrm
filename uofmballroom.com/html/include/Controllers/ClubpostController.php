<?php
	class ClubpostController extends Profilehelper
	{

		public function preDispatch()
		{
			//call parent mehtods to perform standard predispatch tasks
			parent::preDispatch('post', 'clubpost', 'clubAdmin', 'L');
			$this->shoppingCart = new DatabaseObject_ShoppingCart($this->db);
			
			$this->cartObject=DatabaseObject_ShoppingCart::loadCart($this->db,$this->shoppingCart->getCartID());
			
			if(count($this->cartObject)>0)
			{
			
				$this->view->cartObject = $this->cartObject;
			
				$this->view->total = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
			}
		}
		
		public function indexAction()
		{
			
		
			$post = new DatabaseObject_BlogPost($this->db);
			$objects = parent::index($post, DatabaseObject_BlogPost::STATUS_LIVE); //parent returns a string.
			/*$this->view->paginationLink = $this->getCustomUrl(array('username'=>$this->user->username, 'action'=>'index'), "clubpost");*/
			$this->view->posts=$objects;

		}
					
	
		public function viewAction()
		{
		
			$post = new DatabaseObject_BlogPost($this->db);
				
			parent::view($post, 'post', 'clubpost', 'clubpostarchive');
			
			
			$this->breadcrumbs->addStep($post->profile->title);
			//make the post availableto the template
			$this->view->post=$post;
		
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
			
			$post = new DatabaseObject_BlogPost($this->db);
			
			parent::archive($post, DatabaseObject_BlogPost::STATUS_LIVE, "clubpostarchive");
		
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>$this->user->username, 'year'=>$y, 'month'=>$m), "clubpostarchive");
	
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

			
			$post = new DatabaseObject_BlogPost($this->db);
			$tag = trim($request->getUserParam('tag'));

			$object = parent::tag($post, $tag,  DatabaseObject_BlogPost::STATUS_LIVE, 'clubposttagspace');
			
			$this->breadcrumbs->addStep('Post Category: '.$tag);
			$this->view->tag = $tag;

			$this->view->posts = $object;
		}
		
		public function catAction()
		{
			$request=$this->getRequest();
			
			$post = new DatabaseObject_BlogPost($this->db);
			$cat = trim($request->getQuery('cat'));
			
			$brand = trim($request->getQuery('category'));
			
			$this->view->SecondTier = $brand; 
			
			$this->view->lightwindow='true';

			$style = trim($request->getQuery('tags'));
			
			//$object = parent::tag($product, $tag,  DatabaseObject_BlogPost::STATUS_LIVE, 'clubproduct');
			
			if(strlen($brand)==0)
			{
				$brand = "none";
			}
			else
			{
				$this->view->brandView = $brand;
			}
			
			if(strlen($style)==0)
			{
				$style = "none";
			}
			else
			{
				$this->view->styleView = $style;
			}
			
			if(strlen($cat)==0)
			{
				$cat = "none";
				/*$this->_redirect($this->getCustomUrl(array('username' => $this->user->username, 'action' => 'index'), $profileRoute));*/
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>$this->user->username), 'clubpost').'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			//echo "cat is: ".$cat;
			
			if($cat !="none")
			{
				//This gets all the appropirate category tages for left column menu
				$objects =DatabaseObject_BlogPost::getCatTagSummary($this->db, 1, $cat);
				
				
				
				if(count($objects)==0)
				{
				$this->messenger->addMessage('Sorry, no BlogPost were found with this tag');
				$this->_redirect('index');
				}
				else
				{
				$this->view->brand_cats = $objects;

				}
			
			}
			$this->view->alphabetLink = $this->alphabetLink;
			$this->view->currentAlphabet = $alphabet;		

			//return $objects;
			
			$this->breadcrumbs->addStep('Category: '.$cat, '/clubpost/uofmballroom/cat/?cat='.$cat);
			$this->view->cat = $cat;
			$this->view->thirdTierTag = $style;
						$this->view->Banner='true';

			
			$options = array(
				'user_id' =>1,
				'alphabetLink'  => $alphabet,
				'cat' =>$cat,
				'brand' =>$brand,
				'style' =>$style,
				'status' =>'L',
				'order' =>'p.ts_created desc'
			);
			
			$products = $post->GetObjects($this->db, $options);
			
			//echo "here"."<br/>";
			//echo "style".$style."<br/>";
			//echo "brand".$brand."<br/>";
			
			$this->view->objects = $products;
		}
		
		
		public function secondtierAction() 
		{
			//echo "here";
			$request=$this->getRequest();
			
			$post = new DatabaseObject_BlogPost($this->db);
			
			$style = trim($request->getQuery('value'));
			
			//$object = parent::tag($product, $tag,  DatabaseObject_BlogPost::STATUS_LIVE, 'clubproduct');
			
			$this->view->SecondTier = $style; 
			
			if(strlen($style)==0)
			{
				$style = "none";
			}
			else
			{
				$this->view->styleView = $style;
			}
			
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>$this->user->username), 'clubpost').'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			//echo "cat is: ".$cat;
			
			/*if($cat !="none")
			{
				//This gets all the appropirate category tages for left column menu
				$objects =DatabaseObject_BlogPost::getCatTagSummary($this->db, 1, $cat);
				
				
				
				if(count($objects)==0)
				{
				$this->messenger->addMessage('Sorry, no BlogPost were found with this tag');
				$this->_redirect('index');
				}
				else
				{
				$this->view->brand_cats = $objects;

				}
			
			}*/
			$this->view->alphabetLink = $this->alphabetLink;
			$this->view->currentAlphabet = $alphabet;		

			//return $objects;
			
			//$this->breadcrumbs->addStep('Category: '.$cat, '/clubpost/uofmballroom/cat/?cat='.$cat);
			//$this->view->cat = $cat;

			
			$options = array(
				'user_id' =>1,
				'alphabetLink'  => $alphabet,
				//'cat' =>$cat,
				'brand' =>'Second Tier',
				'style' =>$style,
				'status' =>'L',
				'order' =>'p.ts_created asc'
			);
			
			$products = $post->GetObjects($this->db, $options);
			
			//echo "here1";
			
			$this->view->objects = $products;
					$this->view->Banner='true';

		}
		
		public function competitionAction()
		{
		
			$post = new DatabaseObject_BlogPost($this->db);
			
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>'uofmballroom', 'action'=>'competition'), 'clubpost').'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			
			
			//-------------------------------This might be simplified simply retrieve the count of objects-----------
			$options = array('user_id' =>'1',
			                 'status' =>DatabaseObject_BlogPost::STATUS_LIVE,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc',
							 'brand' =>'News',
							 'style' =>'Competition'

							);
							
			$objects = $post->GetObjects($this->db, $options); 
			
			$this->currentTotalPage = ceil(count($objects)/10);
			$this->view->currentTotalPage = $this->currentTotalPage;
			//echo "<br/>currentToalPage: ".$this->currentTotalPage;
			$this->view->currentPage = 1; 
			
			//--------------------One might create a new database that contains the objects amounts of the users
			//example: chinamannnz: product: 5, events: 7, memberships: 10
			//--------------------------------------------------------------------------------------------------------
			
			if(strlen($pageNumber)==0)
			{
				$options = array('user_id' =>'1',
							 'limit'=>1,
			                 'status' =>DatabaseObject_BlogPost::STATUS_LIVE,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc',
							 'brand' =>'News',
							 'style' =>'Competition'

							);
							
				$objects = $post->GetObjects($this->db, $options); 	
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array('user_id' =>'1',
							 'limit'=>$pageNumber,
			                 'status' =>DatabaseObject_BlogPost::STATUS_LIVE,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc',
							 'brand' =>'News',
							 'style' =>'Competition'

							);
							
				$objects = $post->GetObjects($this->db, $options); 
				$this->view->currentPage=$pageNumber;
			}
			
			
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;					
			
			
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>'uofmballroom', 'action'=>'index'), "clubpost");
			
			
			//echo "here";
			$this->view->posts=$objects;
			
			$this->view->SecondTier='Competition';
			$this->view->Banner='true';
			//$this->_helper->viewRenderer->setNoRender(); 
			//header('Content-type: text/xml');  
			//echo "<response><data><row><answer>Yes</answer></row></data></response>";
		
		
		}
	
	}
?>