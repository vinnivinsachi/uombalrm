<?php
// promotion currently works as an event!!! so Promotion controller, promotion database object, promotion profile object, all promotion tables in database does not work!!!


	class PromotionController extends CustomControllerAction
	{
		protected $databaseColumn='promotion_id';
	
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('promotion manager', $this->getUrl(null, 'eventmanager'));
			$this->identity=Zend_Auth::getInstance()->getIdentity();
			$user = new DatabaseObject_User($this->db);
			if($user->loadByUserId($this->identity->userID))
			{
			$this->view->clubManager =$user;
			}
			$_SESSION['categoryType'] = 'promotion';
		
		}
	
		public function indexAction()
		{
		
		
		
		
		}
	
	
	}
	
?>