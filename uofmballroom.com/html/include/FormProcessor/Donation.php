<?php



	class FormProcessor_Donation extends FormProcessor  //so this zend looks at the controller folder FormProcessor and finds the file UserRegistration. 
	{
		protected $db = null;
		public $donator = null;
		protected $_validateOnly = false;
		
		public function __construct($db){
			parent::__construct();
			
			$this->db= $db;
			$this->donator = new DatabaseObject_Donator($db);
			
		}
		
		public function validateOnly($flag){
			$this->_validateOnly =(bool)$flag;
		}
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			$this->donateAmount = $this->sanitize($request->getPost('donateAmount'));
			$this->inputDonateAmount = $this->sanitize($request->getPost('inputDonateAmount'));
			
			if($this->donateAmount==0 && strlen($this->inputDonateAmount)==0)
			{
				$this->addError('donateAmount', 'Please enter your desired gift');
			}
			elseif($this->donateAmount==0 && is_numeric($this->inputDonateAmount))
			{
				$this->totalDonateAmount = $this->donateAmount +$this->inputDonateAmount;
			
				$this->donator->donate_amount = $this->donateAmount;
				$this->donator->input_donate_amount = $this->inputDonateAmount;
				$this->donator->total_donate_amount = $this->donateAmount +$this->inputDonateAmount;
			}else{
				$this->totalDonateAmount = $this->donateAmount +$this->inputDonateAmount;
			
				$this->donator->donate_amount = $this->donateAmount;
				$this->donator->input_donate_amount = $this->inputDonateAmount;
				$this->donator->total_donate_amount = $this->donateAmount +$this->inputDonateAmount;
			}
			
			//validate the user's name
			$this->first_name= $this->sanitize($request->getPost('first_name')); //sanitize uses FormProcessor's zend_filter funciton to clean strings. 
			if(strlen($this->first_name) ==0)
			{
				$this->addError('first_name', 'Please enter your first name');
			}
			else
			{
				$this->donator->first_name = $this->first_name;
			}
			
			$this->last_name = $this->sanitize($request->getPost('last_name'));
			if(strlen($this->last_name)==0)
			{
				$this->addError('last_name', 'Please enter your last_name');
			}
			else
			{
				$this->donator->last_name = $this->last_name;
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
				$this->donator->email = strtolower($this->email);
			}
			
			$this->phone = $this->sanitize($request->getPost('phone'));
			
			if(strlen($this->phone)==0)
			{

				$this->addError('phone', 'Please enter you address address');
			}
			else
			{
				$this->donator->phone = strtolower($this->phone);
			}
			
			$this->address = $this->sanitize($request->getPost('address'));
			
			if(strlen($this->address)==0)
			{

				$this->addError('address', 'Please enter you address address');
			}
			else
			{
				$this->donator->address = strtolower($this->address);
			}
			
			$this->zip = $this->sanitize($request->getPost('zip'));
			
			if(strlen($this->zip)==0)
			{

				$this->addError('zip', 'Please enter you zip');
			}
			else
			{
				$this->donator->zip = strtolower($this->zip);
			}
			
			$this->city = $this->sanitize($request->getPost('city'));
			
			if(strlen($this->city)==0)
			{

				$this->addError('city', 'Please enter you city');
			}
			else
			{
				$this->donator->city = strtolower($this->city);
			}
			
			
			$this->state = $this->sanitize($request->getPost('states'));
			
			if(strlen($this->state)==0)
			{

				$this->addError('states', 'Please enter your state');
			}
			else
			{
				$this->donator->state = strtolower($this->state);
			}
			//echo $request->getPost('clubAdmin');
			//$this->user->user_type = $request->getPost('clubAdmin');
			//if no erros have occured, save the user 
			if(!$this->_validateOnly && !$this->hasError())
			{
				$this->donator->save();
			}
			//return true if no errors have occurred
			return !$this->hasError();	
		}
	}
?>		