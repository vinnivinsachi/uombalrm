<?php
		class ShoppingcartController extends CustomControllerAction
		{
			protected $user;
			
			
			/*
			public function testAction()
			{
				$cart = new DatabaseObject_ShoppingCart($this->db);
				
				
				if($cart->loadCartOnly($cart->getCartID()))
				{
				
				$event = new DatabaseObject_Event($this->db);
				
				$event->eventTestLoad(11);
				$cart->addProduct($event, $cart->getCartID(), 'event');
				
				
				$event->eventTestLoad(13);
				$cart->addProduct($event, $cart->getCartID(), 'event');
				
				
				$event->eventTestLoad(8);
				//
				$cart->addProduct($event, $cart->getCartID(), 'event');
				
				$product = DatabaseObject_ShoppingCart::loadCart($this->db, $cart->getCartID());
				
				//echo "number of products in the cart: ".count($product);
				
				//echo "<br/>==========delete=========";
				//$cart->deleteProduct($event, $cart->getId(), 'event');
				
				//$cart->deleteShoppingCart($cart->getId());
				
				
				}
				else
				{
					$cart->user_id = 25;
					$cart->buyer_id = 32;
					$cart->save();
					
					$event = new DatabaseObject_Event($this->db);
				
					$event->eventTestLoad(8);
				
					$cart->addProduct($event, $cart->getId(), 'event');
				}
			
			}
			*/
		
			public function preDispatch()
			{
			
			/*	if (!isset($_SERVER['HTTPS']) && !$_SERVER['HTTPS']) 
			   {
					$request    = $this->getRequest();
					$url        = 'https://'
								. $_SERVER['HTTP_HOST']
								. $request->getRequestUri(); 
								
					$this->_redirect($url);
				}*/
				parent::preDispatch();
				
				////echo "<br/>shppingClubID: ".$_SESSION['shoppingClubID'];
				////echo "<br/>tempShoppingClubID: ".$_SESSION['tempShoppingClubID'];
				////echo "<br/>cart ID: ".$this->cartID;
				
			

				if(isset($_SESSION['shoppingClubID']))
				{
				
					$this->user = new DatabaseObject_User($this->db);  
					
					if(!$this->user->loadByUserId($_SESSION['shoppingClubID']))  //this make sure that the user exist
					{
						//continue;
					}
					
					$this->view->club = $this->user;
				}
				elseif(isset($_SESSION['tempShoppingClubID']) && !isset($_SESSION['shoppingClubID']))
				{
					
					$this->user = new DatabaseObject_User($this->db);  
				
					if(!$this->user->loadByUserId($_SESSION['tempShoppingClubID']))  //this make sure that the user exist
					{
						//continue;
					}
					//$this->view->club = $this->user;
				}
				
				
				$this->breadcrumbs->addStep('Shopping Cart Review', $this->getUrl('shoppingcart'));
				

				
			
			}
			
			public function indexAction()
			{
				
				$product = $this->cartObject;
				$this->view->products = $product;
				
				//echo "count of product: ".count($product);
				
				
				$productProfile=Array();
				foreach($product as $k => $v)
				{
					echo $product[$k]->getId();
					$productProfile[$product[$k]->getId()] = new Profile_Cart($this->db);
					
					$productProfile[$product[$k]->getId()]->loadProduct($product[$k],$product[$k]->getId(), $this->shoppingCart->getCartID(),$product[$k]->product_type);
				}
				//foreach($product['profile_id'] as $k=>$v)
				//{
					
					
					//echo "productProfile: ".$productProfile[
				//}
				$this->view->productsProfile=$productProfile;
				return;
						
			}
			
			public function deleteproductAction()
			{

				$request=$this->getRequest();
				
				$username = $request->getParam('username');
				
				
				$productID = $request->getQuery('productID');
				$profileID = $request->getQuery('cart_profileID');
				
				$cartID = $request->getQuery('cartID');
				
				$productType = $request->getParam('producttype');
				
				if($productType == 'product')
				{
					$databaseColumn='product_id';
					$type = 'product';
				}
				elseif($productType =='event')
				{
					$databaseColumn = 'event_id';
					$type = 'event';
				}
				elseif($productType =='due')
				{
					$databaseColumn='universal_dues_id';
					$type = 'due';
				}
				elseif($productType =='individualDue')
				{
					$databaseColumn='individual_dues_key';
					$type = 'individualDue';
				}
				
				
				$product=DatabaseObject_StaticUtility::verifiyShoppingInput($this->db, $username, $productID, $databaseColumn, $type);
				
				if($product)
				{
					//echo "at verify data";
					if(!$this->shoppingCart->deleteProduct($product, $profileID, $cartID, $type))
					{
						$this->messenger->addMessage('could not delete product');
						return $this->_redirect($this->getUrl('index', 'shoppingcart'));
					}
					else
					{
						$this->messenger->addMessage('Product deleted');
						return $this->_redirect($this->getUrl('index', 'shoppingcart'));
					}
				}
				else
				{
					$this->messenger->addMessage('You can NOT add products from more than ONE club.');

					$this->_redirect($this->getUrl('index', 'shoppingcart'));
				}
			}
			
			
			public function addproductAction()
			{
				$cart = new DatabaseObject_ShoppingCart($this->db);
				
				
				
			
				$request=$this->getRequest();
				
				$username = $request->getParam('username');
				
				
				$productID = $request->getQuery('productID');
				
				$cartID = $request->getQuery('cartID');
				
				$productType = $request->getParam('producttype');
				
				if($productType == 'product')
				{
					$databaseColumn='product_id';
					$type = 'product';
				}
				elseif($productType =='event')
				{
					$databaseColumn='event_id';
					$type = 'event';
				}
				elseif($productType =='due')
				{
					$databaseColumn='universal_dues_id';
					$type = 'due';
				}
				elseif($productType =='individualDue')
				{
					$databaseColumn='individual_dues_key';
					$type = 'individualDue';
				}
				
				$product=DatabaseObject_StaticUtility::verifiyShoppingInput($this->db, $username, $productID, $databaseColumn, $productType);
				
				//MAKE SURE YOU CHECK THE CART ID IS THE CURRENT CARTID!! OR ELSE!=================================
				
				if($product)
				{
					echo "at near redirect: product id: ".$product->user_id;
					
					if(!$this->shoppingCart->loadCartOnly($this->shoppingCart->getCartID()))
					{	
						
						if($productType =='individualDue')
						{
						$this->shoppingCart->user_id = $product->clubAdmin_id;
						}
						else
						{
						$this->shoppingCart->user_id = $product->user_id;
						}

						$this->shoppingCart->save();
					} 
					
					
					if($this->shoppingCart->addProduct($product, $cartID, $type,$request->getQuery()))
					{
						return $this->_redirect($this->getUrl('guest', 'account'));
						//return $this->_redirect($this->getUrl('index', 'shoppingcart')); 
					}
					else
					{
						$this->view->error = "you may not purchase products from more than ONE club at a time. Sorry for the inconvinience";
						
						echo "at not redirecting";
						return;
					}
				}
				else
				{
					$this->messenger->addMessage('You can NOT add products from more than ONE club.');

					$this->_redirect($this->getUrl('index', 'shoppingcart'));
				}
					
			}
			
			public function emptycartAction() //this is from within the shopping cart. must pass in a cartID, is capable of deleting other shopping cart if the cart id is correct. 
			{
				$request= $this->getRequest();
				$cartID =$request->getQuery('cartID');
				
				$this->shoppingCart->deleteShoppingCart($cartID);
				
				return $this->_redirect($this->getCustomUrl(array('username' =>$this->user->username, 'action'=>'index'), 'clubproduct'));
			}
			
			/*
			public function editAction()
			{
			
			}
			
			public function emptycartAction() //this is from within the shopping cart. must pass in a cartID, is capable of deleting other shopping cart if the cart id is correct. 
			{
				$request= $this->getRequest();
				$cartID =$request->getQuery('cartID');
				
				$this->shoppingCart->deleteShoppingCart($cartID);
				
				return $this->_redirect($this->getCustomUrl(array('username' =>$this->user->username, 'action'=>'index'), 'clubproduct'));
			}
			
			public function addproductAction()
			{

				$request=$this->getRequest();
				
				$username = $request->getParam('username');
				
				
				$productID = $request->getQuery('productID');
				
				$cartID = $request->getQuery('cartID');
				
				$productType = $request->getParam('producttype');
				
				if($productType == 'product')
				{
					$databaseColumn='product_id';
					$type = 'product';
				}
				elseif($productType =='event')
				{
					$databaseColumn='event_id';
					$type = 'event';
				}
				elseif($productType =='due')
				{
					$databaseColumn='universal_dues_id';
					$type = 'due';
				}
				elseif($productType =='individualDue')
				{
					$databaseColumn='individual_dues_key';
					$type = 'individualDue';
				}
				
				$product=DatabaseObject_StaticUtility::verifiyShoppingInput($this->db, $username, $productID, $databaseColumn, $productType);
				if($product)
				{
					if($this->shoppingCart->addProduct($product, $cartID, $type))
					{
						return $this->_redirect($this->getUrl('index', 'shoppingcart'));
					}
					elseif(!$this->shoppingCart->addProduct($product, $cartID, $type))
					{
						$this->view->error = "you may not purchase products from more than ONE club at a time. Sorry for the inconvinience";
						return;
					}
				}
				else
				{
					return $this->_redirect($this->getUrl('index', 'shoppingcart'));
				}
					
			}
			
			public function deleteproductAction()
			{

				$request=$this->getRequest();
				
				$username = $request->getParam('username');
				
				
				$productID = $request->getQuery('productID');
				
				$cartID = $request->getQuery('cartID');
				
				$productType = $request->getParam('producttype');
				
				if($productType == 'product')
				{
					$databaseColumn='product_id';
					$type = 'product';
				}
				elseif($productType =='event')
				{
					$databaseColumn = 'event_id';
					$type = 'event';
				}
				elseif($productType =='due')
				{
					$databaseColumn='universal_dues_id';
					$type = 'due';
				}
				elseif($productType =='individualDue')
				{
					$databaseColumn='individual_dues_key';
					$type = 'individualDue';
				}
				
				
				$product=DatabaseObject_StaticUtility::verifiyShoppingInput($this->db, $username, $productID, $databaseColumn, $type);
				if($product)
				{
					//echo "at verify data";
					$this->shoppingCart->deleteProduct($product, $cartID, $type);
					//return $this->_redirect($this->getUrl('index', 'shoppingcart'));
				}
				else
				{
					//echo "at not verified data";
					//return $this->_redirect($this->getUrl('index', 'shoppingcart'));
				}
			}
			
			
			
			public function updatecartAction()
			{
				////echo $this->shoppingCart->getCartID();

				$request=$this->getRequest();
				
				$username = $request->getParam('username');
				
				////echo "username: ".$username;
				
				$productID = $request->getQuery('productID');
				
				$quantity = (int) $request->getQuery('quantity');
				
				if(empty($quantity))
				{
					$deleteproduct = true;
				}
				else
				{
					$deleteproduct = false;
				}
				
				$cartID = $request->getQuery('cartID');
				
				if(empty($cartID))
				{
					////echo "<br/>you do not have enough update informatoin. cartError.";
					return;
				}
				
				$productType = $request->getParam('producttype');
				
				
				if($productType == 'product')
				{
					$databaseColumn='product_id';
					$type='product';
				}
				else
				{
					////echo "<br/>your adress is invalid. please go back and resubmit your data.";
					return;
				}
				
				
				$product=DatabaseObject_StaticUtility::verifiyShoppingInput($this->db, $username, $productID, $databaseColumn);
				if($product && $deleteproduct == false)
				{
					$this->shoppingCart->updateCart($product, $cartID, $type, $quantity);

				}
				elseif($product && $deleteproduct ==true)
				{
					$this->shoppingCart->deleteProduct($product, $cartID, $type);
				}
				else
				{
					////echo "<br/>you are unable to update";
					return;
				}
			
			}
			
			*/
		}
?>