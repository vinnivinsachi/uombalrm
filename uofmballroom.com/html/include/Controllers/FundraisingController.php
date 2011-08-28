<?php
	//the alphabet link is only for testing as of now. it is not incorporated into anyother pages. 
	
	//require_once 'Zend/Controller/Action.php'; 
	
	class FundraisingController extends CustomControllerAction
	{
	
		protected $university;
	
		public function preDispatch()
		{
			parent::preDispatch();	
			$_SESSION['categoryType'] = 'shoutout';
		}
	
	
		public function indexAction()
		{
		
			
			
		}
		
		public function lessonsAction()
		{
		
		
		}
		
		public function apparelAction()
		{
		
		
		}
		
		
		
		
		
		public function advertiseAction()
		{
		
		
		}
		
		public function donateAction()
		{
			$request=$this->getRequest();
			
			$fp = new FormProcessor_Donation($this->db);

			if($request->isPost())
			{
				if($fp->process($request))
				{
					$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

					$query .= "&item_name=University of Michigan Ballroom Dance Team Donation";	
					$query .="&amount=".$fp->totalDonateAmount;
						
					$query .= "&return=http://www.uofmballroom.com"."&cancel_return=http://www.uofmballroom.com/fundraising/donate";  
		
					//echo "query is: ".$query;
					$this->_redirect($query);
					
				}
			}
			
			$this->view->fp = $fp;

		}
		
		public function contactAction()
		{
		
		
		}
		
		public function shoutoutAction()
		{
			
			$request=$this->getRequest();
			
			$fp = new FormProcessor_ShoutOut($this->db);

			if($request->isPost())
			{
				if($fp->process($request))
				{
					
					if($fp->type=='oneline')
					{
						$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

					$query .= "&item_name=Shout Out one line";	
					$query .="&amount=20";
						
					$query .= "&return=http://www.uofmballroom.com/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout%20Out";  
		
					//echo "query is: ".$query;
					$this->_redirect($query);
					}elseif($fp->type=='quarterPage'){
						echo "proceed to quarerPage and upload Image<br />";
						
						$this->_redirect('/fundraising/image?id='.$fp->shoutout->getId());
						
					}elseif($fp->type=='halfPage'){
						echo "proceed to halfPage<br />";
						$this->_redirect('/fundraising/image?id='.$fp->shoutout->getId());	
					}
					
					echo "you submission is good";
					/*$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

					$query .= "&item_name=University of Michigan Ballroom Dance Team Donation";	
					$query .="&amount=".$fp->totalDonateAmount;
						
					$query .= "&return=http://www.uofmballroom.com"."&cancel_return=http://www.uofmballroom.com/fundraising/donate";  */
		
					//echo "query is: ".$query;
					//$this->_redirect($query);
					
				}
			}
			
			$this->view->fp = $fp;
			
		}
		
		public function errorAction(){
		
		}
		
		public function imageAction()
		{
			$request= $this->getRequest();
			$json = array();

			$shoutout_id=(int)$request->getParam('id');
		
			$shoutout = new DatabaseObject_ShoutOut($this->db);
			if($shoutout->loadByID($shoutout_id))
			{
				//echo "shoutout is true";
			}
			else{
				$this->_redirect($this->getUrl('error'));
			}
			echo "shoutout type is: ".$shoutout->type;
			echo "<br />here";
			if($request->getPost('upload'))
			{
				$fp=new FormProcessor_Image($shoutout);
				if($fp->process($request))
				{
					//echo "image uploaded. redirecting back to image action";
					if($shoutout->type=='quarterPage'){
						$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

					$query .= "&item_name=Shout Out quarter page";	
					$query .="&amount=50";
						
					$query .= "&return=http://www.uofmballroom.com/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout%20Out";  
		
					//echo "query is: ".$query;
					$this->_redirect($query);
					}elseif($shoutout->type=='halfPage'){
						$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

						$query .= "&item_name=Shout Out half page";	
						$query .="&amount=100";
							
						$query .= "&return=http://www.uofmballroom.com/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout%20Out";  
			
						//echo "query is: ".$query;
						$this->_redirect($query);
						
					}
					
					
					
					//$this->messenger->addMessage('Image uploaded');
				}
				else
				{
					foreach($fp->getErrors() as $error)
					{
						$this->messenger->addMessage($error);
					}
				}
				
			}
			elseif($request->getPost('forceProceed')){
						if($shoutout->type=='quarterPage'){
						$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

					$query .= "&item_name=Shout Out quarter page";	
					$query .="&amount=50";
						
					$query .= "&return=http://www.uofmballroom.com/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout%20Out";  
		
					//echo "query is: ".$query;
					$this->_redirect($query);
					}elseif($shoutout->type=='halfPage'){
						$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&add=1upload=1&business=ballroom-exec@umich.edu";

						$query .= "&item_name=Shout Out half page";	
						$query .="&amount=100";
							
						$query .= "&return=http://www.uofmballroom.com/clubpost/uofmballroom/cat?category=Umichcompetition&tags=Shout%20Out";  
			
						//echo "query is: ".$query;
						$this->_redirect($query);
						
					}			 
									 
			}
			elseif($request->getPost('reorder'))
			{
				$order = $request->getPost('post_images');
				$shoutout->setImageOrder($order);
			}
			elseif($request->getPost('delete'))
			{
				$image_id = (int) $request->getPost('image');
				
				
				$image = new DatabaseObject_Image($this->db);
				
				if($image->loadForPost($shoutout->getId(), $image_id))
				{
					$image->delete(); //the files are unlinked/deleted at preDelete.
					////echo "image at delete";
					
					if($request->isXmlHttpRequest())
					{
						$json = array('deleted' =>true, 'image_id' =>$image_id);
					}
					else
					{
						$this->messenger->addMessage('Image deleted');
					}
				}
			}
			
			
			if($request->isXmlHttpRequest())
			{
				$this->sendJson($json);
			}
			else
			{
				$this->view->post= $shoutout;
				//echo "proceed to check out";
			//$url = $this->getUrl('image').'?id='.$shoutout->getId();
			//$this->_redirect($url);
			}
			
		}
		
		
			
		public function testAction()
		{
			//$this->_helper->viewRenderer->setNoRender()
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