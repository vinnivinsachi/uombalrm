<?php
	//the alphabet link is only for testing as of now. it is not incorporated into anyother pages. 
	
	//require_once 'Zend/Controller/Action.php'; 
	
	//require_once 'reader.php';

	
	class UmichcompetitionController extends CustomControllerAction
	{
	
		protected $university;
	
		public function preDispatch()
		{
			parent::preDispatch();	
			$_SESSION['categoryType'] = 'post';
		}
		
		public function phototestAction()
		{
			
		}
		
	
		public function indexAction()
		{
			$request=$this->getRequest();
			$year = $request->getUserParam('year');
			$info = $request->getUserParam('info');

			//echo "info is $info";
			$infoArray=array('info','difference','tickets','rules','fees','registration','officialjudges','housing','venue','directions','sponsorship','theboard');
			
			if(in_array($info, $infoArray)){
				$this->view->year = $year;
				$this->view->info = $info;
			}
			else{
				$this->view->year = 2010;
				$this->view->info = 'info';
			}
			
			$this->view->SecondTier='Competition';
			$this->view->Banner='true';
		}
		
		public function testAction()
		{
			$this->view->SecondTier='Competition';
			$this->view->year = '2010';
		}

}
?>