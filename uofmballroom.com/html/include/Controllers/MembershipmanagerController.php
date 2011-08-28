<?php
/********************************************************************************************
**this is purelly for duepayment management for CLUBS to manager ALLOCAITON of member's dues.
**URL STYLE
**
**membershipmanager/dues/index      this displays payed member's current dues and their payment status
**membershipmanager/dues/edit       this allows the edit/delete/confirm/ payed member's current payment status

**membershipmanager/                this displays all pending affiliations
**membershipmanager/paidmember      this displays all affiliations sorted by
*/


	class MembershipmanagerController extends CustomControllerAction
	{
	
		protected $clubUser;
		protected $memberUser;
		protected $username;
		protected $secondMember;
		protected $club;
		protected $signedInUser;
		
		protected $existingMembers;
		protected $pendingMembers;
		
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('membership manager', $this->getUrl(null, 'membershipmanager'));
			$this->clubUser=Zend_Auth::getInstance()->getIdentity();
			$this->signedInUser = new DatabaseObject_User($this->db);
			if($this->signedInUser->loadByUserId($this->clubUser->userID))
			{
			$this->view->clubManager =$this->signedInUser;
			}
			
			
			$_SESSION['categoryType'] = 'universalDueImage';
			
			$affiliation= new DatabaseObject_Affiliation($this->db);
			$request = $this->getRequest();
			
		
			$this->username = trim($request->getUserParam('memberusername'));
			
			
			$_SESSION['clubUsername'] = $this->username;
			
			$this->club = new DatabaseObject_User($this->db);
			
			if($this->club->loadByUsername($this->username, 'clubAdmin', 'L'))  //check to see if request is related with clubuser
			{
				$this->secondMember=$this->club;
				if(isset($this->clubUser->userID)&& $this->clubUser->user_type == 'member')
				{
					//echo "your user_type is: ".$auth->getIdentity()->user_type;
					

					if($affiliation->checkAffiliation($this->clubUser->userID, $this->club->getId()))
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
				elseif(isset($this->clubUser->userID)&& $this->clubUser->user_type == 'clubAdmin')
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
				if($affiliation->checkAffiliation( $this->club->getId(), $this->clubUser->userID)) //member is not the club(memberuser), and club is now the logged in clubAdmin.
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
	
		public function preDispatch()
		{
			parent::preDispatch();
			
			$request=$this->getRequest();
			
			$memberUsername=$request->getParam('memberusername');
			
			if(isset($memberUsername))
			{
				$this->memberUser=new DatabaseObject_User($this->db);
				
				if(!$this->memberUser->loadByUsername($memberUsername, 'member', 'L'))
				{
					//$this->view->noUser = TRUE;
					return;
				}
				elseif($this->affiliated)
				{
					$options=array('user_id' =>$this->memberUser->getId()); //loading images
					$_SESSION['categoryType'] = 'clubImage';
					$images = DatabaseObject_Image::GetImages($this->db, $options, 'user_id', 'users_profiles_images');
					//$_SESSION['categoryType'] = 'universalDueImage';
					$this->view->images = $images;
					$this->view->memberUser = $this->memberUser;
				}
			}
		}
		
		public function indexAction()
		{
			//--------------For and memberships
				
			$tag=$this->getRequest()->getQuery('tag');
			
			$month =$this->getRequest()->getQuery('month');
			
			
			//echo "user id is: ".$this->clubUser->userID;
			$totalProducts = DatabaseObject_UniversalDue::GetObjectsCount($this->db, array('user_id'=>$this->clubUser->userID));
			if(isset($tag))
			{
				$options = array(
				'user_id' =>$this->clubUser->userID,
				'tag' =>$tag,
				'status' =>DatabaseObject_UniversalDue::UNIVERSAL_DUE_STATUS_LIVE,
				'order' =>'p.ts_created desc');
			
				$recentProducts = DatabaseObject_UniversalDue::GetObjects($this->db, $options);
				
				//echo "you are here at recentproducts in index.php";
				$this->view->tagProducts = $recentProducts;
				$this->view->tag = $tag;
			}
			
			
			////echo "here1";
			
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
				
				$options=array('user_id' =>$this->clubUser->userID,
							   'from'=>date('Y-m-d H:i:s', $from),
							   'to' =>date('Y-m-d H:i:s', $to),
							   'order' =>'p.ts_created desc');
				
				$recentPosts = DatabaseObject_UniversalDue::GetObjects($this->db, $options);
								
				$this->view->month = $from;
				$this->view->recentPosts = $recentPosts;
			}
			
			$this->view->totalProducts = $totalProducts;
			//*/
		}
		
		public function memberlistAction()
		{
				////echo "clubnameis : ".$clubname;
				$request = $this->getRequest();
				
				$action= $request->getQuery('action');
				//echo "action is: ".$action;
					
				$this->view->action = $action;
				if($action =="confirmed")
				{
				$affiliations = DatabaseObject_Affiliation::loadClubAffiliation($this->db, $this->clubUser->userID, 'confirmed');
				}
				elseif($action =='pending')
				{
					$affiliations = DatabaseObject_Affiliation::loadClubAffiliation($this->db, $this->clubUser->userID, 'pending');
				}
				else
				{
					$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

					$this->_redirect($this->geturl('index'));
				}
				
				//echo "your affiliation number is: ".count($affiliations);
				
				$clubIdArray = array();
				
				foreach($affiliations as $k=>$v)
				{
					$clubIdArray[]=$affiliations[$k]['member_id'];
				}
				
				$alphabet = $this->getRequest()->getQuery('alphabetLink');
	
				$pageNumber = $this->getRequest()->getQuery('limitPage');
				/*
				//_________________________________________________________________________
				foreach($this->alphabetLink as $k=>$v)
				{
					$this->alphabetLink[$k] =$this->geturl('memberlist').'?action='.$action.'&alphabetLink='.$k;
					//////echo "<br/>Link: ".$alphabetLink[$k];
				}
				
				
				$this->view->alphabetLink = $this->alphabetLink;
				$this->view->paginationLink = $this->getUrl('memberlist').'?action='.$action;
				
				
				
				
				if(($pageNumber>0) && (count($clubIdArray)>0))
				{
					$options= array(
									'user_type' 	=> 'member',
									'university' 	=> 'all',
									'status'    	=> 'L',
									'limitTotal'    => $pageNumber,
									'alphabetLink'  => $alphabet,
									'userID'		=> $clubIdArray);
									
					$_SESSION['categoryType'] = 'clubImage';
		
					$users = new DatabaseObject_User($this->db);
		
					$objects = $users->GetObjects($this->db, $options); 
				
				
					//echo "users 1 count: ".count($objects);
					$this->view->users = $objects;
					
					$this->currentTotalPage = ceil(count($objects)/2)+$pageNumber;
					$this->view->currentTotalPage = $this->currentTotalPage;
				////echo "<br/>currentToalPage: ".$this->currentTotalPage;
					$this->view->currentPage = $pageNumber;
				}
				elseif(count($clubIdArray)>0)
				{
					$pageNumber=1;
					$options= array(
									'user_type' 	=> 'member',
									'university' 	=> 'all',
									'status'    	=> 'L',
									'limitTotal'    => 1,
									'alphabetLink'  => $alphabet,
									'userID'		=> $clubIdArray);
									
					$_SESSION['categoryType'] = 'clubImage';
		
					$users = new DatabaseObject_User($this->db);
		
					$objects = $users->GetObjects($this->db, $options); 
				
				
					//echo "users 2 count: ".count($objects);
					$this->view->users = $objects;
					
					$this->currentTotalPage = ceil(count($objects)/2)+$pageNumber;
					$this->view->currentTotalPage = $this->currentTotalPage;
				////echo "<br/>currentToalPage: ".$this->currentTotalPage;
					$this->view->currentPage = $pageNumber;
				}
				
				if(strlen($pageNumber)==0)
				{
					$options= array('limit'        =>1,
									'user_type' 	=> 'member',
									'university' 	=> 'all',
									'status'    	=> 'L',
									'alphabetLink'  => $alphabet,
									'userID'		=> $clubIdArray);
									
					$_SESSION['categoryType'] = 'clubImage';
		
					$users = new DatabaseObject_User($this->db);
		
					$objects = $users->GetObjects($this->db, $options); 
					$this->view->users = $objects;

				}
				elseif(is_numeric($pageNumber))
				{
				
					$options= array('limit'        =>$pageNumber,
									'user_type' 	=> 'member',
									'university' 	=> 'all',
									'status'    	=> 'L',
									'alphabetLink'  => $alphabet,
									'userID'		=> $clubIdArray);
									
					$_SESSION['categoryType'] = 'clubImage';
		
					$users = new DatabaseObject_User($this->db);
		
					$objects = $users->GetObjects($this->db, $options); 
					$this->view->users = $objects;

				}
				//_________________________________________________________________________
				//echo "<br/>clubArray count: ".count($clubIdArray);
				*/
				if(count($clubIdArray)>0)
				{
				$options= array(
									'user_type' 	=> 'member',
									'university' 	=> 'all',
									//'status'    	=> 'L',
									'alphabetLink'  => $alphabet,
									'order' => 'first_name',
									'userID'		=> $clubIdArray);
									
					$_SESSION['categoryType'] = 'clubImage';
		
					$users = new DatabaseObject_User($this->db);
		
					$objects = $users->GetObjects($this->db, $options); 
					$this->view->users = $objects;
				}
			
				$this->view->affiliation = $affiliations;
				
				if($action =="confirmed")
				{
					$this->breadcrumbs->addStep('Exisiting Member');
				}
				elseif($action=='pending')
				{
					$this->breadcrumbs->addStep('Pending Members');
				}
				
				if(count($affiliations)==0)
				{
					$this->messenger->addMessage('You current do not have any affiliations in that section');

					$this->_redirect($this->geturl('index'));
				}
		}
		
		public function memberpreviewAction()
		{
			if($this->affiliated)
			{
				$this->view->user = $this->secondMember;
				
				$this->breadcrumbs->addStep('member preview: '.$this->secondMember->first_name.' '.$this->secondMember->last_name);
				
			}
			else
			{
				$this->messenger->addMessage('We are sorry, you are not a member to this club.');

				$this->_redirect($this->geturl('memberlist').'?action=confirmed');			
			
			}
		
		}
		
		public function confirmaffiliationAction()
		{
		
			//needs security check here.	
			
			$request=$this->getRequest();
			
			$id=$request->getPost('id');
			
			$affiliate = new DatabaseObject_Affiliation($this->db);
			
		
			
			if($affiliate->checkAffiliation($id, $this->clubUser->userID))
			{
				DatabaseObject_Affiliation::confirmAffiliation($this->db, $this->clubUser->userID, $id);
				
				
			
				$this->messenger->addMessage('This person has been confirmed');
				$this->_redirect($this->getUrl('memberlist')."?action=pending");
				
			}
			else
			{
				$this->messenger->addMessage('We are sorry that we are unable to load this affiliate');

				$this->_redirect($this->geturl('index'));
			}
		
		
		}
		
		public function removeaffiliateAction()
		{
		
			//needs security check here. 
		
			$request=$this->getRequest();
			
			$id=$request->getPost('id');
			
			
			
			DatabaseObject_Affiliation::removeAffiliation($this->db, $this->clubUser->userID, $id);
			$this->messenger->addMessage('This person has been deleted from affiliates');
			$this->_redirect($this->getUrl('memberlist')."?action=confirmed");
		
		}
			
		
		
		
		//-----------------------------------------INDIVIDUAL DUE ---------------------------------
		public function setmemberduesAction()
		{
			if($this->signedInUser->profile->paypalEmail=='')
			{
				$this->messenger->addMessage('You must have a paypal email inorder to set individual dues, members must be able to pay you through paypal');
				$this->_redirect($this->getUrl('memberlist')."?action=confirmed");
			}
				
			
			//echo "second membder name: ".$this->secondMember->username;
			if($this->affiliated)
			{	
				$this->view->memberUsername = $this->secondMember->username;

				////echo "<br/>at affiliation";	
				$request=$this->getRequest();
			
				$due_key =$request->getQuery('key');
				if(strlen($due_key)==0)
				{
					$due_key = $request->getPost('key');
				}
				
				
				if(strlen($due_key) <= 0)
				{
					$this->view->newDue=true;
					//echo "<br/>at new individual_due";
					$individual_due = new DatabaseObject_IndividualDue($this->db);
					$individual_due->clubAdmin_id = $this->clubUser->userID;
					$individual_due->member_id = $this->secondMember->getId();
								
					$fp = new FormProcessor_IndividualDue($this->db, $individual_due);
					
					$this->view->due = $individual_due;
					if($request->isPost())
					{
						if($fp->process($request))
						{
							$url = $this->getUrl('individualduepreview').'?key='.$individual_due->getId();
							$this->secondMember->sendEmail('due-notice.tpl', $this->signedInUser);
							//echo "<br/>redirect url: ".$url;
							$this->_redirect($url);
						}
					}
				}
				else
				{
					$this->view->newDue = false;

					//echo"<br/>at loading individual_due: ";
					$individual_due = new DatabaseObject_IndividualDue($this->db, $due_key);
					
					if($individual_due->loadClubIndividualDues($this->db, $due_key))
					{
					
						//echo "<br/>information on the loaded information: ".$individual_due->date_set;
						if($individual_due->isSaved())
						{
							//echo "<br/>this is saved";
						}
						else
						{
							//echo "<br/>this due is not saved after loading";
						}
						
						$fp = new FormProcessor_IndividualDue($this->db, $individual_due);
						
						$this->view->due = $individual_due;
						//echo "<br/>at loaded";

						if($request->isPost())
						{
							if($fp->process($request))
							{
								
								$url = $this->getUrl('individualduepreview').'?key='.$individual_due->getId();
								$this->secondMember->sendEmail('due-notice.tpl', $this->signedInUser);

								$this->_redirect($url);
							}
						}
					}
					else
					{
						//echo "<br/>you can not load this due";
					}

				}
				
				if($individual_due->isSaved())
				{
					$this->breadcrumbs->addStep('member list', $this->getUrl('memberlist'));
					$this->breadcrumbs->addStep('preview due: '.$individual_due->profile->name, $this->getUrl('individualduepreview').'?key='.$individual_due->getId());
					$this->breadcrumbs->addStep('Edit due');
				}
				else
				{
					$this->breadcrumbs->addStep('create new individual dues with '.$this->secondMember->profile->first_name.' '.$this->secondMember->profile->last_name);
				}
				
				$this->view->fp=$fp;
			}
			else
			{
				//echo "at here";
				$this->_redirect($this->geturl('index'));
			}
			
		}
		
		public function individualduesetstatusAction()
		{
			$request=$this->getRequest();
			
			$due_key = (int)$this->getRequest()->getPost('key');
			
			
			
			$due = new DatabaseObject_IndividualDue($this->db);
					
			if(!$due->loadClubIndividualDues($this->db, $due_key))
			{
				//echo "you are at unable to load";
				//$this->_redirect($this->getUrl());
			}
			
			$secondUser = new DatabaseObject_User($this->db);
			$secondUser->loadByUserId($due->member_id);
			
			
			$url = $this->getUrl('individualduepreview').'?key='.$due->getId();
			
			if($request->getPost('edit'))
			{
				$this->_redirect($this->getUrl('setmemberdues').'/'.$secondUser->username.'?key='.$due->getId());
			}
			else if($request->getPost('publish'))
			{

				$due->sendLive();
				$due->save();

				$this->messenger->addMessage('due sent live');

			}
			else if($request->getPost('unpublish'))
			{
				$due->sendBackToDraft();
				$due->save();

				$this->messenger->addMessage('due Unpublished');

			}
			else if($request->getPost('delete'))
			{
				$due->delete();
				$this->messenger->addMessage('due Deleted');
			}
			
			
			$this->_redirect($url);
		}
		
		
		public function individualduepreviewAction()
		{
		
			$due_key = (int)$this->getRequest()->getQuery('key');
			
			$due = new DatabaseObject_IndividualDue($this->db, $due_key);
					
			if(!$due->loadClubIndividualDues($this->db, $due_key))
			{
			
				$this->_redirect($this->getUrl());
			}
			
					
			
			$secondUser = new DatabaseObject_User($this->db);
			$secondUser->loadByUserId($due->member_id);
			//echo "due id is: ".$due->getId();
			$this->breadcrumbs->addStep('member list', $this->getUrl('memberlist')."?action=confirmed");
			$this->breadcrumbs->addStep($secondUser->profile->first_name.' '.$secondUser->profile->last_name, $this->getUrl('individualpreviewlist').'/'.$secondUser->username);
						
			$this->breadcrumbs->addStep('Due: '.$due->profile->name);
			$this->view->product = $due;
		}
		
		
		public function individualpreviewlistAction()
		{
			if($this->affiliated)
			{
				
				
				$dues = new DatabaseObject_IndividualDue($this->db);
				
				$products = $dues->loadMemberDueList($this->db, $this->secondMember->getId(), $this->clubUser->userID);
				
				if(count($products)==0)
				{
				$this->messenger->addMessage('This person do not have any individual dues');
				$this->_redirect($this->getUrl('memberlist')."?action=confirmed");
				}	
				
				$this->view->dues = $products;
				$this->view->secondMember = $this->secondMember;
				
				
			}
			else
			{
				$this->messenger->addMessage('This person is not a member of your club');
				$this->_redirect($this->getUrl('memberlist')."?action=confirmed");
							
			}
				
				
			$this->breadcrumbs->addStep('Member list', $this->getUrl('memberlist').'?action=confirmed');
			$this->breadcrumbs->addStep('Member: '.$this->secondMember->profile->first_name.' '.$this->secondMember->profile->last_name);
	
		
		}
		//-----------------------------------------UNIVERSAL DUE SECTION-------------------------
		public function edituniversaldueAction()
		{
			
			$request=$this->getRequest();
			
			$due_id =(int)$this->getRequest()->getQuery('id');
			
			
			$fp = new FormProcessor_UniversalDue($this->db, $this->clubUser->userID, $due_id);
			if($request->isPost())
			{
				if($fp->process($request))
				{
					
					$url = $this->getUrl('universalduepreview').'?id='.$fp->universal_dues->getId();
					$this->_redirect($url);
				}
			}
			
			if($fp->universal_dues->isSaved())
			{
				$this->breadcrumbs->addStep('preview due: '.$fp->universal_dues->profile->name, $this->getUrl('universalduepreview').'?id='.$fp->universal_dues->getId());
				$this->breadcrumbs->addStep('Edit due');
			}
			else
			{
				$this->breadcrumbs->addStep('create new club dues');
			}
			
			$this->view->fp=$fp;
			
		}
		
		
		public function universalduepreviewAction()
		{
			
			
			$due_id = (int)$this->getRequest()->getQuery('id');
			
			$due = new DatabaseObject_UniversalDue($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($due, $this->clubUser->userID, $due_id, 'universal_dues_id'))
			{
				$this->_redirect($this->getUrl());
			}
			
			$due->getImages();
			
			$tags = DatabaseObject_StaticUtility::getTagsForObject($due, 'universal_dues_tags', 'universal_dues_id'); 
			
			$this->breadcrumbs->addStep('Preview product: '.$due->profile->name);
			
			$this->view->product = $due;
			$this->view->tags = $tags;
		
		}
		
		public function setstatusAction()
		{
				
			$request=$this->getRequest();
			
			$due_id =(int) $request->getPost('id');
			
			$due = new DatabaseObject_UniversalDue($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($due, $this->clubUser->userID, $due_id, 'universal_dues_id'))
			{
			
				//echo "you are here at unable to laod object";
				$this->_redirect($this->getUrl());

			}
			
			$url = $this->getUrl('universalduepreview').'?id='.$due->getId();
			
			if($request->getPost('edit'))
			{
				$this->_redirect($this->getUrl('edituniversaldue').'?id='.$due->getId());
			}
			else if($request->getPost('publish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($due, 'publish');
				$this->messenger->addMessage('due sent live');

			}
			else if($request->getPost('unpublish'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($due, 'unpublish');
				$this->messenger->addMessage('due Unpublished');

			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::setObjectStatusAction($due, 'delete');
				$this->messenger->addMessage('due Deleted');
			}

			$this->_redirect($url);
		}
	
		
		public function tagsAction()
		{
			$request=$this->getRequest();
			
			$due_id= $request->getPost('id');
			
			$due = new DatabaseObject_UniversalDue($this->db);
		
			if(!DatabaseObject_StaticUtility::loadObjectForUser($due, $this->clubUser->userID, $due_id, 'universal_dues_id'))
			{
				//echo "you are unable to load";
				$this->_redirect($this->getUrl());

			}
			
			$tag = $request->getPost('tag');
			
			if($request->getPost('add'))
			{
				DatabaseObject_StaticUtility::addTagsToObject('universal_dues_tags', $due, $tag, 'universal_dues_id');	
				$this->messenger->addMessage('Categories added to due');
			}
			else if($request->getPost('delete'))
			{
				DatabaseObject_StaticUtility::deleteTagsForObject('universal_dues_tags', $due, $tag, 'universal_dues_id');
				$this->messenger->addMessage('Categories deleted for product');
			}
			
			
			$this->_redirect($this->getUrl('universalduepreview').'?id='.$due->getId());
			
	
		}
		
		public function imagesAction()
		{
		
			$request= $this->getRequest();
			$json = array();
			
			
			$due_id=(int)$request->getPost('id');
			
			
			$due = new DatabaseObject_UniversalDue($this->db);
			
			if(!DatabaseObject_StaticUtility::loadObjectForUser($due, $this->clubUser->userID, $due_id, 'universal_dues_id'))
			{
				//echo "you can not load this product";
				$this->_redirect($this->getUrl());

			}
			//echo "here";
			if($request->getPost('upload'))
			{
				$fp=new FormProcessor_Image($due);
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
				$due->setImageOrder($order);
				
			}
			elseif($request->getPost('delete'))
			{
				
				$image_id = (int) $request->getPost('image');
				
				
				$image = new DatabaseObject_Image($this->db);
				
				if($image->loadForPost($due->getId(), $image_id))
				{
					$image->delete(); //the files are unlinked/deleted at preDelete.
					//echo "image at delete";
					
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
				$url = $this->getUrl('universalduepreview').'?id='.$due->getId();
				$this->_redirect($url);
			}
		}
		
		
		
		public function testingAction()
		{
			/*
			$due_key = md5(uniqid(rand(), true));

			
			$newDue = new DatabaseOjbect_IndividualDue($this->db, $due_key);
			
			$newDue->member_id = 4;
			$newDue->clubAdmin_id = 5;
			
			*/
				
				
				
				
		
		}

	
	
	}
?>