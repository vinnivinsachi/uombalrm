<?php
	/***********************************************************
	**profilehelper is a utitlity controller that manages
	**Posts/Products/Events ONLY
	**Membership does NOT use this profile helper
	***********************************************************/
	
	class Profilehelper extends CustomControllerAction
	{
		protected $user = null;
		protected $username;
		
		protected $profileRouterDirect;
		protected $currentTotalProduct;
		protected $currentTotalPage;
		
		public function preDispatch($profileType, $profileRouter, $user_type, $status)
		{
			parent::preDispatch();
			
			
			$this->profileRouterDirect = $profileRouter;
			
			$this->auth=Zend_Auth::getInstance();
			
			
			$_SESSION['categoryType'] = $profileType;
			//retrieve request object so we can access requested user and action.
			$request = $this->getRequest();
			//check if already dispatching the user not found action. if we are
			//then we don't want to execute the remainder of this method.
			
			if(strtolower($request->getActionName()) =='clubnotfound') //returns like index, view, register,  and stuff like that.
			{
				return;
			}
			//retrieve username from request and clean the string //returns a single user param. 
			$this->username = 'uofmballroom';
			//echo $username;
			//if no username is present, redirect to site home page
			//$this->clubObject = trim($request->getUserParam('object'));
			if(strlen($this->username)==0)
			{
				//echo "here at unable to load username";
				//$this->_redirect($this->getUrl('index','index'));
			}		
			$_SESSION['clubUsername'] = $this->username;
			//load the user, based on username in request. if the user record is not loaded then forward
			//to notFoundAction so a 'user not found message can be shown to the user. 
			$this->user = new DatabaseObject_User($this->db);
			
			if(!$this->user->loadByUsername($this->username, $user_type, $status))
			{
				$this->view->noUser = TRUE;
				//$this->_forward('clubNotFound');
				return;
			}
			//echo $_SESSION['clubUsername'];
			//add a link to the breadcrumbs so all actions in this controller 
			//link back to the user home page //we can put the organization's name on here. 
			$this->view->cartID = $this->shoppingCart->getCartID();
			
			$this->breadcrumbs->addStep(
				$this->user->profile->public_club_name. "s ".$profileType,
				$this->getCustomUrl(array('username' =>$this->user->username, 'action'=>'index'), $profileRouter));
			$this->view->user=$this->user; //making the user available in all templates in this controller. because it is in predispatch.
			
			//echo $this->username;			
			
			$affiliation= new DatabaseObject_Affiliation($this->db);
			$request = $this->getRequest();
			
		
			$this->username = trim($request->getUserParam('username'));
			
			
			$_SESSION['clubUsername'] = $this->username;
			
			$this->club = new DatabaseObject_User($this->db);
			
			if($this->club->loadByUsername($this->username, 'clubAdmin', 'L'))  //check to see if request is related with clubuser
			{
				$this->secondMember=$this->club;
				if(isset($this->auth->getIdentity()->userID)&& $this->auth->getIdentity()->user_type == 'member')
				{
					//echo "your user_type is: ".$auth->getIdentity()->user_type;
					

					if($affiliation->checkAffiliation($this->auth->getIdentity()->userID, $this->club->getId()))
					{
						$this->view->requestAffilButtonActive = true;
						//$this->affiliated = true;
					}
					else
					{
						
						$this->view->requestAffilButtonActive = false;
						//$this->affiliated = true;
					}
					
				}
				elseif(isset($this->auth->getIdentity()->userID)&& $this->auth->getIdentity()->user_type == 'clubAdmin')
				{
				
					
					$this->view->requestAffilButtonActive = true;
				}
				else
				{
					//echo "your user_type3 is: ".$auth->getIdentity()->user_type;
					$this->affiliated = true;
					$this->view->requestAffilButtonActive = false;
				}
			}
			elseif($this->club->loadByUsername($this->username, 'member', 'L'))//check to see if request is related with member
			{
				$this->secondMember=$this->club;
				if($affiliation->checkAffiliation( $this->club->getId(), $this->auth->getIdentity()->userID)) //member is not the club(memberuser), and club is now the logged in clubAdmin.
				{
					//echo "you are at here: with true affiliated.";
					$this->affiliated = true;
					//$this->affiliated = true;
				}
				else
				{
					//echo "you are at here: with false affiliated.";
					$this->affiliated = false;
					//$this->affiliated = true;
				}
				$this->view->requestAffilButtonActive = true;
			}			
			
			
		}
		
		public function index(DatabaseObject &$object, $status) //returns a databasestring object
		{
		
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>$this->user->username, 'action'=>'index'), $this->profileRouterDirect).'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			
			
			//-------------------------------This might be simplified simply retrieve the count of objects-----------
			$options = array('user_id' =>$this->user->getId(),
			                 'status' =>$status,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc'
							);
							
			$objects = $object->GetObjects($this->db, $options); 
			
			$this->currentTotalPage = ceil(count($objects)/10);
			$this->view->currentTotalPage = $this->currentTotalPage;
			//echo "<br/>currentToalPage: ".$this->currentTotalPage;
			$this->view->currentPage = 1;
			
			//--------------------One might create a new database that contains the objects amounts of the users
			//example: chinamannnz: product: 5, events: 7, memberships: 10
			//--------------------------------------------------------------------------------------------------------
			
			if(strlen($pageNumber)==0)
			{
				$options = array('user_id' =>$this->user->getId(),
							 'limit'=>1,
			                 'status' =>$status,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc'
							);
							
				$objects = $object->GetObjects($this->db, $options); 	
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array('user_id' =>$this->user->getId(),
							 'limit'=>$pageNumber,
			                 'status' =>$status,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc'
							);
							
				$objects = $object->GetObjects($this->db, $options); 
				$this->view->currentPage=$pageNumber;
			}
			
			
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;		
			
			
			return $objects;
			
			
			
		}
		
		public function view(DatabaseObject &$object, $profileType, $profileRouter, $archiveRouter)
		{
			$request=$this->getRequest();
			$url = trim($request->getUserParam('url'));
			
			//if no URL was specified, return to the user home page
			if(strlen($url)==0)
			{
				$this->_redirect($this->getCustomUrl(array('username' =>$this->user->username), $profileRouter)
				);
				
			}
			
			echo "this user id is: ".$this->user->getId();
			
			$object->loadLiveObject($this->user->getId(), $url); // the user is got from pre dispatch.
			
			$object->getImages();
		
			//if the post wasn't loaded redirect to post not found
			if(!$object->isSaved())
			{
				$this->_forward('postNotFound');
				return;
			}
			
			$archiveOptions = array(
						'username'=>$this->user->username,
						'year'=>date('Y', $object->ts_created),
						'month'=>date('m', $object->ts_created)
						);
			
			$this->breadcrumbs->addStep(date('F Y', $object->ts_created), $this->getCustomUrl($archiveOptions, $archiveRouter));	
		}
		
		public function archive(DatabaseObject $object, $status, $router)
		{
			
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>$this->user->username), $router).'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			$request=$this->getRequest();
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			//initialize request date or month;
			$m = (int) trim($request->getUserParam('month'));
			$y = (int) trim($request->getUserParam('year'));
			
			//ensure month is in range 1-12
			$m = max(1, min(12, $m));
			
			
			
			//generate start and finish timestamp for the given month/year
			$from = mktime(0,0,0, $m, 1, $y);
			
			$to = mktime(0,0,0, $m+1, 1, $y)-1;
			
			//get live post based on the time stampp
			
			$options = array(
					'user_id' =>$this->user->getId(),
					'alphabetLink'  => $alphabet,
					'from'=>date('Y-m-d H:i:s', $from),
					'to' =>date('Y-m-d H:i:s', $to),
					'status' => $status,
					'order' =>'p.ts_created desc');
				
			$objects = $object->GetObjects($this->db, $options);
			
			$this->currentTotalPage = ceil(count($objects)/10);
			$this->view->currentTotalPage = $this->currentTotalPage;
		//	echo "<br/>currentToalPage: ".$this->currentTotalPage;
			$this->view->currentPage = 1;
			
			
			if(strlen($pageNumber)==0)
			{
				$options = array('user_id' =>$this->user->getId(),
								'alphabetLink'  => $alphabet,
								'limit' =>1,
								'from'=>date('Y-m-d H:i:s', $from),
								'to' =>date('Y-m-d H:i:s', $to),
								'status' => $status,
								'order' =>'p.ts_created desc'
							);
							
				$objects = $object->GetObjects($this->db, $options); 	
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array('user_id' =>$this->user->getId(),
							 'alphabetLink'  => $alphabet,
							'limit'=>$pageNumber,
							'from'=>date('Y-m-d H:i:s', $from),
							'to' =>date('Y-m-d H:i:s', $to),
							'status' => $status,
							'order' =>'p.ts_created desc'
							);
							
				$objects = $object->GetObjects($this->db, $options); 
				$this->view->currentPage=$pageNumber;
			}
			
			
			
			$this->breadcrumbs->addStep(date('F Y', $from));
			$this->view->alphabetLink = $this->alphabetLink;
			$this->view->currentAlphabet = $alphabet;		

			$this->view->month = $from;
			$this->view->posts = $objects;
		
		}
		
		public function tag(DatabaseObject $object, $tag, $status, $profileRoute)
		{
			
			if(strlen($tag)==0)
			{
				$this->_redirect($this->getCustomUrl(array('username' => $this->user->username, 'action' => 'index'), $profileRoute));
			}
			
			$request=$this->getRequest();
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>$this->user->username), $profileRoute).'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			
			$options = array(
				'user_id' =>$this->user->getId(),
				'alphabetLink'  => $alphabet,
				'tag' =>$tag,
				'status' =>$status,
				'order' =>'p.ts_created desc'
			);
			
			$objects = $object->GetObjects($this->db, $options);
			
			if(count($objects)==0)
			{
			$this->messenger->addMessage('no prmotion found');
			$this->_redirect($this->getUrl('index','index'));
			}
			$this->view->alphabetLink = $this->alphabetLink;
			$this->view->currentAlphabet = $alphabet;		

			return $objects;
		}
	}
?>