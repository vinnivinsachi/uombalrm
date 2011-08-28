<?php

	class BlogmanagerController extends CustomControllerAction
	{
		private $databaseColumn = 'post_id';
		public function init()
		{
			parent::init();
			$this->breadcrumbs->addStep('Account', $this->getUrl(null, 'account'));
			$this->breadcrumbs->addStep('Blog Manager', $this->getUrl(null, 'blogmanager'));
			$this->identity=Zend_Auth::getInstance()->getIdentity(); //which have a bunch of information about the person. 
			$_SESSION['categoryType'] = 'post';	
		}
		
		public function indexAction()
		{
			//initialize the month
			$tag = $this->getRequest()->getQuery('tag');

			$month = $this->getRequest()->getQuery('month');
			
			$cat = $this->getRequest()->getQuery('cat');


						
			$totalPosts = DatabaseObject_BlogPost::GetObjectsCount($this->db, array('user_id'=>$this->identity->userID));
			
			//echo "identity id is: ".$this->identity->userID;
			//echo "totalPost is: ".$totalPosts;

			if(isset($tag) && !isset($month))
			{
				////echo "tag: ".$tag;
				$options = array(
				'user_id' =>$this->identity->userID,
				'tag' =>$tag,
				'order' =>'p.ts_created desc');
			
				$recentPosts = DatabaseObject_BlogPost::GetObjects($this->db, $options);
			
				$this->view->tagPosts = $recentPosts;
				$this->view->tag = $tag;

			}
			
			if(isset($cat))
			{
				$options = array(
				'user_id' =>$this->identity->userID,
				'brand' =>$cat,
				'order' =>'p.ts_created desc');
			
				$recentPosts = DatabaseObject_BlogPost::GetObjects($this->db, $options);
				
				//echo "here";
				
				$this->view->tagPosts = $recentPosts;
				$this->view->tag = $tag;
			}
			
			
			if(isset($month) && !isset($tag))
			{
				
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
				
				$recentPosts = DatabaseObject_BlogPost::GetObjects($this->db, $options);
				
				//get the total number of posts for this user
				
				
				$this->view->month = $from;
				$this->view->recentPosts = $recentPosts;
			}
			
			
			$this->view->totalPosts = $totalPosts;

		}
		
		public function editAction()
		{
			$request=$this->getRequest();
			$post_id = (int)$this->getRequest()->getQuery('id');
			////echo "current post_ID is: ".$post_id;
			
			////echo "<br/>current user ID is: ".$this->identity->userID;
			
			$fp= new FormProcessor_BlogPost($this->db, $this->identity->userID, $post_id);
			if($request->isPost())
			{
				////echo "<br/> Posted";
				if($fp->process($request))
				{
					$url=$this->getUrl('preview').'?id='.$fp->post->getId();
					$this->_redirect($url);
				}
			}
			
			if($fp->post->isSaved())
			{
				////echo"<br/> you are at $fp->post->isSaved())";
				$this->breadcrumbs->addStep(
				'Preview Post: '.$fp->post->profile->title, 
				$this->getUrl('preview').'?id='.$fp->post->getId());
				
				$this->breadcrumbs->addStep('Edit Post');
			}
			else
			{
				$this->breadcrumbs->addStep('Create a New Blog Post');
			}
			
			$this->view->fp=$fp;
		}
			
		public function previewAction()
		{
			
			$post_id=(int)$this->getRequest()->getQuery('id');
			
						
			$post= new DatabaseObject_BlogPost($this->db);
			
			$options['status']='ALL';  
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn, $options))
			{
			
				$this->_redirect($this->getUrl());
			
			}
			
			$post->getImages();	
			$this->breadcrumbs->addStep('Preview Post: '.$post->profile->title);
			$tags = DatabaseObject_StaticUtility::getTagsForObject($post, 'blog_posts_tags', 'post_id'); 
			$categories = DatabaseObject_StaticUtility::getTagsForObject($post, 'blog_posts_category','post_id');

			$this->view->post = $post;
			$this->view->tags = $tags;
			$this->view->categories = $categories;
			$this->view->lightwindow='true';
			
		}
			
		public function setstatusAction()
		{
			$request=$this->getRequest();
			
			$post_id =(int) $request->getPost('id'); //grabbing stuff form post.
			
			
			$post = new DatabaseObject_BlogPost($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			$url = $this->getUrl('preview').'?id='.$post->getId();
			
			if($request->getPost('edit')) //grabbing stuff from post.
			{
				$this->_redirect($this->getUrl('edit').'?id='.$post->getId());
			}
			else if($request->getPost('publish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($post, 'publish');
				$this->messenger->addMessage('Post sent live');
			}
			else if($request->getPost('unpublish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($post, 'unpublish');
				$this->messenger->addMessage('Post unpublished');
			}
			else if($request->getPost('delete'))
			{
				
				DatabaseObject_StaticUtility::setObjectStatusAction($post, 'delete');
				//Preview page no longer exists for this page so go back to index.
				$url = $this->getUrl();
				$this->messenger->addMessage('Post deleted');
			}
			
			$this->_redirect($url);
		}
		
		//---------------------------------------------Now Tagging Action-----------------
		
		public function tagsAction()
		{
			$request= $this->getRequest();
			
			$post_id = (int) $request->getPost('id');
			
			$post = new DatabaseObject_BlogPost($this->db);
			

		    
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			$tag = $request->getPost('tag');
		
			if($request->getPost('add'))
			{
			
				DatabaseObject_StaticUtility::addTagsToObject('blog_posts_tags', $post, $tag, 'post_id');
				
				$this->messenger->addMessage('Tags added to post');
			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::deleteTagsForObject('blog_posts_tags', $post, $tag, 'post_id');
				$this->messenger->addMessage('Tags removed form post');
			}
			
			$this->_redirect($this->getUrl('preview').'?id='.$post->getId());
			
		}
		
		public function categoriesAction()
		{
			$request=$this->getRequest();
			
			$post_id= $request->getPost('id');
			
			$post = new DatabaseObject_BlogPost($this->db);
		
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());

			}
			
			$tag = $request->getPost('category');
			
			if($request->getPost('add'))
			{
				DatabaseObject_StaticUtility::addTagsToObject('blog_posts_category', $post, $tag, 'post_id');	
				$this->messenger->addMessage('Categories added to post');
			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::deleteTagsForObject('blog_posts_category', $post, $tag, 'post_id');
				$this->messenger->addMessage('Categories deleted for post');
			}
			
			$this->_redirect($this->getUrl('preview').'?id='.$post->getId());
		}
		
		
		// first create image action that handles the upload of images
		//then create the image formprocess function that validates the imagefile and stores the file (that saves)
		//then create the image dataobject function that actually inserts and uploads that (preinsert and postinserts)
		//then create the utility function that loads back the image onto the screen.
		
		
		public function imagesAction()
		{
			$request=$this->getRequest();
			
			$json = array();
			

			$post_id=(int) $request->getPost('id');
			
			$post = new DatabaseObject_BlogPost($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			////echo "here1";
			if($request->getPost('upload'))
			{
				//echo "here";
				$fp=new FormProcessor_Image($post);
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
			else if($request->getPost('reorder'))
			{
			
				$order=$request->getPost('post_images');
				$post->setImageOrder($order);
			}
			else if($request->getPost('delete'))
			{
				$image_id = (int) $request->getPost('image');
				
				
				$image = new DatabaseObject_Image($this->db);
				
				if($image->loadForPost($post->getId(), $image_id))
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
			
			$url = $this->getUrl('preview').'?id='.$post->getId();
			$this->_redirect($url);
			}
		}
		
		
	}
	
?>