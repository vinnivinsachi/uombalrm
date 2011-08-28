<?php
	class ClubmemberdueController extends CustomControllerAction
	{
		
		protected $user = null;
		protected $username;
		
		public function preDispatch()
		{
			//$this->_redirect($this->getUrl('index', 'index'));	
			parent::preDispatch();
			//call parent mehtods to perform standard predispatch tasks
			$this->signedInUser=Zend_Auth::getInstance()->getIdentity();

			$_SESSION['categoryType'] = 'universalDueImage';
			//retrieve request object so we can access requested user and action.
			$request = $this->getRequest();
			//check if already dispatching the user not found action. if we are
			//then we don't want to execute the remainder of this method.
			
			if(strtolower($request->getActionName()) =='clubnotfound') //returns like index, view, register,  and stuff like that.
			{
				return;
			}
			//retrieve username from request and clean the string //returns a single user param. 
			$this->username = trim($request->getUserParam('memberusername'));
			
			$_SESSION['clubUsername'] = $this->username;
			//load the user, based on username in request. if the user record is not loaded then forward
			//to notFoundAction so a 'user not found message can be shown to the user. 
			$this->user = new DatabaseObject_User($this->db);
			
			if(!$this->user->loadByUsername($this->username, 'clubAdmin', 'L'))
			{
				$this->view->noUser = TRUE;
				//$this->_forward('clubNotFound');
				return;
			}
			
			////echo $_SESSION['clubUsername'];
			//add a link to the breadcrumbs so all actions in this controller 
			//link back to the user home page //we can put the organization's name on here. 
			
			$this->view->cartID = $this->shoppingCart->getCartID();

			
			$this->breadcrumbs->addStep(
				$this->user->profile->public_club_name. "s Membership",
				$this->getCustomUrl(array('memberusername' =>$this->user->username, 'action'=>'index'), 'clubmemberdue'));
			$this->view->user=$this->user; //making the user available in all templates in this controller. because it is in 
			
			//=========================================affiliation check for request affiliation button========
			$affiliation= new DatabaseObject_Affiliation($this->db);
			
		
			$_SESSION['clubUsername'] = $this->username;
			
			$this->club = new DatabaseObject_User($this->db);
			
			if($this->club->loadByUsername($this->username, 'clubAdmin', 'L'))  //check to see if request is related with clubuser
			{
				$this->secondMember=$this->club;
				if(isset($this->auth->getIdentity()->userID)&& $this->auth->getIdentity()->user_type == 'member')
				{
					////echo "your user_type is: ".$auth->getIdentity()->user_type;
					

					if($affiliation->checkAffiliation($this->auth->getIdentity()->userID, $this->club->getId()))
					{
						$this->view->requestAffilButtonActive = true;
						$this->affiliated = true;
					}
					else
					{
						
						$this->view->requestAffilButtonActive = false;
						$this->affiliated = false;
					}
					
				}
				elseif(isset($this->auth->getIdentity()->userID)&& $this->auth->getIdentity()->user_type == 'clubAdmin')
				{
				
					
					$this->view->requestAffilButtonActive = true;
				}
				else
				{
					////echo "your user_type3 is: ".$auth->getIdentity()->user_type;
					$this->affiliated = true;
					$this->view->requestAffilButtonActive = false;
				}
			}
			elseif($this->club->loadByUsername($this->username, 'member', 'L'))//check to see if request is related with member
			{
				$this->secondMember=$this->club;
				if($affiliation->checkAffiliation( $this->club->getId(), $this->auth->getIdentity()->userID)) //member is not the club(memberuser), and club is now the logged in clubAdmin.
				{
					////echo "you are at here: with true affiliated.";
					$this->affiliated = true;
				}
				else
				{
					$this->affiliated = false;
				}
				$this->view->requestAffilButtonActive = true;
			}
		}
	
		public function indexAction()
		{
		
			if(isset($this->user->profile->num_posts))
			{
				$limit = max(1, (int)$this->user->profile->num_posts);
			}
			else
			{
				$limit = 10;
			}
			
			$options = array('user_id' =>$this->user->getId(),
			                 'status' =>'L',
							 'limit' => $limit,
							 'order' => 'p.ts_created desc',
							);
		
			$due = new DatabaseObject_UniversalDue($this->db);
			
			
			$objects =  DatabaseObject_UniversalDue::GetObjects($this->db, $options);

			
			$this->view->posts=$objects;
		}
		
		
		public function viewAction()
		{
			$due = new DatabaseObject_UniversalDue($this->db);
			$request=$this->getRequest();
			$url = trim($request->getUserParam('url'));
			
			//if no URL was specified, return to the user home page
			if(strlen($url)==0)
			{
				$this->_redirect($this->getCustomUrl(array('username' =>$this->user->username), 'clubmemberdue')
				);
				
			}
			
			////echo "user id is: ".$this->user->getId();
			$due->loadLiveObject($this->club->getId(), $url); // the user is got from pre dispatch.
			$due->getImages();
			//if the post wasn't loaded redirect to post not found
			if(!$due->isSaved())
			{
				$this->_forward('postNotFound');
				return;
			}
			
			$archiveOptions = array(
						'username'=>$this->club->username,
						'year'=>date('Y', $due->ts_created),
						'month'=>date('m', $due->ts_created)
						);
			
			$this->breadcrumbs->addStep(date('F Y', $due->ts_created), $this->getCustomUrl($archiveOptions, 'clubmemberduearchive'));	
			
			$this->breadcrumbs->addStep($due->profile->name);
			//make the post availableto the template
			$this->view->post=$due;
		}
		
		public function postnotfoundAction()
		{
		
		}
		
		
		
		public function archiveAction()
		{
			$due = new DatabaseObject_UniversalDue($this->db);
			$request=$this->getRequest();
			
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
					'from'=>date('Y-m-d H:i:s', $from),
					'to' =>date('Y-m-d H:i:s', $to),
					'status' => 'L',
					'order' =>'p.ts_created desc');
				
			$objects = $due->GetObjects($this->db, $options);
			
			$this->breadcrumbs->addStep(date('F Y', $from));
			
			$this->view->month = $from;
			$this->view->posts = $objects;
		
		}
		
		public function tagAction()
		{
			$request=$this->getRequest();

			
			$due = new DatabaseObject_UniversalDue($this->db);
			$tag = trim($request->getUserParam('tag'));

			if(strlen($tag)==0)
			{
				$this->_redirect($this->getCustomUrl(array('memberusername' => $this->user->username, 'action' => 'index'), 'clubmemberduetagspace'));
			}
			
			$options = array(
				'user_id' =>$this->user->getId(),
				'tag' =>$tag,
				'status' =>'L',
				'order' =>'p.ts_created desc'
			);
			
			$objects = $due->GetObjects($this->db, $options);
			
			$this->breadcrumbs->addStep('Due Category: '.$tag);
			$this->view->tag = $tag;

			$this->view->posts = $objects;
		}
		
		public function individualdueAction()
		{
		
			if($this->affiliated)
			{
				$dues = new DatabaseObject_IndividualDue($this->db);
				
				$products = $dues->loadMemberDueList($this->db, $this->signedInUser->userID, $this->user->getId());
				
				$this->view->dues = $products;
				
				$this->view->club = $this->user;
							
			//	//echo "<br/>you are here at affiliated. you may proceed with editing";
			}
			else
			{
				$this->messenger->addMessage('Your are not affiliated with this club.');
				$this->_redirect($this->getUrl($this->secondMember->username));
			}

			
	
		
		}

	}
?>