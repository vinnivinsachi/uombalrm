<?php
	//the alphabet link is only for testing as of now. it is not incorporated into anyother pages. 
	
	//require_once 'Zend/Controller/Action.php'; 
	
	//require_once 'reader.php';

	
	class IndexController extends CustomControllerAction
	{
	
		protected $university;
	
		public function preDispatch()
		{
			parent::preDispatch();	
			$_SESSION['categoryType'] = 'post';
			
			$response = $this->getResponse();
			$response->setHeader('ExpiresDefault', 'access plus 2 month');
			$response->setHeader('FileETag', 'none');
		}
		
		public function phototestAction()
		{
			
		}
		
		public function errorAction(){
				
		}
		
		public function compresultAction()
		{
			
			$comp= $this->getRequest()->getQuery('competition');
			$year=$this->getRequest()->getQuery('year');
			
			if($comp==''||$year=='')
			{
				$this->view->error = 'you have not selected a comp';
			
			}
			else
			{
				$this->view->comp=$comp.$year;
			}
		}
		
	
		public function indexAction()
		{
		
			$post = new DatabaseObject_BlogPost($this->db);
			
				foreach($this->alphabetLink as $k=>$v)
			{
				$this->alphabetLink[$k] =$this->getCustomUrl(array('username' =>'uofmballroom', 'action'=>'index'), 'clubpost').'?alphabetLink='.$k;
				//echo "<br/>Link: ".$alphabetLink[$k];
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			
			$pageNumber = $this->getRequest()->getQuery('limitpage');
			
			
			//-------------------------------This might be simplified simply retrieve the count of 
			
			//--------------------One might create a new database that contains the objects amounts of the users
			//example: chinamannnz: product: 5, events: 7, memberships: 10
			//--------------------------------------------------------------------------------------------------------
			
		
				$options = array('user_id' =>'1',
							 'limit'=>1,
			                 'status' =>DatabaseObject_BlogPost::STATUS_LIVE,
							 'alphabetLink'  => $alphabet,
							 'order' => 'p.ts_created desc',
							 'brand' =>'News',
							 'style' =>'Home'

							);
							
				$objects = $post->GetObjects($this->db, $options); 
				$this->view->currentPage=$pageNumber;
			
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;					
			
			
			$this->view->paginationLink = $this->getCustomUrl(array('username'=>'uofmballroom', 'action'=>'index'), "clubpost");
			
			
			//echo "here";
			$this->view->posts=$objects;
			
			$this->view->SecondTier='Home';
			$this->view->Banner='true';
			//$this->_helper->viewRenderer->setNoRender(); 
			//header('Content-type: text/xml');  
			//echo "<response><data><row><answer>Yes</answer></row></data></response>";
			$this->view->lightwindow='true';
			
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
		
		
		public function calendarAction()
		{
		
		
		}
		
			
		public function testAction()
		{
		
		

			// initialize reader object
		/*	$data = new Spreadsheet_Excel_Reader();

			$data->setOutputEncoding('CP1251');
			
			$data->read('Inventory.xls');


			for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {   // numRows is an excel_reader() value. 
				for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {     //numBols is an excel_reader() value. 
					echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
				}
				echo "<br/>";

			}
			
			
			echo "<br/>
				  <table>
				 ";
				 
				 
			$x=1;
			while($x<=$data->sheets[0]['numRows']) {
			  echo "\t<tr>\n";
			  $y=1;
			  while($y<=$data->sheets[0]['numCols']) {
				$cell = isset($data->sheets[0]['cells'][$x][$y]) ? $data->sheets[0]['cells'][$x][$y] : '';
				echo "\t\t<td>$cell</td>\n";  
				$y++; 
			  }  
			  echo "\t</tr>\n";  
			  $x++; 
			}

			
			echo "
					</table>";*/
				 
	
			
		/*
			$guest = new DatabaseObject_Guest($this->db);
			$guest->loadById(11);
			$guest->sendEmail('order-notice.tpl', 11, '413dd9571b00f1b311af079afd8305fd');
			
			$user = new DatabaseObject_User($this->db);
			$user->loadByUserId(1); 
			$user->sendEmail('order-notice.tpl', 11, '413dd9571b00f1b311af079afd8305fd');*/
		
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