<?php

	class EventmanagerController extends CustomControllerAction
	{
		protected $databaseColumn='event_id';
	
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('event manager', $this->getUrl(null, 'eventmanager'));
			$this->identity=Zend_Auth::getInstance()->getIdentity();
			$user = new DatabaseObject_User($this->db);
			if($user->loadByUserId($this->identity->userID))
			{
			$this->view->clubManager =$user;
			}
			$_SESSION['categoryType'] = 'event';
			$this->view->currentTime = time();
		}
	
		public function indexAction()
		{
			$tag = $this->getRequest()->getQuery('tag');

			$month = $this->getRequest()->getQuery('month');
			
			$totalPosts = DatabaseObject_Event::GetObjectsCount($this->db, array('user_id'=>$this->identity->userID));

			if(isset($tag) && !isset($month))
			{
				////echo "tag: ".$tag;
				$options = array(
				'user_id' =>$this->identity->userID,
				'tag' =>$tag,
				'status' =>DatabaseObject_BlogPost::STATUS_LIVE,
				'order' =>'p.ts_created desc');
			
				$recentPosts = DatabaseObject_Event::GetObjects($this->db, $options);
			
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
				
				$recentPosts = DatabaseObject_Event::GetObjects($this->db, $options);
				
				//get the total number of posts for this user
				
				
				$this->view->month = $from;
				$this->view->recentPosts = $recentPosts;
			}
			
			$this->view->totalPosts = $totalPosts;
			

	
		}	
			
		public function editAction()
		{
			$request = $this->getRequest();
			
			$event_id = $request->getQuery('id');
			
			
			$fp = new FormProcessor_Event($this->db, $this->identity->userID, $event_id);
			
			if($request->isPost())
			{
				////echo "<br/> Posted";
				if($fp->process($request))
				{
					$url=$this->getUrl('preview').'?id='.$fp->event->getId();
					$this->_redirect($url);
				}
				else
				{
					//echo "you have an ERROR in your post!!!!";
				}
			}
			
			if($fp->event->isSaved())
			{
				////echo"<br/> you are at $fp->post->isSaved())";
				$this->breadcrumbs->addStep('Preview Event: '.$fp->event->profile->name, 
				$this->getUrl('preview').'?id='.$fp->event->getId());
				
				$this->breadcrumbs->addStep('Edit Event');
			}
			else
			{
				$this->breadcrumbs->addStep('Create a New Event');
			}
			
			$this->view->fp = $fp;
		}
		
		public function previewAction()
		{
			$request=$this->getRequest();
			
			$id = (int)$request->getQuery('id');
			
			$event = new DatabaseObject_Event($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($event, $this->identity->userID, $id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			$tags = DatabaseObject_StaticUtility::getTagsForObject($event, 'events_tags', 'event_id'); 
			
			
			$event->getImages();
			
			$this->breadcrumbs->addStep('Preview Post: '.$event->profile->name);
			$this->view->tags = $tags;
			
			$this->view->event = $event;
			
		
		}
		
		public function setstatusAction()
		{
			$request=$this->getRequest();
			
			$event_id =(int) $request->getPost('id'); //grabbing stuff form post.
			
			
			$event = new DatabaseObject_Event($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($event, $this->identity->userID, $event_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			$url = $this->getUrl('preview').'?id='.$event->getId();
			
			if($request->getPost('edit')) //grabbing stuff from post.
			{
				$this->_redirect($this->getUrl('edit').'?id='.$event->getId());
			}
			else if($request->getPost('publish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($event, 'publish');
				$this->messenger->addMessage('Event sent live');
			}
			else if($request->getPost('unpublish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($event, 'unpublish');
				$this->messenger->addMessage('Event unpublished');
			}
			else if($request->getPost('delete'))
			{
				
				DatabaseObject_StaticUtility::setObjectStatusAction($event, 'delete');
				//Preview page no longer exists for this page so go back to index.
				$url = $this->getUrl();
				$this->messenger->addMessage('Post deleted');
			}
			
			
			$this->_redirect($url);
		}
		
	
		public function testAction()
		{
			$request=$this->getRequest();
			
			$id=$request->getQuery('id');
			
			$event = new DatabaseObject_Event($this->db);
			$event->eventTestLoad($id);
			$event->delete();
		}
		
		public function tagsAction()
		{
			$request= $this->getRequest();
			
			$post_id = (int) $request->getPost('id');
			
			$post = new DatabaseObject_Event($this->db);
			

		    
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			$tag = $request->getPost('tag');
		
			if($request->getPost('add'))
			{
			
				DatabaseObject_StaticUtility::addTagsToObject('events_tags', $post, $tag, 'event_id');
				
				$this->messenger->addMessage('Category added to post');
			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::deleteTagsForObject('events_tags', $post, $tag, 'event_id');
				$this->messenger->addMessage('Category removed form post');
			}
			
			$this->_redirect($this->getUrl('preview').'?id='.$post->getId());
			
		}
		
		
		
		public function imagesAction()
		{
			$request=$this->getRequest();
			
			$json = array();
			

			$post_id=(int) $request->getPost('id');
			
			$post = new DatabaseObject_Event($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($post, $this->identity->userID, $post_id, $this->databaseColumn))
			{
				$this->_redirect($this->getUrl());
			}
			
			////echo "here1";
			if($request->getPost('upload'))
			{
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
				////echo "you are at after setimageorder";
				
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