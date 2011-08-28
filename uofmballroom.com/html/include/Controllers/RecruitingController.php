<?php
	//the alphabet link is only for testing as of now. it is not incorporated into anyother pages. 
	
	//require_once 'Zend/Controller/Action.php'; 
	
	class RecruitingController extends CustomControllerAction
	{
	
		protected $university;
	
		public function preDispatch()
		{
			parent::preDispatch();	
			$_SESSION['categoryType'] = 'product';
		}
	
	
		public function indexAction()
		{
		
			
			
		}
		
		public function provideAction()
		{
		
		
		}
		
		public function practiceAction()
		{
		
		
		}
		
		public function dancesAction()
		{
		
		
		}
		
		public function competitionAction()
		{
		
		
		}
		
		public function structureAction()
		{
		
		
		}
		
		public function forumAction()
		{
		
		
		}
		
		public function faqAction()
		{
		
		
		}
		
		
		
		public function helpAction()
		{
		
		
		}
		
		public function termsAction()
		{
		
			$this->breadcrumbs->addStep('Terms');

		}
		
		public function contactAction()
		{
		
		
		
		
		
		}
		
		
			
		public function testAction()
		{
		

					//$this->_helper->viewRenderer->setNoRender();

		 
			/*
			excell checker
			$this->_helper->viewRenderer->setNoRender();
			header ( "Expires: 0" );
			header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
			header ( "Pragma: no-cache" );
			header ( "Content-type: application/x-msexcel" );
			header ( "Content-Disposition: attachment; filename=test.xls" );
			header ( "Content-Description: PHP Generated XLS Data" );
			
			$data = array(
					array('name'=>'joe', 'id'=>5, 'phone'=>'615-957-4320'),
					array('name'=>'bob', 'id'=>6, 'phone'=>'615-322-8419'));
		
		
			echo "<table>
					<tr>
						<td><strong>Name:</strong></td><td><strong>Id:</strong></td><td><strong>phone</strong></td>
					</tr>";
		
			foreach($data as $k=>$v)
			{
			
				echo "<tr>
						<td>".$data[$k]['name']."</td><td>".$data[$k]['id']."</td><td>".$data[$k]['phone']."</td></tr>";
			}
			
			echo "</table>";
			*/
		}

}
?>