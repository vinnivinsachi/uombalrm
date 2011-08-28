<?php
	class CharityballController extends Profilehelper
	{
		
			
		public function preDispatch()
		{
			
			//call parent mehtods to perform standard predispatch tasks
			parent::preDispatch();
			
		}
		
		public function indexAction()
		{
			$this->_redirect('clubpost/uofmballroom/cat?category=CharityBall2010&tags=CharityBall2010');
		}
	}

?>