<?php
/*************************************************
**controller:   message/action/username
**Requirement: 	must be signed in. 
**variable:   
			clubUser is the signed in person.
			signedInUser is the stated user.
*************************************************/

	class MessageController extends CustomControllerAction
	{
		protected $clubUser;
		protected $signedInUser;
		protected $username;
		protected $secondMember;

		/**********************************
		check affiliation for messages
		**********************************/
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('message manager', $this->getUrl(null, 'message'));
			$this->clubUser=Zend_Auth::getInstance()->getIdentity();
			
			$this->signedInUser = new DatabaseObject_User($this->db);
			$this->signedInUser->loadByUserId($this->clubUser->userID);
			

			
			$_SESSION['categoryType'] = 'clubImage';

			$affiliation= new DatabaseObject_Affiliation($this->db);
			$request = $this->getRequest();
			
		
			$this->username = trim($request->getUserParam('username'));
			
			
			$_SESSION['clubUsername'] = $this->username;
			
			$this->club = new DatabaseObject_User($this->db);
			
			if($this->club->loadByUsername($this->username, 'clubAdmin', 'L'))  //check to see if request is related with clubuser
			{
				$this->secondMember=$this->club;
				if(isset($this->clubUser->userID)&& $this->clubUser->user_type == 'member')
				{
					////echo "your user_type is: ".$auth->getIdentity()->user_type;
					

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
					////echo "your user_type3 is: ".$auth->getIdentity()->user_type;
					$this->affiliated = true;
					$this->view->requestAffilButtonActive = false;
				}
			}
			elseif($this->club->loadByUsername($this->username, 'member', 'L'))//check to see if request is related with member
			{
				$this->secondMember=$this->club;
				if($affiliation->checkAffiliation( $this->club->getId(), $this->clubUser->userID)) //member is not the club(memberuser), and club is now the logged in clubAdmin.
				{
					////echo "you are at here: with true affiliated.";
					$this->affiliated = true;
					//$this->affiliated = true;
				}
				else
				{
					////echo "you are at here: with false affiliated.";
					$this->affiliated = false;
					//$this->affiliated = true;
				}
				$this->view->requestAffilButtonActive = true;
			}			

		}
		
		public function indexAction()
		{
		
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getUrl('index', 'message').'?alphabetLink='.$k;
				////echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			$pageNumber = $this->getRequest()->getQuery('limitPage');
			
			
			if($pageNumber==0)
			{
							$pageNumber=1;

				$options = array(
							'alphabetLink'  => $alphabet,
							'limitTotal'    => 1
							);
				$this->view->currentPage = 1;
			}
			else
			{
				$options = array( 'alphabetLink'  => $alphabet,
							'limitTotal'    => $pageNumber
							);
				$this->view->currentPage = $pageNumber;

			}
			
			$messages = DatabaseObject_ReceiverMessage::loadMessages($this->db, $this->clubUser->userID, $options);
		
		
			//if(count($messages)==0)
			//{
		
			//	$this->_redirect($this->geturl('nomessage'));

			//}
		
			//echo "<br/>count of message after: ".count($messages);
			$this->currentTotalPage = ceil(count($messages)/15)+$pageNumber;
			$this->view->currentTotalPage = $this->currentTotalPage;
			//echo "<br/>currentToalPage: ".$this->currentTotalPage;
			

			
			
			if(strlen($pageNumber)==0)
			{

				$options = array(
							'alphabetLink'  => $alphabet,
							'limit' =>1
							);
							
				$messages = DatabaseObject_ReceiverMessage::loadMessages($this->db, $this->clubUser->userID, $options);
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array(
							 'limit'=>$pageNumber,
			                 
							 'alphabetLink'  => $alphabet
							 
							);
							
				$messages = DatabaseObject_ReceiverMessage::loadMessages($this->db, $this->clubUser->userID, $options);
				$this->view->currentPage=$pageNumber;
			}			
			
		
			////echo "<br/>message count here is: ".count($messages);
			$this->view->inboxMessages = $messages;
			$this->view->messageType = 'inbox';
			$this->view->returnAddress = $this->getUrl('index');
			
			
			$this->view->paginationLink = $this->geturl('index','message');
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;		
			
			
			$this->breadcrumbs->addStep('inbox', $this->geturl('index'));
			
		}
		
		public function outboxAction()
		{
			foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getUrl('outbox', 'message').'?alphabetLink='.$k;
				////echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			$pageNumber = $this->getRequest()->getQuery('limitPage');
			
			if($pageNumber==0)
			{
							$pageNumber=1;

				$options = array(
							'alphabetLink'  => $alphabet,
							'limitTotal'    => 1
							);
				$this->view->currentPage = 1;
			}
			else
			{
				$options = array( 'alphabetLink'  => $alphabet,
							'limitTotal'    => $pageNumber
							);
				$this->view->currentPage = $pageNumber;

			}
			
			$messages = DatabaseObject_SenderMessage::loadMessages($this->db, $this->clubUser->userID, $options);
		
		
			//if(count($messages)==0)
			//{
		
			//	$this->_redirect($this->geturl('nomessage'));

			//}
		
			//echo "<br/>count of message after: ".count($messages);
			$this->currentTotalPage = ceil(count($messages)/15)+$pageNumber;
			$this->view->currentTotalPage = $this->currentTotalPage;
			//echo "<br/>currentToalPage: ".$this->currentTotalPage;
			
			if(strlen($pageNumber)==0)
			{
				$options = array(
							'alphabetLink'  => $alphabet,
							'limit' =>1
							);
							
				$messages = DatabaseObject_SenderMessage::loadMessages($this->db, $this->clubUser->userID, $options);
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array(
							 'limit'=>$pageNumber,
			                 
							 'alphabetLink'  => $alphabet
							 
							);
							
				$messages = DatabaseObject_SenderMessage::loadMessages($this->db, $this->clubUser->userID, $options);
				$this->view->currentPage=$pageNumber;
			}			
			
		
			$this->view->outboxMessages = $messages;
			$this->view->messageType = 'outbox';
			$this->view->returnAddress = $this->getUrl('outbox');
			
			
			
			$this->view->paginationLink = $this->geturl('outbox','message');
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;		
			$this->breadcrumbs->addStep('outbox', $this->geturl('outbox', 'message'));
			
		}
		
		public function viewAction()
		{
		
			
			$request=$this->getRequest();
			
			$message_id = $request->getQuery('id');
			
			if(strlen($message_id) ==0)
			{
				$this->view->error = "Sorry, we are unable to view you message";
				return;
			}
			
			$messageType=$request->getQuery('type');
			if(strlen($messageType) ==0)
			{
				$this->view->error = "Sorry, we are unable to view you message";
				return;
			}
			
			//
			
			if($messageType=='inbox')
			{
			
				$message = new DatabaseObject_ReceiverMessage($this->db);
				////echo "<br/>here at inbox";
				$object =$message->checkReceiverMessages($this->clubUser->userID, $message_id);
			}
			if($messageType=='outbox')
			{
				$message = new DatabaseObject_SenderMessage($this->db);
				
				$object =$message->checkSenderMessages($this->clubUser->userID, $message_id);
			}
			
			if($object == false)
			{
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				$this->_redirect($this->geturl('index'));
			}
			else
			{
				
				////echo "<br/>you are here at outbox";
				if($message->receiver_id== $this->clubUser->userID)
				{
					$message->status = 'read';
					$message->save();
					//load the sender user;
					
					$user =new DatabaseObject_User($this->db);
					
					$user->loadByUserId($message->sender_id);
					
					$options=array('user_id' =>$message->sender_id, 'limit'=>1); //loading images
				
				////echo "<br/>user_id: ".$this->getId();
					
					$images = DatabaseObject_Image::GetImages($this->db, $options, 'user_id', 'users_profiles_images');
					
					$this->view->user = $user;
					$this->view->images= $images;
					$this->view->box='inbox';

				}
				else
				{
					$message->status = 'read';
					$message->save();
					
					$user =new DatabaseObject_User($this->db);
					
					$user->loadByUserId($message->receiver_id);
					$options=array('user_id' =>$message->receiver_id, 'limit'=>1); //loading images
				
				////echo "<br/>user_id: ".$this->getId();
				
					$images = DatabaseObject_Image::GetImages($this->db, $options, 'user_id', 'users_profiles_images');
					
					$this->view->user = $user;
					$this->view->images= $images;
					$this->view->box='outbox';
					
					//load the receiver user;
				}
				
				////echo "<br/>messageType is: ".$messageType;
				$this->view->messageInfo = $message;
				$this->breadcrumbs->addStep('view message: '.$message->profile->subject);
				$this->view->messageType=$messageType;
			}
			//*/
		}
		
		public function writeAction()
		{
		
			
			if(isset($this->secondMember))
			{	
				$request=$this->getRequest();
				
				$fp = new FormProcessor_Message($this->db, $this->clubUser->userID, $this->secondMember->getId());
				
				if($request->isPost())
				{
					////echo "<br/> Posted";
					if($fp->process($request))
					{
						$this->messenger->addMessage('Your message has been sent.');
						
						$this->secondMember->sendEmail('message-notice.tpl', $this->signedInUser);
						//$url=$this->getUrl('preview').'?id='.$fp->event->getId();
						$this->_redirect($this->geturl('index'));
					}
					else
					{
						//echo "you have an ERROR in your post!!!!";
					}
				}
				
				
				$this->view->fp = $fp;
				$this->view->receiver = $this->secondMember;
				if($this->secondMember->user_type=='member')
				{
					$this->view->receiverType = 'member';
					$this->breadcrumbs->addStep('write to: '.$this->secondMember->profile->last_name.' '.$this->secondMember->profile->first_name);

				}
				elseif($this->secondMember->user_type=='clubAdmin')
				{
					$this->view->receiverType = 'clubAdmin';
					$this->breadcrumbs->addStep('write to: '.$this->secondMember->profile->public_club_name);
				}
				
			}
			else
			{
				$this->messenger->addMessage('Your message cannot be created.');
				$this->_redirect($this->getUrl('index'));
				////echo "you do not have a club specified";
			}
			
			
		}
		
		public function confirmAction()
		{
			//echo "You message has been sent";
		}
		
		public function deleteAction()
		{
		
			$request=$this->getRequest();
			$message_id = $request->getPost('id');
			$returnAddress=$request->getPost('returnAddress');
			$messageType = $request->getPost('messageType');
			
			if(strlen($message_id) ==0)
			{
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				$this->_redirect('index');				return;
			}
			
			if(strlen($messageType) ==0)
			{
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				$this->_redirect('index');				return;
			}
			
			if($messageType=='inbox')
			{
			
				$message = new DatabaseObject_ReceiverMessage($this->db);
				
				$message->checkReceiverMessages($this->clubUser->userID, $message_id);
			}
			if($messageType=='outbox')
			{
				$message = new DatabaseObject_SenderMessage($this->db);
				
				$message->checkSenderMessages($this->clubUser->userID, $message_id);
			}
			
			
			if(count($message)==1)
			{
				////echo $message->status;
				$message->delete();
				$this->messenger->addMessage('Message Deleted');
				////echo "messageType is: ".$messageType;
				$this->_redirect($returnAddress);
			}
				
		}
		
		public function nomessageAction()
		{
		
		
		}
		
		public function composeAction()
		{
		
				
				$request=$this->getRequest();
				
				$receiverId = $request->getPost('receiver_id');
				
			if($receiverId>0)
			{
			
				$this->secondMember = new DatabaseObject_User($this->db);
				
				if($this->secondMember->loadByUserId($receiverId))
				{
				
					$fp = new FormProcessor_Message($this->db, $this->clubUser->userID, $receiverId);
					
					if($request->isPost())
					{
						////echo "<br/> Posted";
						if($fp->process($request))
						{
							$this->messenger->addMessage('Your message has been sent.');
							$this->secondMember->sendEmail('message-notice.tpl', $this->signedInUser);
							//$url=$this->getUrl('preview').'?id='.$fp->event->getId();
							$this->_redirect($this->geturl('outbox'));
						}
						else
						{
							$this->messenger->addMessage('You have an error in your post');
	
						}
					}
					
					
					$this->view->fp = $fp;
					if($user->user_type=='member')
					{
						$this->view->receiverType = 'member';
						$this->breadcrumbs->addStep('write to: '.$this->secondMember->profile->last_name.' '.$this->secondMember->profile->first_name);
	
					}
					elseif($user->user_type=='clubAdmin')
					{
						$this->view->receiverType = 'clubAdmin';
						$this->breadcrumbs->addStep('write to: '.$this->secondMember->profile->public_club_name);
					}
				}
				else
				{
						$this->messenger->addMessage('you can not compose this email');
						$this->_redirect($this->getUrl('index'));
				}
				
			}
			else
			{
			
				
				$fp = new FormProcessor_Message($this->db, $this->clubUser->userID);
				$this->view->fp = $fp;
				
				if($this->clubUser->user_type=='member')
				{
					$affiliations = DatabaseObject_Affiliation::loadMemberAffiliation($this->db, $this->clubUser->userID);
					
					
					if(count($affiliations) != 0)
					{
					
						$arrayId=array();
	
						foreach($affiliations as $k =>$v)
						{
							$arrayId[]=$affiliations[$k]['clubAdmin_id'];
						}
						
						
						$options = array(
									'userID'=>$arrayId);
						
						$users=DatabaseObject_User::GetObjects($this->db, $options);
						
						//echo "count of users are: ".count($users);
						
						$this->view->users = $users;
					}
					$this->view->receiverType='clubAdmin';
				}
				elseif($this->clubUser->user_type =='clubAdmin')
				{
					$affiliations = DatabaseObject_Affiliation::loadClubAffiliation($this->db, $this->clubUser->userID);
					
				//	echo "count of affiliations are: ".count($affiliations);
					
					
					if(count($affiliations) != 0)
					{
						$arrayId=array();
						
						foreach($affiliations as $k =>$v)
						{
							$arrayId[]=$affiliations[$k]['member_id'];
						}
						
						
						$options = array('userID'=>$arrayId);
						
						$users=DatabaseObject_User::GetObjects($this->db, $options);
						
						//echo "count of users are: ".count($users);
						
						$this->view->users = $users;
					}
					$this->view->receiverType='member';
				}
			}
		}

	}
?>