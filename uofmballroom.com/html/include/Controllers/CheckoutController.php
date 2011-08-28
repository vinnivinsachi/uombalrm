<?php
	/*******************************************************************************
	**This class requires alot of work!!! with a real server
	*******************************************************************************/

	class CheckoutController extends CustomControllerAction
	{
		
		protected $user;
		public $productProfile=array();
		protected $totalAmount;
		//protected $cart_profile;
	
		public function preDispatch()
		{	
			
			//$this->shoppingCart = new DatabaseObject_ShoppingCart($this->db);
			//$this->cartID= $this->shoppingCart->getCartID();
			parent::preDispatch();
			$_SESSION['categoryType'] = 'product';
			//echo $_SESSION['categoryType'];
			
			if($this->cartObject>0)
			{
				if($this->shoppingCart->loadCartOnly($this->checkoutCartID))
				{
					if($this->shoppingCart->promotion_code == "")
					{
					
						$this->shoppingCart->total_after_p = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
						$this->shoppingCart->total_before_p = $this->shoppingCart->total_after_p;
						
					}
				
					if(isset($_SESSION['guest']) && ($_SESSION['guest']==$this->checkoutCartID) && isset($_SESSION['guestSignIn']))
					{
							$this->shoppingCart->buyer_id = $_SESSION['guestSignIn']+30000000;
							$this->shoppingCart->save();
					}
					elseif($this->auth->hasIdentity())
					{
						$this->signedInUser=Zend_Auth::getInstance()->getIdentity();
						$this->shoppingCart->buyer_id = $this->signedInUser->userID;
						$this->shoppingCart->save();
					}
	
					
				}
				else
				{
					$this->messenger->addMessage('You must be signed in inorder to proceed with this checkout!');
					$this->_redirect('index');
				}			
				
				if(isset($_SESSION['shoppingClubID']))
				{
				
					$this->user = new DatabaseObject_User($this->db);  
				
					if(!$this->user->loadByUserId($_SESSION['shoppingClubID']))  //this make sure that the user exist
					{
						continue;
					}
					
					$this->view->club = $this->user;
				}
				elseif(isset($_SESSION['tempShoppingClubID']) && !isset($_SESSION['shoppingClubID']))
				{
					
					$this->user = new DatabaseObject_User($this->db);  
				
					if(!$this->user->loadByUserId($_SESSION['tempShoppingClubID']))  //this make sure that the user exist
					{
						continue;
					}
					//$this->view->club = $this->user;
				}
				
				
				$object=$this->shoppingCart->getObjects($this->shoppingCart->getCartID());
	
				if(count($object)== 0)
				{
						return $this->_redirect($this->getCustomUrl(array('username' =>$this->user->username, 'action'=>'index'), 'clubproduct'));
				}
				else
				{
					$this->shoppingCartItem=$object;	
					//$this->view->cartItem = $this->shoppingCartItem;
				}
				
				
				//echo "here at saving total_before_p<br/>";
				
				//echo "cart id is: ".$this->shoppingCart->getCartID()."<br/>";
				$this->shoppingCart->total_before_p = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
				
				
				$this->shoppingCart->save;
				
				//echo "shopping cart total is: ". DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());;
				
				
				
				
				$this->breadcrumbs->addStep('checkout', $this->getUrl(null, 'checkout'));
			}
			else
			{
				$this->_redirect($this->getUrl('index','index'));
			}

		}
		
		
		
		public function indexAction()
		{
		
			if($this->shoppingCart->promotion_code != "")
			{
				$event = new DatabaseObject_Event($this->db);
			
				//echo "1";

					if($event->loadByPromotionCode($this->shoppingCart->promotion_code))
					{
					//echo "<br/>2<br/>";
						$dollar = $event->profile->price;
						$percentage = $event->profile->percentage;
						
						if($dollar !="0")
						{
							//echo "<br/>3<br/>";
							//echo "dollar is: ".$dollar;
							//$this->shoppingCart->insertPromoCode($promotion_code);
							$this->shoppingCart->recalcTotal($dollar);
							
							//$this->_redirect($this->getUrl('member', 'checkout'));
							//$this->shoppingCart->recalcTotal(30);
							
							//insert code in shopping cart, 
							
							//insert total amount, 
							//insert total amount after promotion.
						}
						elseif($percentage !="0") 
						{
							//echo "here";
							//$this->shoppingCart->insertPromoCode($promotion_code);
							
							$amount = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
							$this->shoppingCart->recalcTotal($amount*$percentage/100);
							//echo $this->shoppingCart->total_after_p;
							
							//echo $amount*$percentage/100;
							//$this->_redirect($this->getUrl('member', 'checkout'));
							//insert code in shopping cart, 
							
							//insert total amount, 
							//insert total amount after promotion.
						
						}
					}
				$this->messenger->addMessage('you have a promotion for this shopping cart');
				$this->_redirect($this->getUrl('member', 'checkout'));
			}
			
			//if cart does not have an promotion, then allow this page, 
			//else, redirect to checkoutmember.
			$request= $this->getRequest();
			
			if($request->getPost('noCode'))
			{
				$this->_redirect($this->getUrl('member', 'checkout'));
			}
			
			if($request->isPost())
			{
			
			
				$promotion_code = $this->sanitize($request->getPost('promotion'));
				
				if($promotion_code=="")
				{
					$this->view->error = "Please enter a valid promotion code";
				}
				else
				{
					$event = new DatabaseObject_Event($this->db);
			
				

					if($event->loadByPromotionCode($promotion_code))
					{
					
						if($event->ts_end > time())
						{
							$dollar = $event->profile->price;
							$percentage = $event->profile->percentage;
							
							if($dollar !='0')
							{
								$this->shoppingCart->insertPromoCode($promotion_code);
								$this->shoppingCart->recalcTotal($dollar);
								
								$this->_redirect($this->getUrl('member', 'checkout'));
								//$this->shoppingCart->recalcTotal(30);
								
								//insert code in shopping cart, 
								
								//insert total amount, 
								//insert total amount after promotion.
							}
							elseif($percentage !='0') 
							{
								$this->shoppingCart->insertPromoCode($promotion_code);
								
								$amount = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
								$this->shoppingCart->recalcTotal(round($amount*$percentage/100,2));
								$this->_redirect($this->getUrl('member', 'checkout'));
								//insert code in shopping cart, 
								//insert total amount, 
								//insert total amount after promotion.
							}
						}
						else
						{
							$this->messenger->addMessage("this promotion was expired! please enter a valid promotion code");
							$this->_redirect($this->getUrl('index','checkout'));
						}
					}
					else
					{
						$this->view->error = "Please enter a valid promotion code";
					}
				}
			}
			else
			{
				//echo "you are here at no submitt";
			}
			
			//if promotion is good, then update cart and proceed to member checkout
			//if promotion is bad, say that it is a bad promotion, and back to this page. 
			//if no promotion is clicked, proceed to member check out with out update. 
			
			
	///////////////////////////////////////////////////////////////////////////////////////////		
		/*
			if($this->totalAmount==0)
			{
				return $this->_forward('createorder');
			}
			
			$query = "https://www.paypal.com/cgi-bin/websrc?cmd=_cart&upload=1&business=".$this->user->profile->paypalEmail."&invoice=".$this->cartID;
			
if(count($this->shoppingCartItem)==1)
{
	$query .= "&item_name_1=".$this->shoppingCartItem[0]['product_name'];
	
	
	$query .="&amount_1=".$this->shoppingCartItem[0]['unit_cost'];
	$query .="&quantity_1=".$this->shoppingCartItem[0]['quantity'];
}
elseif(count($this->shoppingCartItem)>1)
{

	foreach($this->shoppingCartItem as $k =>$v)
	{
	
	$query .="&item_name_".($k+1)."=".$this->shoppingCartItem[$k]['product_name'];
	$query .="&amount_".($k+1)."=".$this->shoppingCartItem[$k]['unit_cost'];
	$query .="&quantity_".($k+1)."=".$this->shoppingCartItem[$k]['quantity'];
	}
}

$query .= "&return=http://club-nex.com/ordermanager"."&cancel_return=http://club-nex.com/shoppingcart/index".
"&notify_url=http://club-nex.com/ipn";

	$this->_redirect($query);

			*/
		}
		
		
		public function guestAction()
		{
			
			//this part is not regular shopping cart sequences, becaues you have to go through account/login and either log in or guest sign there. that was taken out, so this part was added to this section. for a direct guest checkout. 
			$_SESSION['guest']=$this->shoppingCart->getCartID();
			//----------------------------------------------------------------

			
		//	echo "settion guest: ".$_SESSION['guest']."<br/>";
			//echo "guest sign in: ".$_SESSION['guestSignIn']."<br/>";
			
			//echo "this->checkoutCartID is: ".$this->checkoutCartID."<br/>";

			if(isset($_SESSION['guest']) && ($_SESSION['guest']==$this->checkoutCartID) && isset($_SESSION['guestSignIn']))
			{
				$product = $this->cartObject;
				$this->view->products = $product;
				
				//echo "count of product: ".count($product);

				foreach($product as $k => $v)
				{
					//echo $product[$k]->getId();
					$productProfile[$product[$k]->getId()] = new Profile_Cart($this->db);
					
					$productProfile[$product[$k]->getId()]->loadProduct($product[$k],$product[$k]->getId(), $this->shoppingCart->getCartID(),$product[$k]->product_type);
				}
				
				
				//this part is not regular shopping cart sequences, becaues you have to go through account/login and either log in or guest sign there. that was taken out, so this part was added to this section. for a direct guest checkout. 
				$this->shoppingCart->buyer_id = $_SESSION['guestSignIn']+30000000;
				$this->shoppingCart->save();
				//-----------------------------------------------------
				
				$this->view->productsProfile=$productProfile;
				
				return $this->_forward('checkoutfinal');
			}
			else
			{
				$this->_redirect($this->getUrl('guest','account'));
			}

		}
		
		public function memberAction()
		{
			
				
					if($this->shoppingCart->promotion_code == '')
					{
						$this->view->addPromo = 'true';
						$this->shoppingCart->total_after_p = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
						$this->shoppingCart->save();
					}
					else
					{
						$this->view->promoCode = $this->shoppingCart->promotion_code;
						$this->view->discount = $this->shoppingCart->total_after_p-$this->shoppingCart->total_before_p;
						$this->view->finalTotal = $this->shoppingCart->total_after_p;
					}
					
					$product = $this->cartObject;
					$this->view->products = $product;
					
					//echo "count of product: ".count($product);
	
					foreach($product as $k => $v)
					{
						//echo $product[$k]->getId();
						$productProfile[$product[$k]->getId()] = new Profile_Cart($this->db);
						
						$productProfile[$product[$k]->getId()]->loadProduct($product[$k]->getId(), $this->shoppingCart->getCartID());
					}
					
					$this->view->productsProfile=$productProfile;
					
					
					return;
				
				
					
		
		
		}
		
		public function checkoutfinalAction()
		{
			if(($this->auth->hasIdentity()) | (isset($_SESSION['guest']) && ($_SESSION['guest']==$this->checkoutCartID) && isset($_SESSION['guestSignIn'])))
			{
			
				if($this->cartObject>0)
				{
				
					/*$query = "https://www.sandbox.paypal.com/cgi-bin/websrc?cmd=_cart&upload=1&business=joe_1216274517_biz@umich.edu&invoice=".$this->shoppingCart->getCartID();*/
					$query = 
"https://www.paypal.com/cgi-bin/websrc?cmd=_cart&upload=1&business=ballroom-exec@umich.edu";
					
					
					
					//"&upload=1" must be put above if i decide to use shopping cart;
					
					if(count($this->shoppingCartItem)==1)
					{
						$query .= "&item_name_1=".$this->shoppingCartItem[0]['product_name'];	
			
			
						$query .="&amount_1=0";//.$this->shoppingCartItem[0]['unit_cost'];
						$query .="&quantity_1=".$this->shoppingCartItem[0]['quantity'];
					}
					elseif(count($this->shoppingCartItem)>1)
					{ 
		
						foreach($this->shoppingCartItem as $k =>$v)
						{
						
						$query .="&item_name_".($k+1)."=".$this->shoppingCartItem[$k]['product_name'];
						$query .="&amount_".($k+1)."=0";//.$this->shoppingCartItem[$k]['unit_cost'];
						$query .="&quantity_".($k+1)."=".$this->shoppingCartItem[$k]['quantity'];
						}
					}
					
					$query.="&item_name_".(count($this->shoppingCartItem)+1)."=Total Amount";
					$query.="&amount_".(count($this->shoppingCartItem)+1)."=".$this->shoppingCart->total_after_p;
					$query.="&quantity_".(count($this->shoppingCartItem)+1)."=1";
					//$query.="&shipping = 8";
		
					$query .= "&return=http://www.uofmballroom.com"."&cancel_return=http://www.uofmballroom.com/shoppingcart/index".
		"&notify_url=http://www.uofmballroom.com/ipn";  
		
					//echo "query is: ".$query;
					$this->_redirect($query);
				}
				else
				{
					$this->_redirect($this->getUrl('index','index'));
				}
			}
			else
			{
				$this->_redirect($this->getUrl('index','index'));
			}
				
		}
		
		
		
		public function testAction()
		{
			
		
		
		}
		
		
		public function confirmationAction()
		{
		
		}
		
		public function createorderAction()
		{	
		
			$invoiceID = $this->checkoutCartID;
			
			$shoppingCart = new DatabaseObject_ShoppingCart($this->db);
			//echo "here";
			if($shoppingCart->loadCartOnly($invoiceID))
			{
			
				$CartProduct = $shoppingCart->loadCart($this->db, $invoiceID);

				$order = new DatabaseObject_Order($this->db, $invoiceID, $shoppingCart->user_id);

				$order->user_id = $shoppingCart->user_id;
				
				$seller = new DatabaseObject_User($this->db);
				
				$buyer = new DatabaseObject_User($this->db);
				
				$guest = new DatabaseObject_Guest($this->db);
				
				if(($this->shoppingCart->buyer_id)>30000000)
						{
							if(($seller->loadByUserId($this->shoppingCart->user_id)) && ($guest->loadByID(($this->shoppingCart->buyer_id)-30000000)))
							{
								$email = true;
							}
							else
							{
								$email = false;
							}
						}
						else
						{
							if(($seller->loadByUserId($this->shoppingCart->user_id)) && ($buyer->loadByUserId($this->shoppingCart->buyer_id)))
							{
								$email = true;
							}
							else
							{
								$email = false;
							}
						}

				$order->buyer_id = $shoppingCart->buyer_id;
				
				$order->url = $invoiceID;

				$order->total_amount = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $invoiceID);
				$this->logger->warn("starting to do stuff 7");
				
				$order->promotion_code = $this->shoppingCart->promotion_code;
				$order->total_before_p = $this->shoppingCart->total_before_p;
				$order->total_after_p = $this->shoppingCart->total_after_p;
				
				$order->save();	
				
				$id = $order->getId();
			
			
				foreach($CartProduct as $k=>$v)
				{
				
					
					
					$orderProfile = new Profile_Order($this->db);
					
					$orderProfile->order_id =$id;
					$orderProfile->cart_key = $CartProduct[$k]->cart_key;
					$orderProfile->product_id = $CartProduct[$k]->product_id;
					$orderProfile->product_name = $CartProduct[$k]->product_name;
					$orderProfile->product_type = $CartProduct[$k]->product_type;
					$orderProfile->quantity = $CartProduct[$k]->quantity;
					$orderProfile->unit_cost = $CartProduct[$k]->unit_cost;
					$orderProfile->ts_created = $CartProduct[$k]->ts_created;
					
					$orderProfile->save();

					
					$cart_profile = new Profile_Cart($this->db);
					
					$cart_profile->loadProduct($CartProduct[$k],$CartProduct[$k]->getId(), $CartProduct[$k]->cart_key,$CartProduct[$k]->product_type);
					
					
					$profile_attribute = DatabaseObject_StaticUtility::loadCartProfileAttribute($this->db, $CartProduct[$k]->getId());
					
					//echo "number of profile_attribute is: ".count($profile_attribute);
					
					//echo DatabaseObject_StaticUtility::show_php($profile_attribute);
					
					foreach($profile_attribute as $k=>$v)
					{ 
					
						DatabaseObject_StaticUtility::insertOrderProfileAttribute($this->db, $orderProfile->getId(), $profile_attribute[$k]);
					
					}
					
				}
				
				if($email ==true)
						{
							if(($this->shoppingCart->buyer_id)>30000000)
							{
								$this->logger->info("sending email at guest before");

								$seller->sendEmail('order-notice.tpl', $guest, $invoiceID);
								$guest->sendEmail('order-notice.tpl', $guest, $invoiceID);								
								$this->logger->info("sending email at guest after");
								
							}
							else
							{
								$this->logger->info("sending email at guest before");

								$seller->sendEmail('order-notice.tpl', $buyer, $invoiceID);
								$buyer->sendEmail('order-notice.tpl', $buyer, $invoiceID);			
								$this->logger->info("sending email at buyer after");

							}
							
						}
						else
						{
						
							$this->logger->info('finished email because email was false');

						}
				
				
				
				
			}	
			
		}	
		
	}
	
	

?>