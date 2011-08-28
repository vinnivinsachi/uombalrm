<?php
	
	//this is purelly for duepayment management for MEMBERS to manager their club dues. 
	
	
	class AffiliationmanagerController extends CustomControllerAction
	{
		protected $member;
		protected $club;
		public function preDispatch()
		{
			parent::preDispatch();
			
			$auth=Zend_Auth::getInstance();
			if($auth->hasIdentity())
			{
				
				$id=$auth->getIdentity()->userID; //the value in idenity is passed into the page that called it.
				$this->member = new DatabaseObject_User($this->db);
				$this->member->loadByUserId($id);
			
			}
			//------------------------member established----------------------
		}
		
		
		public function indexAction()
		{	
			$request=$this->getRequest();
			$clubname = trim($request->getParam('username'));
			////echo "clubnameis : ".$clubname;
			$affiliations = DatabaseObject_Affiliation::loadMemberAffiliation($this->db, $this->member->getId(), 'confirmed');
			
			//echo "your affiliation number is: ".count($affiliations);
			
			$clubIdArray = array();
			
			foreach($affiliations as $k=>$v)
			{
				$clubIdArray[]=$affiliations[$k]['clubAdmin_id'];
			}
			
			//echo "<br/>clubArray count: ".count($clubIdArray);
			
			if(count($clubIdArray)>0) //check if there is any affiliations in the system
			{
			
				$options= array('limit' 		=> 1,
								'user_type' 	=> 'clubAdmin',
								'university' 	=> 'all',
								'status'    	=> 'L',
								'userID'		=> $clubIdArray);
								
				$_SESSION['categoryType'] = 'clubImage';
	
				$users = new DatabaseObject_User($this->db);
	
				$objects = $users->GetObjects($this->db, $options); 
				////echo "here";
				////echo "users count: ".count($objects);
				$this->view->users = $objects;
			}
			
			$this->view->affiliation = $affiliations;
			$this->breadcrumbs->addStep('affiliations', $this->geturl('index'));

		}
		
		public function requestAction()
		{
			
			$request=$this->getRequest();
			$clubname = trim($request->getParam('username'));
		
			if(strlen($clubname)==0)
			{
				$this->_redirect($this->getUrl('index','index'));
			}	
				
		
			$this->club = new DatabaseObject_User($this->db);
			
			if(!$this->club->loadByUsername($clubname, 'clubAdmin', 'L'))
			{
				$this->_forward('clubNotFound');
				return;
			}
		
			
			$affiliation= new DatabaseObject_Affiliation($this->db);
			
			if(!$affiliation->checkAffiliation($this->member->getId(), $this->club->getId()))
			{
				 $affiliation->setAffiliation($this->member->getId(), $this->club->getId());
				 $affiliation->save();
				 
				 //$this->view->members = $this->member; 
				 $this->view->user = $this->club;
				 
				 $this->club->sendEmail('affiliate-notice.tpl', $this->member);
				 
				 $this->messenger->addMessage('Your request has been sent to the club, you will be able to purchase and view individual dues once it is approved.');
				 
				 $this->_redirect($this->getCustomUrl(array('username' =>$clubname), 'clubpreview'));


			}
			else
			{
				$this->_forward('clubAlreadyAffiliated');
				return;
			}
			
		}
		
		public function clubnotfoundAction()
		{
			////echo "your club affiliation request could not be completed";
		}
		
		public function clubalreadyaffiliatedAction()
		{
			////echo "you are already affiliated with this club";
		}
		
		
		
		
		
	}
?>