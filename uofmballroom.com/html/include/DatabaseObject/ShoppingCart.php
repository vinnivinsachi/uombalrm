<?php

	class DatabaseObject_ShoppingCart extends DatabaseObject
	{
	
		private static $cartID;
		//private static $clubID=NULL;
		public $totalCost=0;
		public $cartItems;
		
		
		public function __construct($db)
		{
			$this->setCartID();
			parent::__construct($db, 'shopping_cart', 'cart_id');
					
			$this->add('user_id');
			$this->add('buyer_id',0);
			$this->add('url', $this->getCartID());
			$this->add('ts_created', time(), self::TYPE_TIMESTAMP);
			$this->add('item_number', '0');
			$this->add('promotion_code');
			$this->add('total_before_p');
			$this->add('total_after_p');
			$this->add('status', 'pending');
			
		
			
		}
		
		
		protected function preInsert()
		{
			$this->url = self::$cartID;
			return true;
		}
	
		
	
		public static function setCartID()
		{
			if(self::$cartID == "")
			{
				
				if(isset($_SESSION['cartID']))
				{
					
					self::$cartID = $_SESSION['cartID'];
				}
				elseif(isset($_COOKIE['cartID']))
				{
					
					self::$cartID = $_COOKIE['cartID'];
					$_SESSION['cartID'] = $_COOKIE['cartID'];
				}
				else
				{
					self::$cartID = md5(uniqid(rand(), true));
					
					$_SESSION['cartID'] = self::$cartID;
				}
			}
			
		}
	
	
		public function getCartID()
		{
			return self::$cartID;
		}
		
		
		
		
		
		public function loadCartOnly($cartID)
		{
			$select = $this->_db->select();
			
			$select->from('shopping_cart')
				   ->where('url = ?', $cartID);
				   
			//echo $select;
		
			return $this->_load($select);
		}
		
		
		public function addProduct(DatabaseObject $object, $cartID, $object_type,$request)
		{
		if($cartID != $this->getCartID())
			{
				return true;
			}
			
		
		
			$cart_profile = new Profile_Cart($this->_db);
			
			/*if($cart_profile->loadProduct($object, $cartID, $object_type))
			{
				$cart_profile->quantity = $cart_profile->quantity+1;
				return $cart_profile->save();
			}
			else
			{*/
				if(isset($_SESSION['shoppingClubID']) && $_SESSION['shoppingClubID'] == $this->user_id)
				{
			
					$cart_profile->cart_id = $this->getId();
					$cart_profile->cart_key = $cartID;
					$cart_profile->product_id = $object->getId();
					$cart_profile->product_type = $object_type;
					$cart_profile->quantity = 1;
					$cart_profile->unit_cost = $object->profile->price;
					$cart_profile->product_name = $object->profile->name;
					//$cart_profile->attribute_type= $object->profile->type;
					
					//echo "here at productAttribute";
					foreach($request as $k => $v)
					{
						$cart_profile->ProductAttribute->$k = $request[$k];
						
						echo "here at add product attribute!";
						if($k =='inv_id')
						{
							$invprofileQuantity = new DatabaseObject_Invprofile($this->_db);
							$invprofileQuantity->loadItem($request['inv_id']);
							if($invprofileQuantity->quantity >0)
							{
							
							//echo "attribute: ".$invprofileQuantity->quantity."<br/>";
							$inventoryHolder = new DatabaseObject_InventoryHolder($this->_db);
							$inventoryHolder->addToInventoryHolder($cartID, $request[$k], 1);
							}
							else
							{
							//echo "attribute: ".$invprofileQuantity->quantity."<br/>";

							return false;
							}
						}
					}
					
					$cart_profile->save();
					
					$this->item_number = $this->item_number+1;
					$this->save();
					return true;
				}	
				else if(!isset($_SESSION['shoppingClubID']))
				{
					$cart_profile->cart_id = $this->getId();
					$cart_profile->cart_key = $cartID;
					$cart_profile->product_id = $object->getId();
					$cart_profile->product_type = $object_type;
					$cart_profile->quantity = 1;
					$cart_profile->unit_cost = $object->profile->price;
					$cart_profile->product_name = $object->profile->name;
					$cart_profile->attribute_type= $object->profile->type;

					
					//echo "here at productAttribute";
					foreach($request as $k => $v)
					{
						$cart_profile->ProductAttribute->$k = $request[$k];
						
						if($k =='inv_id')
						{
							$invprofileQuantity = new DatabaseObject_Invprofile($this->_db);
							$invprofileQuantity->loadItem($request['inv_id']);
							if($invprofileQuantity->quantity >0)
							{
							//echo "attribute: ".$invprofileQuantity->quantity."<br/>";

							$inventoryHolder = new DatabaseObject_InventoryHolder($this->_db);
							$inventoryHolder->addToInventoryHolder($cartID, $request[$k], 1);
							}
							else
							{
							//echo "attribute: ".$invprofileQuantity->quantity."<br/>";

								return false;
							}
						}
					}
					
					$cart_profile->save();
					
					$this->item_number = $this->item_number+1;
					$this->save();
					
					$_SESSION['shoppingClubID'] = $this->user_id;
					$_SESSION['tempShoppingClubID'] = $this->user_id;
					return true;
				}
				
					
					
					
			//}
		
		/*	if($cartID != $this->getCartID())
			{
				return true;
			}
			
		
		
			$cart_profile = new Profile_Cart($this->_db);
			
			if($cart_profile->loadProduct($object, $cartID, $object_type))
			{
				$cart_profile->quantity = $cart_profile->quantity+1;
				return $cart_profile->save();
			}
			else
			{
			
				if(isset($_SESSION['shoppingClubID']) && $_SESSION['shoppingClubID'] == $this->user_id)
				{
			
					$cart_profile->cart_id = $this->getId();
					$cart_profile->cart_key = $cartID;
					$cart_profile->product_id = $object->getId();
					$cart_profile->product_type = $object_type;
					$cart_profile->quantity = 1;
					$cart_profile->unit_cost = $object->profile->price;
					$cart_profile->product_name = $object->profile->name;
					$cart_profile->save();
					
					$this->item_number = $this->item_number+1;
					$this->save();
					return true;
				}	
				else if(!isset($_SESSION['shoppingClubID']))
				{
					$cart_profile->cart_id = $this->getId();
					$cart_profile->cart_key = $cartID;
					$cart_profile->product_id = $object->getId();
					$cart_profile->product_type = $object_type;
					$cart_profile->quantity = 1;
					$cart_profile->unit_cost = $object->profile->price;
					$cart_profile->product_name = $object->profile->name;
					$cart_profile->save();
					
					$this->item_number = $this->item_number+1;
					$this->save();
					
					$_SESSION['shoppingClubID'] = $this->user_id;
					$_SESSION['tempShoppingClubID'] = $this->user_id;
					return true;
				}
				
					
					
					
			}*/
		}
		
		public function deleteProduct(DatabaseObject $object, $profileID, $cartID, $object_type)
		{
			if($cartID != $this->getCartID())
			{
				return false;
			}
			
			
			$cart_profile = new Profile_Cart($this->_db);
			
			if($cart_profile->loadProduct($object, $profileID, $cartID, $object_type))
			{
				
				
				echo "<br/>cart count is: ".count($cart_profile);
				
				echo "<br/>cart product_id: ".$cart_profile->product_id;
				echo "<br/>cart stuff: ".$cart_profile->cart_id;
				$cart_profile->delete();
				$this->item_number = $this->item_number-1;
				$this->save();
				return true;
			}
			else
			{
				return false;
			}
			
			if($this->item_number == 0)
			{
				$this->delete();
				unset($_SESSION['shoppingClubID']);
			
				unset($_SESSION['cartID']);
				setcookie('cartID', "", time() - 4320000);		
				unset($_COOKIE['cartID']);		
				self::$cartID="";
			
				echo "you are at unsetting the shopping cart";
				return true;
			}
		}
		
		public static function loadCart($db, $cartKey)
		{
			$select = $db->select();
			
			$select->from('shopping_cart_profile', '*')
				   ->where('cart_key = ?', $cartKey);
				   
			$data = $db->fetchAll($select);
			
			$products = self::BuildMultiple($db, 'Profile_Cart' ,$data); 
			
			return $products;
		
		}
		
		
		
		/*
		
		public function updateCart(DatabaseObject $object, $cartID, $object_type, $quantity)
		{
		
			if($cartID != $this->getCartID())
			{
				echo "<br/>Your cartID is not correct with the current shopping cart ID.";
				return;
			}
			
			$select = $this->_db->select();
			
			$productID = $object->getId();
			
			$club_id = $object->user_id;
			
			$select->from('shopping_cart', '*')
				   ->where('cart_key =?', $cartID)
				   ->where('product_id =?', $productID)
				   ->where('product_type = ?', $object_type)
				   ->where('club_id =?', $club_id);
				   
			//echo "<br/> your select query is: ".$select;
			
			
			$result = $this->_db->fetchAll($select);		
			
			if(count($result)==1)
			{
				$where[] = "cart_key = '".$cartID."'";
				$where[] = "product_id = '".$productID."'";
				$where[] = "product_type = '".$object_type."'";
				$where[] = "club_id = '".$club_id."'";
				$this->_db->update('shopping_cart', array('quantity' => $quantity), $where);
			}
			else
			{
				echo "you have an error in your request. Error253.";
				return;
			}
		}
		
		
		
		/*****************************************************************************
		**THIS GETS THE SHOPPING CART INFORMATION
		**THIS RETURN THE TOTAL AMOUNT OF THE SHOPPING CART
		*****************************************************************************/
		
		public static function getTotalAmount($db, $cartID)
		{
		
			
			$select = $db->select();
			
			$select->from('shopping_cart_profile as s', 'sum(s.unit_cost*s.quantity) as total_amount')
			       ->where('cart_key = ?', $cartID);
			
			//echo "your select query is: ".$select;
			$result = $db->fetchAll($select);
			
			
			return $result[0]['total_amount'];
	
		}
		
		public function getObjects($cartID)
		{
			/*
			$stmt = $db->query('SELECT bug_id, bug_description, bug_status FROM bugs');

			$obj = $stmt->fetchObject();
			
			echo $obj->bug_description;
			*/
			
			
			$select = $this->_db->select();
			$select->from('shopping_cart_profile as s', '*')
				   ->where('cart_key =?', $cartID);
			
			//echo $select;
			
			$statement = $this->_db->query($select);
			
			$obj = $statement->fetchAll();
			
			//echo "<br/>count of obj: ".count($obj);

			return $obj;
			
		}
		
		public function deleteShoppingCart($cartID)
		{
			//echo $cartID;
			$this->_db->delete('shopping_cart_profile', "cart_key = '".$cartID."'");
			$this->_db->delete('shopping_cart', "url='".$cartID."'");
			unset($_SESSION['shoppingClubID']);
			
			unset($_SESSION['cartID']);
			setcookie('cartID', "", time() - 4320000);		
			unset($_COOKIE['cartID']);		
			self::$cartID="";
			
			//echo "you are at unsetting the shopping cart";
			return;
		
		}
		
		
		
		
		
		
		
		
		
	}
	
?>