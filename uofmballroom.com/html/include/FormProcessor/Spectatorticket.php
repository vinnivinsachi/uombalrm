<?php



	class FormProcessor_Spectatorticket extends FormProcessor  //so this zend looks at the controller folder FormProcessor and finds the file UserRegistration. 
	{
		protected $db = null;
		public $spectator = null;
		protected $_validateOnly = false;
		
		public function __construct($db){
			parent::__construct();
			
			$this->db= $db;
			$this->spectator = new DatabaseObject_SpectatorTicket($db);
			
		}
		
		public function validateOnly($flag){
			$this->_validateOnly =(bool)$flag;
		}
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			$this->adultFullDayPass = $this->sanitize($request->getPost('adultFullDayPass'));
			$this->adultNightPass = $this->sanitize($request->getPost('adultNightPass'));
			$this->studentPass = $this->sanitize($request->getPost('studentPass'));
			
			if($this->adultFullDayPass==0&&$this->adultNightPass==0&&$this->studentPass==0)
			{
				$this->addError('passError', 'Please select at least one type of ticket.');
			}else{
				$this->total_cost = (int)$this->adultFullDayPass*10+(int)$this->adultNightPass*8+(int)$this->studentPass*5;
				$this->spectator->adult_full_day_pass = $this->adultFullDayPass;
				$this->spectator->adult_night_pass = $this->adultNightPass;
				$this->spectator->student_pass = $this->studentPass;
				$this->spectator->total_cost = $this->total_cost;
			}
			
			//validate the user's name
			$this->first_name= $this->sanitize($request->getPost('first_name')); //sanitize uses FormProcessor's zend_filter funciton to clean strings. 
			if(strlen($this->first_name) ==0)
			{
				$this->addError('first_name', 'Please enter your first name');
			}
			else
			{
				$this->spectator->first_name = $this->first_name;
			}
			
			$this->last_name = $this->sanitize($request->getPost('last_name'));
			if(strlen($this->last_name)==0)
			{
				$this->addError('last_name', 'Please enter your last_name');
			}
			else
			{
				$this->spectator->last_name = $this->last_name;
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
				$this->spectator->email = strtolower($this->email);
			}
			
			$this->phone = $this->sanitize($request->getPost('phone'));
			
			if(strlen($this->phone)==0)
			{

				$this->addError('phone', 'Please enter you address address');
			}
			else
			{
				$this->spectator->phone = strtolower($this->phone);
			}
			
			$this->address = $this->sanitize($request->getPost('address'));
			
			if(strlen($this->address)==0)
			{

				$this->addError('address', 'Please enter you address address');
			}
			else
			{
				$this->spectator->address = strtolower($this->address);
			}
			
			$this->zip = $this->sanitize($request->getPost('zip'));
			
			if(strlen($this->zip)==0)
			{

				$this->addError('zip', 'Please enter you zip');
			}
			else
			{
				$this->spectator->zip = strtolower($this->zip);
			}
			
			$this->city = $this->sanitize($request->getPost('city'));
			
			if(strlen($this->city)==0)
			{

				$this->addError('city', 'Please enter you city');
			}
			else
			{
				$this->spectator->city = strtolower($this->city);
			}
			
			
			$this->state = $this->sanitize($request->getPost('states'));
			
			if(strlen($this->state)==0)
			{

				$this->addError('states', 'Please enter your state');
			}
			else
			{
				$this->spectator->state = strtolower($this->state);
			}
			//echo $request->getPost('clubAdmin');
			//$this->user->user_type = $request->getPost('clubAdmin');
			//if no erros have occured, save the user 
			if(!$this->_validateOnly && !$this->hasError())
			{
				$this->spectator->save();
			}
			//return true if no errors have occurred
			return !$this->hasError();	
		}
	}
?>		