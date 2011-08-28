<?php
/*****
 *pg 80
 *Form processor_userRegistration is a child of Form Processor
 *It set variables by using parent _set() function.
 *
 *NOTE: EMAIL CONFIRMATION OF SIGNUPS WILL BE NEEDED on 
 *
 */


	class FormProcessor_UserRegistration extends FormProcessor  //so this zend looks at the controller folder FormProcessor and finds the file UserRegistration. 
	{
		protected $db = null;
		public $user = null;
		protected $_validateOnly = false;
		
		public $publicProfile = array(
			'public_club_name' => 'Club name',
			'public_club_email' => 'Email',
			'public_club_website' => 'Website'

			);
		
		
		public function __construct($db)
		{
			parent::__construct();
			
			$this->db= $db;
			$this->user = new DatabaseObject_User($db);
			
			$this->universities = DatabaseObject_StaticUtility::loadUniversities($db);
			
			$this->club_types = DatabaseObject_StaticUtility::loadTypes($db);

		}
		
		public function validateOnly($flag)
		{
			$this->_validateOnly =(bool)$flag;
		}
		
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			$this->university_id = (int)$request->getPost('university');
			if($this->university_id ==0)
			{
				$this->addError('university', 'Please select an university from the above list');
			}
			else
			{
				$this->user->university_id = $this->university_id;
			}
			
			$this->type_id = (int)$request->getPost('types');
			if($this->type_id ==0)
			{
				$this->addError('types', 'Please select an type from the above list');
			}
			else
			{
				$this->user->type_id = $this->type_id;
			}
			
			//validate the username
			$this->username = trim($request->getPost('username')); //contraint the post item from request
			//echo $this->username;
			
			//echo "the existance fo the user name: ".$this->user->usernameExists($this->username);
				
			if(strlen($this->username)==0)
			{
				//echo "here";
				$this->addError('username', 'Please enter a username');
			}
			else if(!DatabaseObject_User::IsValidUsername($this->username))
			{
				//echo "here2";
				$this->addError('username', 'Please enter a valid username');
			}
			else if($this->user->usernameExists($this->username))	
			{
				$this->addError('username', 'The selected username is already taken');
			}
			else
			{
				//echo "here3";
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
				$this->addError('last_name', 'Please enter your last_name');
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
			
			
			//---------------------------------------------------------
			foreach($this->publicProfile as $key =>$label)
			{
				$this->$key = $this->sanitize($request->getPost($key));
				$this->user->profile->$key = $this->$key;
			}
			
			$this->paypalEmail = $this->sanitize($request->getPost('paypalEmail'));
			if(!empty($this->paypalEmail))
			{
			$this->user->profile->paypalEmail = $this->paypalEmail;
			}
			
			$this->club_description = FormProcessor_BlogPost::cleanHtml($request->getPost('club_description'));
			//echo "the current club_description is: ".$this->club_description;
			if(!empty($this->club_description))
			{
			$this->user->profile->club_description = $this->club_description;
			}
			
			//--------------------------------------------------------
			
			//validate CAPTCHA phrase
			$session= new Zend_Session_Namespace('captcha');
			$this->captcha = $this->sanitize($request->getPost('captcha'));
			
			if($this->captcha !=$session->phrase)
			{
				$this->addError('captcha', 'Please enter the correct phrase');
			}
			
			//echo $request->getPost('clubAdmin');
			$this->user->user_type = $request->getPost('clubAdmin');
			
			//if no erros have occured, save the user 
			if(!$this->_validateOnly && !$this->hasError())
			{
				$this->user->save();
				unset($session->phrase);

			}
			
			//return true if no errors have occurred
			return !$this->hasError();
			
		}
		
	}
?>		