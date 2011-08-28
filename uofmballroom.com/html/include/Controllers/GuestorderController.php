<?php
	class GuestorderController extends CustomControllerAction
	{
	
	
		public function indexAction()
		{
		
			$request = $this->getRequest();
			
			$ID = $request->getParam('ID');
			
			if(strlen($ID)==0)
			{
				////echo "at id is 0";
				
				
					$this->_redirect('index');
				
				//redirect
			}
			
			
			$type = $request->getParam('orderType');
			
			if(strlen($type)==0)
			{
				
				////echo "at type is none";
				$this->_redirect('index');
				//redirec
			}
			
			if($type=='seller')
			{
				$this->_redirect('index');
			}
			
			
	
				$order = new DatabaseObject_Order($this->db);

			if($order->loadOrderByUrl($ID))
			{
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
					
					if($type=='buyer')
					{	
						$oppositeUser->loadByUserId($order->user_id);
						////echo "here at odertype buyer";
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
				$this->messenger->addMessage('We are sorry that your request can not be completed at this moment');

				$this->_redirect('index');
			}
			
			$this->breadcrumbs->addStep('order details');
		}
	
	
	
	
	
	
	}


?>