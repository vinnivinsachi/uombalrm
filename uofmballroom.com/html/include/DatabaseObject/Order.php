<?php

	class DatabaseObject_Order extends DatabaseObject
	{
	
		private static $cartID;
		//private static $clubID=NULL;
		protected $userID;
		protected $orderID;		
		public $buyer;	

		public function __construct($db)
		{
			parent::__construct($db, 'orders', 'order_id');
			
			$this->add('user_id');
			$this->add('buyer_id');
			$this->add('total_amount');
			$this->add('url');
			$this->add('ts_created', time(), self::TYPE_TIMESTAMP);
			$this->add('payment_status', 'unpaid');
			$this->add('promotion_code');
			$this->add('total_before_p');
			$this->add('total_after_p');
			$this->add('status', 'pending');
		}
		
		
		protected function preInsert()
		{
			return true;
		}
		
		protected function postDelete()
		{
			return true;
		}
		
		protected function postUpdate()
		{
			return true;
		}
		
		protected function preDelete()
		{
			
			
			return true;
		}
	
		public function getCartID()
		{
			return $this->url;
		}
		
		public function loadOrderById($ID)
		{
			$id = (int)$ID;
			
			if(strlen($ID)<=0)
			{
				//echo "your ID is invalid";
				return false;
			}
			
			$query = sprintf('select %s from %s where order_id = ?', join(', ', $this->getSelectFields()), $this->_table);
			$query = $this->_db->quoteInto($query, $ID);
			
			return $this->_load($query);
		}
		
		public function loadOrderByUrl($ID)
		{
			$id = (int)$ID;
			
			if(strlen($ID)<=0)
			{
				//echo "your ID is invalid";
				return false;
			}
			
			$query = sprintf('select %s from %s where url = ?', join(', ', $this->getSelectFields()), $this->_table);
			$query = $this->_db->quoteInto($query, $ID);
			
			return $this->_load($query);
		}
		
		
		
		
		public function loadOrders($userID, $type , $options)
		{
			$select = $this->_db->select();
			
			$select->from(array('o'=>'orders'), '*');
			
			if($type =='seller')
			{
				$select->where('o.user_id = ?', $userID);
				
				if(!empty($options['alphabetLink']) && strlen($options['alphabetLink'])>0)
				{
				$select->joinInner(array('p'=>'users'), 'o.buyer_id = p.userID');
				$select->where('p.first_name like "'.$options['alphabetLink'].'%"');
				}
				
				if(!empty($options['limit']) && is_numeric($options['limit']))
				{
					$select->limitpage($options['limit'], 500);
				}
				
				
				if(!empty($options['limitTotal']) && is_numeric($options['limitTotal']))
				{
					//echo "<br/> here at limitTotal";
						$select->limit((($options['limitTotal']+3)*500),(($options['limitTotal']*500)));	
				}
				//echo $select;
			}
			elseif($type =='buyer')
			{
				$select->where('o.buyer_id = ?', $userID);
				
				if(!empty($options['alphabetLink']) && strlen($options['alphabetLink'])>0)
				{
				$select->joinInner(array('p'=>'users'), 'o.user_id = p.userID');
				$select->where('p.first_name like "'.$options['alphabetLink'].'%"');
				}
				
				if(!empty($options['limit']) && is_numeric($options['limit']))
				{
					$select->limitpage($options['limit'], 500);
				}
				
				if(!empty($options['limitTotal']) && is_numeric($options['limitTotal']))
				{
					//echo "<br/> here at limitTotal";
						$select->limit((($options['limitTotal']+3)*500),(($options['limitTotal']*500)));	
				}
				//echo "<br/>".$select;
			}
			
			$select->order('o.ts_created desc');
			$data = $this->_db->fetchAll($select);
			
			$products = self::BuildMultiple($this->_db,__CLASS__,$data); 
			
			if(count($products)>0)
			{
					foreach($products as $k=>$v)
					{
						if($type =='seller')
						{
							if($products[$k]->buyer_id>30000000)
							{
							
								$sender[$k] = $products[$k]->buyer_id-30000000;
						//echo "<br/>at foreach loop: ".$products[$k]->buyer_id;
							}
						
						}
						elseif($type =='buyer')
						{
						$sender[$k] = $products[$k]->user_id;
						//echo "<br/>at foreach loop: ".$products[$k]->user_id;
						}
					}
				
					$select3=$this->_db->select();
					
					if($type=='seller')
					{
						$select3->from('guests', '*')
						   ->where('guest_id in (?) ', $sender);
					}
					else
					{
						
						$select3->from('users', '*')
						   ->where('userID in (?) ', $sender); 
					}
				
					//echo $select3;
					$data = $this->_db->fetchAll($select3);
			
			
					if($type='seller')
					{
					$users = DatabaseObject::BuildMultiple($this->_db, 'DatabaseObject_Guest', $data);
					}
					else
					{
					$users= DatabaseObject::BuildMultiple($this->_db, 'DatabaseObject_User', $data);
					}
					
					//echo "the count of users are: ".count($users);
					//foreach ($users as $k=>$v)
					//{
					//	echo "<br/>k for user is: ".$k;
					//}
			}
			
			$products_ids = array_keys($products);
			
			if(count($products_ids)==0)
			{
				return array();
			}
			
			foreach($products as $product_id =>$product)
			{
				if($type =='seller')
				{
					if($products[$product_id]->buyer_id>30000000)
					{
										$products[$product_id]->buyer = $users[($products[$product_id]->buyer_id-30000000)];

				//$products[$product_id]->buyer = $users[$products[$product_id]->buyer_id];
					}
				}
				elseif($type =='buyer')
				{
				$products[$product_id]->buyer = $users[$products[$product_id]->user_id];
				}

			}
			//echo "count of result at order.".count($products);
			return $products;
		}
		
		public static function verifyOrder($db, $orderID, $userID, $type)
		{
			$select= $db->select();
			
			$select->from('orders', '*')
			 	   ->where($type.' = ?', $userID)
				   ->where('url = ?', $orderID);
			
			//echo "<br />$select<br />";
			$result = $db->fetchAll($select);
			
			if(count($result)==1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public static function getStatistics($db, $productID, $type)
		{
			$select=$db->select();
			
			
			$select->from('orders_profile', 'order_id')
				   ->where('product_id = ?', $productID)
				   ->where('product_type = ?', $type)
				   ->order('ts_created desc');
			
			echo $select;
			
			$order = $db->fetchAll($select);
			
			if(count($order) >0)
			{
		
				
			
				$orderId = array();
				
				foreach($order as $k=>$v)
				{
					//echo "<br/>order id: ".$order[$k]['order_id'];
					$orderId[]=$order[$k]['order_id'];
				}
				
				
				$select2=$db->select();
				
				$select2->from('orders', '*')
					   ->where('order_id in (?)', $orderId);
					  // ->order('ts_created DESC');
					   
				//echo $select;
				
				$data = $db->fetchAll($select2);
				
				$products = self::BuildMultiple($db,__CLASS__,$data); 
				
				if(count($products)>0)
				{
						foreach($products as $k=>$v)
						{
														
							if($products[$k]->buyer_id>30000000)
							{
							
								$sender[$k] = $products[$k]->buyer_id-30000000;
						//echo "<br/>at foreach loop: ".$products[$k]->buyer_id;
							}
						}
					
						$select->from('guests', '*')
							   ->where('guest_id in (?) ', $sender);
							   
						
					
						//echo "<br/>here at select".$select."<br />";
						$data = $db->fetchAll($select);
				
						
						
						$users = DatabaseObject::BuildMultiple($db, 'DatabaseObject_Guest', $data);
						
						/*foreach ($users as $k=>$v)
						{
							echo "<br/>k for user is: ".$k;
						}*/
				}
				
				$products_ids = array_keys($products);
				
				if(count($products_ids)==0)
				{
					return array();
				}
				
				foreach($products as $product_id =>$product)
				{					
					//$products[$product_id]->buyer = $users[$products[$product_id]->buyer_id];
					
					if($products[$product_id]->buyer_id>30000000)
					{
										$products[$product_id]->buyer = $users[($products[$product_id]->buyer_id-30000000)];

				//$products[$product_id]->buyer = $users[$products[$product_id]->buyer_id];
					}
					else{
						$products[$product_id]->buyer = $users[$products[$product_id]->buyer_id];
					}
				}
				
				//echo "count of result at order.".count($products);
				return $products;
			}
			else
			{
				return ;
			}
		}
	
	}
?>