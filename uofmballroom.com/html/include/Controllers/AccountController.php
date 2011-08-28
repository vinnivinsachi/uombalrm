<?php
	//pg 86
	//this is like the smarty_plugin functions in pure smarty design. 
	//Zend handles all the template logic and only uses smarty for displaying. 
	class AccountController extends CustomControllerAction
	{	
		
		public function init()
		{
			parent::init();
			$this->breadcrumbs->addStep('Account', $this->getUrl(null, 'account'));
			$this->identity=Zend_Auth::getInstance()->getIdentity(); //which have a bunch of information about the person. 
			$_SESSION['categoryType'] = 'product';
		}
		
		
		public function preDispatch()
		{
		  /* if (!isset($_SERVER['HTTPS']) && !$_SERVER['HTTPS']) 
		   {
                $request    = $this->getRequest();
                $url        = 'https://'
                            . $_SERVER['HTTP_HOST']
                            . $request->getRequestUri(); 
							
				$this->_redirect($url);
			}*/
							
							
			parent::preDispatch();	
			
		
		}
	
		public function indexAction()
		{
			
			if($this->identity->user_type =='clubAdmin')
			{
				$this->_forward('details');
			//$this->_redirect($this->getCustomUrl(array('username'=>$this->identity->username), "clubpreview"));
			}
			else
			{
				$this->_forward('details');
			}
			
		
			//echo "here at index";
			//this will eventually include the news feed for club organization to monitor action into the organization such as Orders, Reservation for events, and joined memberships. and email will be sent out to the organizer for notification.
			//action
			//$this->_redirect($this->getCustomUrl(array('username' =>$this->identity->username, 'action'=>'index'), 'club'));
		}
	
		/*public function registerAction()
		{
			$request=$this->getRequest();
			
			if($request->getPost('registermember'))
			{
				$this->_redirect($this->getUrl('registermember'));
			}
			else if($request->getPost('registerclub'))
			{
				$this->_redirect($this->getUrl('registerclub'));
			}
			
			$this->breadcrumbs->addStep('Register');
			
		}*/
		
		public function registermemberAction()
		{

				// main page for member registration. 
				
					//main page for club registration.
			$request=$this->getRequest(); //zend function returns all get and post items. 
			
			$fp = new FormProcessor_UsermemberRegistration($this->db);
			
		/*	$validate = $request->isXmlHttpRequest();
			
			//$validate=true;
			
			*/
			if($request->isPost()) //zend function
			{
			
				/*if($validate)
				{
				
					$fp->validateOnly(true);
					$fp->process($request); //process the form but not creating the user.				
					{
						
						echo "you are here at finish";
						$session = new Zend_Session_Namespace('registration'); //this is zend session. it won't cause data conflicts. 
						$session->userID = $fp->user->getId();
						
						
						echo "session id: ".$session->userID;
						//$this->_redirect($this->getUrl('registercomplete', 'account'));
					}
					
				}
				
				
				else*/if($fp->process($request))	//custom defined function in UserRegistration.php
				{
					unset($_SESSION['guestSignIn']);
					$session = new Zend_Session_Namespace('registration'); //this is zend session. it won't cause data conflicts. 
					$session->userID = $fp->user->getId();
					
					$admin = new DatabaseObject_User($this->db);
					$admin->loadByUserId(13);
					
					$admin->sendEmail('member-register-admin-notice.tpl', $fp->user);
					
					$this->_redirect($this->geturl('registercomplete'));
				}
				
			}
			
			/*if($validate)
			{
				//echo "sending shit";
				$json = array('errors'=> $fp->getErrors());
				
				$this->sendJson($json); //sending the json as ajax data stuff. 
			}
			else
			{*/
			
				//$this->breadcrumbs->addStep('Register', $this->getUrl('register'));
				$this->breadcrumbs->addStep('Create an Account');
			//echo "the title of register is: ".$this->breadcrumbs->getTitle();
				$this->view->fp = $fp;  //this triggers the smarty view, and assign smarty variable $fp to the current form processor $fp. 
			//}
			
		}
		
		public function registerclubAction()
		{
				//main page for club registration.
			$request=$this->getRequest(); //zend function returns all get and post items. 
			
			$fp = new FormProcessor_UserRegistration($this->db);
			
			$validate = $request->isXmlHttpRequest();
			
			//$validate=true;
			
			
			if($request->isPost()) //zend function
			{
			
				if($validate)
				{
					$fp->validateOnly(true);
					$fp->process($request); //process the form but not creating the user.
				}
				
				
				else if($fp->process($request))	//custom defined function in UserRegistration.php
				{
					unset($_SESSION['guestSignIn']);
					$session = new Zend_Session_Namespace('registration'); //this is zend session. it won't cause data conflicts. 
					$session->userID = $fp->user->getId();
					
					//$fp->user->sendEmail('user-register.tpl');
					
					$this->_redirect($this->getUrl('registercomplete'));
				}
			}
			
			if($validate)
			{
				//echo "sending shit";
				$json = array('errors'=> $fp->getErrors());
				
				$this->sendJson($json); //sending the json as ajax data stuff. 
			}
			else
			{
				$this->breadcrumbs->addStep('Register', $this->getUrl('register'));

				$this->breadcrumbs->addStep('Create an Account');
			//echo "the title of register is: ".$this->breadcrumbs->getTitle();
				$this->view->fp = $fp;  //this triggers the smarty view, and assign smarty variable $fp to the current form processor $fp. 
			}
			
		
		}
		
		public function guestAction()
		{
			if(isset($_SESSION['guestSignIn']))
			{
			
				//echo "here at redirect to guest checkout";
				$this->_redirect($this->getUrl('guest','checkout'));
			
			}
			else
			{
				if($this->cartObject>0)
				{
					//unset($_SESSION['guestSignIn']);
					$request=$this->getRequest(); //zend function returns all get and post items. 
					
					$fp = new FormProcessor_Guest($this->db);
					
					$validate = $request->isXmlHttpRequest();
					
					//$validate=true;
					
					
					if($request->isPost()) //zend function
					{
					
						if($validate)
						{
							$fp->validateOnly(true);
							$fp->process($request); //process the form but not creating the user.
						}
						
						
						else if($fp->process($request))	//custom defined function in UserRegistration.php
						{
							$_SESSION['guestSignIn']=$fp->guest->getId();
							
							//echo "here at redirect guest checkout";
							$this->_redirect($this->getUrl('guest', 'checkout'));
							
							
							
							//echo $fp->guest->getId();
							//$fp->user->sendEmail('user-register.tpl');
							//redirects to check out guest. 
							//$this->_redirect($this->getUrl('registercomplete'));
						}
					}
					
					if($validate)
					{
						//echo "sending shit";
						$json = array('errors'=> $fp->getErrors());
						
						$this->sendJson($json); //sending the json as ajax data stuff. 
					}
					else
					{
						//$this->breadcrumbs->addStep('Register', $this->getUrl('register'));
		
						//$this->breadcrumbs->addStep('Guest Shipping Information');
					//echo "the title of register is: ".$this->breadcrumbs->getTitle();
						$this->view->fp = $fp;  //this triggers the smarty view, and assign smarty variable $fp to the current form processor $fp. 
					}
				}
				else
				{
					//echo "at carobject not greater than 0";
					$this->_redirect($this->getUrl('index','index'));
				}
		
			}
		
		}
		
		public function detailsAction()
		{
			$auth = Zend_Auth::getInstance();
			
			$user = new DatabaseObject_User($this->db);
			
			if(!$user->loadByUserId(Zend_Auth::getInstance()->getIdentity()->userID))
			{
				//echo "you can not load this user";
				$this->_redirect($this->getUrl());
			}
			
			
			$options=array('user_id' =>Zend_Auth::getInstance()->getIdentity()->userID); //loading images
			
			$images = DatabaseObject_Image::GetImages($this->db, $options, 'user_id', 'users_profiles_images');
			$user->images=$images;
			
			$this->view->user=$user;
			
			
			$fp = new FormProcessor_UserDetails($this->db, $auth->getIdentity()->userID);
			
			$request=$this->getRequest();
			//there needs to be a cancel button redirect here.
			
			//echo $request->getPost('club_description');
			$edit = $request->getParam('edit');
			if($edit=="true")
			{
			
			$this->view->edit = "true";
			}
			else
			{
			$this->view->edit = "false";
			}
			
			
			if($request->isPost())
			{ 
				if($fp->process($request))
				{	
					$auth->getStorage()->write($fp->user->createAuthIdentity());
					$this->_redirect($this->getUrl('detailscomplete')); 
				}
			}
			
			$this->breadcrumbs->addStep('Your Account Details');
			$this->view->fp=$fp;
		}
		
		public function detailscompleteAction()
		{
			$user=new DatabaseObject_User($this->db);
			$user->load(Zend_Auth::getInstance()->getIdentity()->userID);
			
			
			$this->breadcrumbs->addStep('Your Account Details', $this->getUrl('details'));
			$this->breadcrumbs->addStep('Details updated');
			
			$this->view->user=$user;
		}
		
		public function registercompleteAction()
		{
			//retrive the same session namespace used in register
			$session = new Zend_Session_Namespace('registration');
			
			//load the user record based on the stored user ID
			$user = new DatabaseObject_User($this->db);
			
			if(!$user->load($session->userID))
			{
				echo "here at unable to load";
									//	$this->messenger->addMessage('beforeRedirect');

				$this->_forward('register');
				return;
			}
			
			//$user->sendEmail('user-register.tpl');
			//echo "here at able to load";
			
			$this->breadcrumbs->addStep('Create an Account', $this->getUrl('register'));
			$this->breadcrumbs->addStep('Account Created');
			
			$this->view->user = $user;
		}
		
		//pg 103
		public function loginAction()
		{
			//if a user's already logged in, send them to their account home page
			$auth = Zend_Auth::getInstance();
			
			//echo "here1";
			if($auth->hasIdentity())
			{
				$this->_redirect('/index');
			}
			
			$request=$this->getRequest();
			
			if($request->getPost('register'))
			{
				$this->_redirect($this->geturl('registermember', 'account'));
			}
			
				//determin the page the user was originally trying t request
			$redirect = $request->getPost('redirect');
			
			//echo "<br><br>".$redirect."<br><br>";
			if(strlen($redirect)==0)
			{
				//echo "here 1.5";
				//--------------------------------------------------------------
				$redirect= $request->getServer('REQUEST_URI');
				//$redirect= str_replace("phpweb20/htdocs/","",$redirect); //this must be deleted in a real server. 
			}
			if(strlen($redirect)==0)
			{
				//echo "here 1.7";
				$redirect = '/index';
			}
			
			if($request->getPost('guest') && (count($this->cartObject)>0))
			{
				
				$_SESSION['guest']=$this->shoppingCart->getCartID();
				//echo "there is session: ".$session['guest'];
				return $this->_redirect($this->getUrl('guest', 'account')); 
			}
			 
			//initialize errors
			$errors=array(); 
			//echo "here2";			
			//process login if request method is post
			
			//echo "post: ".$request->isPost()."<br>";
			if($request->isPost())
			{
				//fetch login details from form and validate them
				//echo "here3";
				$username= DatabaseObject_StaticUtility::cleanHtml($request->getPost('username'));
				
			
				$password= DatabaseObject_StaticUtility::cleanHtml($request->getPost('password'));
				
				if(strlen($username)==0)
				{
					$errors['username']='Required field must not be blank';
				}
				if(strlen($password)==0)
				{
					$errors['password']='Required field must not be blank';
				}
				
				if(count($errors)==0)
				{
					//setup teh authentication adapter
					//Zend_auth_adapter_dbtable takes($database, $table, $identity, $password, $passwordtreatment
					$adapter = new Zend_Auth_Adapter_DbTable($this->db, 'users', 'username', 'password', 'md5(?)');
					$adapter->setIdentity($username);
					$adapter->setCredential($password);
					
					//try and authenticate the user
					$result = $auth->authenticate($adapter);
					
					//$_SESSION['clubUsername']=$username;
					if($result->isValid())
					{
						unset($_SESSION['guest']);
						unset($_SESSION['guestSignIn']);
						$user=new DatabaseObject_User($this->db);
						
						$user->load($adapter->getResultRowObject()->userID);
		
						//record login attemp
						$user->loginSuccess(); //in user.php
						
						//create identity data and write it to session
						$identity = $user->createAuthIdentity(); //in user.php
						//echo "<br/>First name".$identity->first_name;
						//echo "<br/>Last name".$identity->last_name;
						$auth->getStorage()->write($identity); //writing more stuff in the identity data stored in session. rewrite the new identity created in users into our ZendAuth_Session_write stuff. //anypage can ues this information.
						
						//send user to page they originally request
						$this->_redirect($redirect);
					}
					
					
					//record failed login attempt
					DatabaseObject_User::LoginFailure($username,$result->getCode()); //in user.php
					
					$errors['username'] = 'Your login details were invalid';
				}
			}
			
			//echo "here4";
			$this->breadcrumbs->addStep('Login');
			$this->view->errors=$errors; //displaying the template
			$this->view->redirect=$redirect;

		}
		
		public function logoutAction()
		{
			Zend_Auth::getInstance()->clearIdentity();
			
			$shoppingCart = new DatabaseObject_ShoppingCart($this->db);
			
			if(strlen($shoppingCart->getCartID())>0)
			{
				//echo "you are here at loggout action with a shopping cart existing";
				$shoppingCart->deleteShoppingCart($shoppingCart->getCartID());
				//echo "<br/>you now no longer have a shopping cart.";
			}
			
			//echo "you are here at signing out";
			unset($_SESSION['guestSignIn']);

			return $this->_redirect($this->geturl('index', 'index'));	
		}
		
		
		
		public function fetchpasswordAction()
		{
			//if a user's already loged in, send them to the thier account home page
			
			if(Zend_Auth::getInstance()->hasIdentity())
			{
				$this->_redirect('/account');
			}
				
			$errors = array();
			
			$action = $this->getRequest()->getQuery('action');
			
			if($this->getRequest()->isPost())
			{
				$action = 'submit';
			}
			
			switch($action)
			{
				case 'submit':
					$username = trim($this->getRequest()->getPost('username'));
					
					if(strlen($username)==0)
					{
						$errors['username']='Required field must not be blank';
					}
					else
					{
						$user= new DatabaseObject_User($this->db);
						if($user->load($username, 'username'))
						{
							$user->fetchPassword();
							
							$url = '/account/fetchpassword?action=complete';
							
							$this->_redirect($url);
						}
						else
						{
							$errors['username'] ='Specified user not found';
						}
					}
					break;
				
				case 'complete':
					//nothing to do
					break;
				
				case 'confirm':
					$id = $this->getRequest()->getQuery('id');
					$key = $this->getRequest()->getQuery('key');
					
					$user= new DatabaseObject_User($this->db);
					
					if(!$user->load($id))
					{
					
						echo "here at bad load";
						$errors['confirm'] = 'Error confirming new password at badload			';
					}
					elseif(!$user->confirmNewPassword($key))
					{
						echo "here at bad key";
						$errors['confirm'] = 'Error confirming new password at bad key';
					}
					
					break;
			}
					
					$this->view->errors = $errors;
					$this->view->action = $action;
			
		}		
		
		
		
		
		public function imagesAction()
		{
		
			$request= $this->getRequest();
			$json = array();
			
			
			$user_id=(int)$request->getPost('id');
			
			
			$user = new DatabaseObject_User($this->db);
			
			if(!$user->load(Zend_Auth::getInstance()->getIdentity()->userID))
			{
				//echo "you can not load this user";
				$this->_redirect($this->getUrl());

			}
			//echo "here";
			if($request->getPost('upload'))
			{
				$fp=new FormProcessor_Image($user);
				//echo "you are here";
				
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
				//*/
			}
			elseif($request->getPost('reorder'))
			{
				
				$order = $request->getPost('post_images');
				
				$options=array('user_id' =>Zend_Auth::getInstance()->getIdentity()->userID); //loading images
			
				$images = DatabaseObject_Image::GetImages($this->db, $options, 'user_id', 'users_profiles_images');
				$user->images=$images;
			
				$user->setImageOrder($order);
				
			}
			elseif($request->getPost('delete'))
			{
				
				$image_id = (int) $request->getPost('image');
				
				
				$image = new DatabaseObject_Image($this->db);
				
				if($image->loadForPost($user->getId(), $image_id))
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
				//*/
			}
			
			
			if($request->isXmlHttpRequest())
			{
				$this->sendJson($json);
			}
			else
			{
			$url = $this->getUrl('details');
			$this->_redirect($url);
			}
			
			
		}
		
	}
?>