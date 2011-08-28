<?php



	class FormProcessor_ShoutOut extends FormProcessor  //so this zend looks at the controller folder FormProcessor and finds the file UserRegistration. 
	{
		protected $db = null;
		public $shoutout = null;
		protected $_validateOnly = false;
		
		public function __construct($db){
			parent::__construct();
			
			$this->db= $db;
			$this->shoutout = new DatabaseObject_ShoutOut($db);
			
		}
		
		public function validateOnly($flag){
			$this->_validateOnly =(bool)$flag;
		}
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			
			//validate the user's name
			$this->your_name= $this->sanitize($request->getPost('your_name')); //sanitize uses FormProcessor's zend_filter funciton to clean strings. 
			if(strlen($this->your_name) ==0)
			{
				$this->addError('your_name', 'Please enter your_name');
			}
			else
			{
				$this->shoutout->your_name = $this->your_name;
			}
			
			$this->phone= $this->sanitize($request->getPost('phone')); //sanitize uses FormProcessor's zend_filter funciton to clean strings. 
			if(strlen($this->phone) ==0)
			{
				$this->addError('phone', 'Please enter your phone number');
			}
			else
			{
				$this->shoutout->phone = $this->phone;
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
				$this->shoutout->email = strtolower($this->email);
			}
			
			
			$this->type = $this->sanitize($request->getPost('type'));
			if(strlen($this->type)==0){
				$this->addError('type', 'Please select a type');
			}
			else{
				$this->shoutout->type = $this->type;
			}
			
			$this->text = $this->sanitize($request->getPost('text'));
			if(strlen($this->text)==0){
				$this->addError('text', 'Please enter your information');
			}
			else{
				$this->shoutout->text = $this->text;
			}
			
			if($this->type =='oneline')
			{
				$this->shoutout->price = 20;
			}elseif($this->type=='quarterPage')
			{
				$this->shoutout->price = 50;
			}elseif($this->type=='halfPage')
			{
				$this->shoutout->price=100;
			}else{
				$this->addError('price', 'You must select the appropirate type of shout out');
			}
				
			
			//echo $request->getPost('clubAdmin');
			//$this->user->user_type = $request->getPost('clubAdmin');
			//if no erros have occured, save the user 
			if(!$this->_validateOnly && !$this->hasError())
			{
				$this->shoutout->save();
			}
			//return true if no errors have occurred
			return !$this->hasError();	
		}
	}
?>		