<?php 

	class OnlineregistrationsController extends CustomControllerAction
	{
		
		
		public function init()
		{
			parent::init();	
		}
		
		public function preDispatch()
		{
			parent::preDispatch();	
			
		}
		
		public function indexAction()
		{
			$registrations = DatabaseObject_Helper_Registration::retrieveRegistrants($this->db);
			
			$this->view->registrants = $registrations;
			Zend_Debug::dump($registrations);
		}
			
	}
?>