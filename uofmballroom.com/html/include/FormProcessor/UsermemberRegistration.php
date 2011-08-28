<?php
/*****
 *pg 80
 *Form processor_userRegistration is a child of Form Processor
 *It set variables by using parent _set() function.
 *
 *NOTE: EMAIL CONFIRMATION OF SIGNUPS WILL BE NEEDED on 
 *
 */


	class FormProcessor_UsermemberRegistration extends FormProcessor  //so this zend looks at the controller folder FormProcessor and finds the file UserRegistration. 
	{
		protected $db = null;
		public $user = null;
		protected $_validateOnly = false;
		
		
		public $universities = null;
		
		public function __construct($db)
		{
			parent::__construct();
			
			$this->db= $db;
			$this->user = new DatabaseObject_User($db);
			
			$this->universities = DatabaseObject_StaticUtility::loadUniversities($db);
						
		}
		
		public function validateOnly($flag)
		{
			$this->_validateOnly =(bool)$flag;
		}
		
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			$this->university_id = $request->getPost('university');
			if($this->university_id =='0')
			{
								//echo "uni name is: ".$this->university_id;

				$this->addError('university', 'Please select an university from the above list');
			}
			else
			{
				//echo "uni name is: ".$this->university_id;
				$this->user->university_id = $this->university_id;
			}
			
			//validate the username
			$this->username = trim($request->getPost('username')); //contraint the post item from request
			//echo $this->username;
			
			//echo "the existance fo the user name: ".$this->user->usernameExists($this->username);
				
			if(strlen($this->username)==0)
			{
				$this->addError('username', 'Please enter a username');
			}
			else if(!DatabaseObject_User::IsValidUsername($this->username))
			{
				$this->addError('username', 'Please enter a valid username');
			}
			else if($this->user->usernameExists($this->username))	
			{
				$this->addError('username', 'The selected username is already taken');
			}
			else
			{
				$this->user->username= $this->username;
				//echo "<br/> and the current name is: ".$this->user->username;
			}
			
			
			
			//validate the user's name
			$this->first_name= $this->sanitize($request->getPost('first_name')); //sanitize uses FormProcessor's zend_filter funciton to clean strings. 
			if(strlen($this->first_name) ==0)
			{
				$this->addError('first_name', 'Please enter your first name');
			}
			else
			{
				$this->user->profile->first_name = $this->first_name;
				$this->user->first_name = $this->first_name;
			}
			
			$this->last_name = $this->sanitize($request->getPost('last_name'));
			if(strlen($this->last_name)==0)
			{
				$this->addError('last_name', 'Please enter your last name');
			}
			else
			{
				$this->user->profile->last_name = $this->last_name;
				$this->user->last_name = $this->last_name;
			}
			
			
			$this->email = $this->sanitize($request->getPost('email'));
			$validator = new Zend_Validate_EmailAddress();
			
			if(strlen($this->email)==0)
			{

				$this->addError('email', 'Please enter you email address');
			}
			elseif(!$validator->isValid($this->email))
			{
				$this->addError('email', 'Please enter a valid email address');
			}
			else
			{
				$this->user->profile->email = strtolower($this->email);
			}
			
			
			$this->address = $this->sanitize($request->getPost('address'));
			
			if(strlen($this->address)==0)
			{

				$this->addError('address', 'Please enter you address address');
			}
			else
			{
				$this->user->profile->address = strtolower($this->address);
			}
			
			$this->zip = $this->sanitize($request->getPost('zip'));
			
			if(strlen($this->zip)==0)
			{

				$this->addError('zip', 'Please enter you zip');
			}
			else
			{
				$this->user->profile->zip = strtolower($this->zip);
			}
			
			$this->city = $this->sanitize($request->getPost('city'));
			
			if(strlen($this->city)==0)
			{

				$this->addError('city', 'Please enter you city');
			}
			else
			{
				$this->user->profile->city = strtolower($this->city);
			}
			
			
			$this->state = $this->sanitize($request->getPost('states'));
			
			if(strlen($this->state)==0)
			{

				$this->addError('states', 'Please enter your state');
			}
			else
			{
				$this->user->profile->state = strtolower($this->state);
			}
			
			//validate CAPTCHA phrase
			$session= new Zend_Session_Namespace('captcha');
			$this->captcha = $this->sanitize($request->getPost('captcha'));
			
			if($this->captcha !=$session->phrase)
			{

				$this->addError('captcha', 'Please enter the correct phrase');
			}
			
			//validating the correct password
			$this->password = $this->sanitize($request->getPost('password'));
			$this->confirm_password = $this->sanitize($request->getPost('confirm_password'));
			
			if(empty($this->password) && !empty($this->confirm_password))
			{
				$this->addError('password', 'please enter the password');
			}
			elseif(!empty($this->password) && empty($this->confirm_password))
			{
				$this->addError('confirm_password', 'please ReEnter your password above');
			}
			elseif($this->password != $this->confirm_password)
			{
				$this->addError('confirm_password', 'the ReEntered password does not match the above passowrd');
			}
			elseif($this->password=='' && $this->confirm_password=='')
			{
				//nothing.
				//echo "here at nothing with password";
			}
			else
			{
				//echo "password changed";
				$this->user->password = $this->password;
			}
			
			//echo $request->getPost('clubAdmin');
			$this->user->user_type = $request->getPost('clubAdmin');
			$this->user->status = 'L';
			$this->user->type_id = 0;
			
			//if no erros have occured, save the user 
			if(!$this->_validateOnly && !$this->hasError())
			{
				$this->user->save();
				unset($session->phrase);
				

			}
			
		
			return !$this->hasError(); 
			
		}
		
	}
?>		