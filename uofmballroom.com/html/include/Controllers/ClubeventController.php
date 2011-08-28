<?php
	class ClubeventController extends Profilehelper
	{
		protected $user = null;
		protected $username;
			
		public function preDispatch()
		{
			
			//call parent mehtods to perform standard predispatch tasks
			parent::preDispatch('event', 'clubevent','clubAdmin', 'L');
			$this->view->currentTime = time();
		}
		
		public function indexAction()
		{
			$event = new DatabaseObject_Event($this->db);
			$request= $this->getRequest();
			$cat = $request->getParam('cat');
			
			$objects = parent::index($event, DatabaseObject_Event::EVENT_STATUS_LIVE, "clubeventarchive"); //parent returns a string.
			
			
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>$this->user->username, 'action'=>'index'), "clubevent");

			$this->view->posts=$objects;
			
			$this->view->SecondTier = 'Competition';
			$this->view->cat = $cat;
			

		}
		
					
		public function viewAction()
		{
			
			$event = new DatabaseObject_Event($this->db);
				
			parent::view($event, 'event', 'clubevent', 'clubeventarchive');
			
			
			$this->breadcrumbs->addStep($event->profile->title);
			//make the post availableto the template
			$this->view->post=$event;
			//*/
						$this->view->SecondTier = 'New Members';

		}
		
		public function postnotfoundAction()
		{
			$this->breadcrumbs->addStep('Event Not Found');
		
		}
		
		public function archiveAction()
		{
			$request=$this->getRequest();
			
			//initialize request date or month;
			$m = (int) trim($request->getUserParam('month'));
			$y = (int) trim($request->getUserParam('year'));
			
			$event = new DatabaseObject_Event($this->db);
			
			parent::archive($event, DatabaseObject_Event::EVENT_STATUS_LIVE,"clubeventarchive");
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>$this->user->username, 'year'=>$y, 'month'=>$m), "clubeventarchive");
			
						$this->view->SecondTier = 'New Members';
						
						$this->view->archiveTime= $m.' / '.$y;

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

			
			$event = new DatabaseObject_Event($this->db);
			$tag = trim($request->getUserParam('tag'));
			
			$cat = trim($request->getParam('cat'));
			$this->view->cat = $cat;

			$object = parent::tag($event, $tag,  DatabaseObject_Event::EVENT_STATUS_LIVE, 'clubevent');
			
			$this->breadcrumbs->addStep('Product Category: '.$tag);
			$this->view->tag = $tag;

			$this->view->posts = $object;
			
						$this->view->SecondTier = 'New Members';

		}
		
		public function spectatorticketAction(){
				$request=$this->getRequest();
			
			$fp = new FormProcessor_Spectatorticket($this->db);

			if($request->isPost())
			{
				if($fp->process($request))
				{
					$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&upload=1&business=ballroom-exec@umich.edu";

					if($fp->adultFullDayPass>0){

						$query .= "&item_name_1=Michigan Ballroom Competition Adult Full Day Pass";	
						$query .="&amount_1=10";
						$query .="&quantity_1=".$fp->adultFullDayPass;
						}
						else{
						$query .= "&item_name_1=Michigan Ballroom Competition Adult Full Day Pass";	
						$query .="&amount_1=0";
						$query .="&quantity_1=1";
						}

					
					
					if($fp->adultNightPass>0)
					{
						$query .= "&item_name_2=Michigan Ballroom Competition Adult Night Pass";	
						$query .="&amount_2=8";
						$query .="&quantity_2=".$fp->adultNightPass;
					}
					else{
						$query .= "&item_name_2=Michigan Ballroom Competition Adult Night Pass";	
						$query .="&amount_2=0";
						$query .="&quantity_2=1";
					}
					
					if($fp->studentPass>0)
					{
						$query .= "&item_name_3=Michigan Ballroom Competition Student Pass";	
						$query .="&amount_3=5";
						$query .="&quantity_3=".$fp->studentPass;
					}else{
						$query .= "&item_name_3=Michigan Ballroom Competition Student Pass";	
						$query .="&amount_3=0";
						$query .="&quantity_3=1";
						
					}
					
					
					$query .= "&return=http://www.uofmballroom.com"."&cancel_return=http://www.uofmballroom.com/registration/spectatorticket";  
		
					//echo "query is: ".$query;
					$this->_redirect($query);
					
				}
			}
			
			$this->view->fp = $fp;
		}
	}

?>