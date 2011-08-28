<?php 

	class OrdermanagerController extends CustomControllerAction
	{
		protected $clubUser;
		protected $memberUser;
		protected $username;
		protected $secondMember; // the second username that is on the url
		protected $club;
		protected $orderType;
		
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('order manager', $this->getUrl(null, 'ordermanager'));
			$this->clubUser=Zend_Auth::getInstance()->getIdentity();
			
			if($this->clubUser->user_type =='member')
			{
				$this->orderType = 'buyer';
				$this->view->orderType = 'buyer';
			}
			elseif($this->clubUser->user_type =='clubAdmin')
			{
				$this->orderType = 'seller';
				$this->view->orderType = 'seller';
			}
			
			//$this->view->signedInUser = $this->clubUser;
			//$_SESSION['categoryType'] = 'universalDueImage';
			
			$affiliation= new DatabaseObject_Affiliation($this->db);
			$request = $this->getRequest();
			
			$this->username = trim($request->getUserParam('username'));
			
			
			$_SESSION['clubUsername'] = $this->username;
			
			$this->club = new DatabaseObject_User($this->db);
			
			if($this->club->loadByUsername($this->username, 'clubAdmin', 'L'))  //check to see if request is related with clubuser
			{
				$this->secondMember=$this->club;
				if(isset($this->clubUser->userID)&& $this->clubUser->user_type == 'member')
				{
					////echo "your user_type is: ".$auth->getIdentity()->user_type;
					

					if($affiliation->checkAffiliation($this->clubUser->userID, $this->club->getId()))
					{
						$this->view->requestAffilButtonActive = true;
						//$this->affiliated = true;
					}
					else
					{
						
						$this->view->requestAffilButtonActive = false;
						//$this->affiliated = true;
					}
					
				}
				elseif(isset($this->clubUser->userID)&& $this->clubUser->user_type == 'clubAdmin')
				{
				
					
					$this->view->requestAffilButtonActive = true;
				}
				else
				{
					////echo "your user_type3 is: ".$auth->getIdentity()->user_type;
					$this->affiliated = true;
					$this->view->requestAffilButtonActive = false;
				}
			}
			elseif($this->club->loadByUsername($this->username, 'member', 'L'))//check to see if request is related with member
			{
				$this->secondMember=$this->club;
				if($affiliation->checkAffiliation( $this->club->getId(), $this->clubUser->userID)) //member is not the club(memberuser), and club is now the logged in clubAdmin.
				{
					////echo "you are at here: with true affiliated.";
					$this->affiliated = true;
					//$this->affiliated = true;
				}
				else
				{
					////echo "you are at here: with false affiliated.";
					$this->affiliated = false;
					//$this->affiliated = true;
				}
				$this->view->requestAffilButtonActive = true;
			}

		}
		
		public function indexAction()
		{
			
			foreach($this->alphabetLink as $k=>$v)
			{
			
				$this->alphabetLink[$k] =$this->getUrl('index', 'ordermanager').'?alphabetLink='.$k;
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			$pageNumber = $this->getRequest()->getQuery('limitPage');
			
			if($pageNumber==0)
			{
				$pageNumber=1;
				$options = array(
							'alphabetLink'  => $alphabet,
							'limitTotal'    => 1
							);
				$this->view->currentPage = 1;
			}
			else
			{
				$options = array( 'alphabetLink'  => $alphabet,
							'limitTotal'    => $pageNumber
							);
				$this->view->currentPage = $pageNumber;

			}
			
			$order = new DatabaseObject_Order($this->db);
			
			$objects = $order->loadOrders($this->clubUser->userID, $this->orderType, $options);	
			
					
			$this->currentTotalPage = ceil(count($objects)/50)+$pageNumber;
			
			$this->view->currentTotalPage = $this->currentTotalPage;
			
			$this->view->currentPage = 1;
			
			if(strlen($pageNumber)==0)
			{
			
				$options = array(
							'alphabetLink'  => $alphabet,
							'limit' =>1
							);
							
			$objects = $order->loadOrders($this->clubUser->userID, $this->orderType, $options);	
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array(
							 'limit'=>$pageNumber,
							 'alphabetLink'  => $alphabet
							);
							
			$objects = $order->loadOrders($this->clubUser->userID, $this->orderType, $options);	
				$this->view->currentPage=$pageNumber;
				
			}			
				
			$this->view->orders = $objects;
			$this->view->paginationLink = $this->geturl('index','ordermanager');
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;		

		}
		
		
		public function noorderAction()
		{
		
		}
		
		public function viewAction()
		{
		
			//transfer to url system when things gets too busy. so customers can check their things
		
			$request = $this->getRequest();
			
			$ID = $request->getParam('ID');
			
			if(strlen($ID)==0)
			{
				//echo "at id is 0";
				
				
					//$this->_redirect('index');
				
				//redirect
			}
			
			
			$type = $request->getParam('orderType');
			
			if(strlen($type)==0)
			{
				
				//echo "at type is none";
				//$this->_redirect('index');
				//redirec
			}
			
			
			if($type=='seller')
			{
				$type= "user_id";
			}
			elseif($type=='buyer')
			{
				$type= "buyer_id";
			}
			
			//echo "club id is: ".$this->clubUser->userID;
			if(DatabaseObject_Order::verifyOrder($this->db, $ID, $this->clubUser->userID, $type))
			{
				//echo "here at verified order";
			
				$order = new DatabaseObject_Order($this->db);

				$order->loadOrderByUrl($ID);
				
				if($order->promotion_code == '')
				{
					$this->view->addPromo = 'true';
				}
				else
				{
					$this->view->promoCode = $order->promotion_code;
					$this->view->discount = $order->total_after_p-$order->total_before_p;
					$this->view->finalTotal = $order->total_after_p;
				}
				
				//echo "promotion code: ";
				
				
				
				$orderProfile = new Profile_Order($this->db);
			
				
				$result = $orderProfile->loadProifleByOrderID($order->getId());
				
				
				if($order->buyer_id>30000000)
				{
					
					$oppositeUser = new DatabaseObject_Guest($this->db);
					
					$oppositeUser->loadByID($order->buyer_id-30000000);
					$this->view->guest = 'true';

				}
				else
				{
					$oppositeUser = new DatabaseObject_User($this->db);
					if($this->orderType=='seller')
					{
						$oppositeUser->loadByUserId($order->buyer_id);
						echo $oppositeUser->username;
						//echo "here at ordertype seller";
					}
					elseif($this->orderType=='buyer')
					{	
						$oppositeUser->loadByUserId($order->user_id);
						//echo "here at odertype buyer";
					}
				}
				/*echo "heels are: ".$orderProfile->orderAttribute->heel;
				echo "order status: ".$order->url."<br/>";
				echo "count of order in that order: ".count($result)."<br/>";
				echo $result[0]['profile_id'];
				echo $result[0]['product_name'];*/
				
				$productProfileArray=array();
				
				foreach ($result as $k => $v)
				{
					//echo "<br/>here0<br/>";
					
					$productProfileArray[$result[$k]['profile_id']] = new Profile_Order($this->db);
					
					$productProfileArray[$result[$k]['profile_id']]->loadOrder($result[$k]['profile_id'], $order->url);
					
					
					
					//echo "<br/>heels are for profile_id: ".$result[$k]['profile_id']." and heels are: ".$productProfileArray[$result[$k]['profile_id']]->orderAttribute->heel."<br/>";
					//echo "<br/>name: ".$productProfileArray[1]->product_name;

				}
				
				
				$this->view->order=$order;				
				$this->view->oppositeUser=$oppositeUser;
				//$this->view->orderProfile=$result;
				$this->view->orderProfile=$productProfileArray;
			}
			else
			{
				//echo "here at bad order";
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				//$this->_redirect('index');
			}
			
			$this->breadcrumbs->addStep('order details');
			
		}
		
		public function verificationAction()
		{
			$request=$this->getRequest();
			
			$ID= $request->getPost('orderID');
			$action = $request->getPost('action');
			
			if(strlen($ID)>0 && strlen($action)>0 )
			{
				//echo "here";

				if($this->clubUser->user_type =='clubAdmin')
				{
					//echo "here2";

					if(DatabaseObject_Order::verifyOrder($this->db, $ID, $this->clubUser->userID, 'user_id'))
					{
						//echo "here3";
						$order = new DatabaseObject_Order($this->db);
						$order->loadOrderByUrl($ID);
						if($action =='verify')
						{
							$order->status= 'complete';
						}
						if($action =='unverify')
						{	
							$order->status= 'pending';
						}
						
						$order->save();
						
					}
				}
			}
			
			return $this->_redirect($this->geturl('index'));
		}
			
		public function productstatAction()
		{
			$request = $this->getRequest();
			
			$ID=$request->getQuery('ID');
			$type = $request->getQuery('type');			
			$productName= $request->getQuery('name');
			

			if(strlen($ID)>0 && is_numeric($ID) && strlen($type)>0 )
			{
				/* this checks the vied product statistics is in line with the club
				$product = DatabaseObject_StaticUtility::verfiyProductStat($this->db, $ID, $type, $this->clubUser->userID);
			
				if(count($product)==1)
				{  
					$this->view->product= $product;*/
					if($this->clubUser->user_type =='clubAdmin')
					{
						$orders = DatabaseObject_Order::getStatistics($this->db, $ID, $type);
					
						$this->view->orders = $orders;
					
						//echo "count of orders: ".count($orders);
					}
					
					$this->view->productName =$request->getQuery('name');
					$this->view->type=$type;
					$this->breadcrumbs->addStep('Product Preview: '.$productName);
				/*
				}
				else
				{
					$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

					$this->_redirect($this->getUrl('index'));
					//no product for this user
				}*/
			}
			else
			{
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');
				$this->_redirect($this->getUrl('index'));
				//redirect
			}
			
			
		}
		
		
		public function guesttestAction()
		{
			
			$guest = new DatabaseObject_Guest($this->db);
			
			$guests = $guest->loadall();
			
			//Zend_Debug::dump($guests);
			
			foreach($guest as $k=>$v)
			{
				echo $v->first_name."<br />";
			}
		
			$excel = new Spreadsheet_Excel_Writer('guest.xls');
			
			$sheet =& $excel->addWorksheet('Member');
			
			
			$headerLine=array('guest_id', 'first_name', 'last_name', 'email', 'address', 'phone', 'city', 'state', 'zip','car','boombox','ethnicity','hear_about_us','school','ts_created');
			
			foreach($headerLine as $k=>$v)
			{
				$sheet->write(0, $k, $v);	
			}
			
			$rowCount=1;
			foreach($guests as $k => $v)
			{
				$kCount=0;

				foreach($headerLine as $j =>$vv)
				{
					
					
					$sheet->write($rowCount, $kCount, $guests[$k]->$vv);
					echo "VV value is: ".$guests[$k]->$vv."<br />";
					//$allProductInventory[$rowCount][$kCount]=$vv;
					
					 
					$kCount++;
					//echo " $j: ".$vv;
				}
				echo "<br/>New member<br/>";
				$rowCount++;
			}
			
			if ($excel->close() === true) { 
				echo 'Spreadsheet successfully saved!';  
				$this->messenger->addMessage('You have SUCCEEDED exporting your inventory xml. FTP your inventory.xml onto your computer!');

			} else {
				$this->messenger->addMessage('You have FAILED exporting your inventory xml');

				echo 'ERROR: Could not save spreadsheet.';
			}
			
			$this->_helper->viewRenderer->setNoRender();

			header ( "Content-type: application/x-msexcel" );
			header ('Content-Disposition: attachment; filename="guest.xls"');
	
			readfile('paidMemberOnline.xls');
			
		}
		
		
		public function testAction()
		{
		
		
			foreach($this->alphabetLink as $k=>$v)
			{
			
				$this->alphabetLink[$k] =$this->getUrl('index', 'ordermanager').'?alphabetLink='.$k;
			}
			
			$alphabet = $this->getRequest()->getQuery('alphabetLink');
			
			$pageNumber = $this->getRequest()->getQuery('limitPage');
			
			if($pageNumber==0)
			{
				$pageNumber=1;
				$options = array(
							'alphabetLink'  => $alphabet,
							'limitTotal'    => 1
							);
				$this->view->currentPage = 1;
			}
			else
			{
				$options = array( 'alphabetLink'  => $alphabet,
							'limitTotal'    => $pageNumber
							);
				$this->view->currentPage = $pageNumber;

			}
			
			$order = new DatabaseObject_Order($this->db);
			
			$objects = $order->loadOrders($this->clubUser->userID, $this->orderType, $options);	
			
					
			$this->currentTotalPage = ceil(count($objects)/50)+$pageNumber;
			
			$this->view->currentTotalPage = $this->currentTotalPage;
			
			$this->view->currentPage = 1;
			
			if(strlen($pageNumber)==0)
			{
			
				$options = array(
							'alphabetLink'  => $alphabet,
							'limit' =>1
							);
							
			$objects = $order->loadOrders($this->clubUser->userID, $this->orderType, $options);	
			}
			elseif(is_numeric($pageNumber))
			{
				$options = array(
							 'limit'=>$pageNumber,
							 'alphabetLink'  => $alphabet
							);
							
			$objects = $order->loadOrders($this->clubUser->userID, $this->orderType, $options);	
				$this->view->currentPage=$pageNumber;
			}			
				
			$this->view->orders = $objects;
			$this->view->paginationLink = $this->geturl('index','ordermanager');
			$this->view->alphabetLink = $this->alphabetLink;

			$this->view->currentAlphabet = $alphabet;		
		
		
			foreach($objects as $k=>$v)
			{
				echo $v->buyer->first_name."<br />";
			}
		
			$excel = new Spreadsheet_Excel_Writer('paidMemberOnline.xls');
			
			$sheet =& $excel->addWorksheet('Member');
			
			
			$headerLine=array('first_name', 'last_name', 'email', 'address', 'phone', 'city', 'state', 'zip','car','boombox','ethnicity','hear_about_us','school','ts_created');
			
			foreach($headerLine as $k=>$v)
			{
				$sheet->write(0, $k, $v);	
			}
			
			$rowCount=1;
			foreach($objects as $k => $v)
			{
				$kCount=0;

				foreach($headerLine as $j =>$vv)
				{
					
					
					$sheet->write($rowCount, $kCount, $objects[$k]->buyer->$vv);
					echo "VV value is: ".$objects[$k]->buyer->$vv."<br />";
					//$allProductInventory[$rowCount][$kCount]=$vv;
					
					 
					$kCount++;
					//echo " $j: ".$vv;
				}
				echo "<br/>New member<br/>";
				$rowCount++;
			}
			
			if ($excel->close() === true) { 
				echo 'Spreadsheet successfully saved!';  
				$this->messenger->addMessage('You have SUCCEEDED exporting your inventory xml. FTP your inventory.xml onto your computer!');

			} else {
				$this->messenger->addMessage('You have FAILED exporting your inventory xml');

				echo 'ERROR: Could not save spreadsheet.';
			}
			
			$this->_helper->viewRenderer->setNoRender();

			header ( "Content-type: application/x-msexcel" );
			header ('Content-Disposition: attachment; filename="paidMemberOnline.xls"');
			
			readfile('paidMemberOnline.xls');
			
		}	
	}
?>