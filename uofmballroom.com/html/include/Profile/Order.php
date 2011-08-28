<?php
	
	class Profile_Order extends DatabaseObject
	{
		public $orderAttribute;
		public function __construct($db)
		{
			parent::__construct($db, 'orders_profile', 'profile_id');
			$this->add('order_id');
			//$this->add('cart_id');
			$this->add('cart_key');
			$this->add('product_id');
			$this->add('product_name');
			$this->add('product_type');
			$this->add('quantity');
			$this->add('unit_cost');
			$this->add('ts_created');

			$this->orderAttribute = new Profile_OrderAttribute($db);

		}
		
		protected function postLoad()
		{
		
			$this->orderAttribute->setPostId($this->getId());
			$this->orderAttribute->load();
		}
		
		protected function postInsert()
		{
			$this->orderAttribute->setPostId($this->getId());
			$this->orderAttribute->save(false);
			return true;
		}
		
		protected function postUpdate()
		{
			$this->orderAttribute->save(false);
			return true;
		}
		
		protected function preDelete()
		{
		
			echo "here at delete";
			$this->orderAttribute->delete();
			return true;
		}
		
		
		public function loadProifleByOrderID($ID)
		{
			$id = (int)$ID;
			
			if(strlen($ID)<=0)
			{
				echo "your ID is invalid";
				return false;
			}
			
			$query = sprintf('select %s from %s where order_id = ?', join(', ', $this->getSelectFields()), $this->_table);
			$query = $this->_db->quoteInto($query, $ID);
			
			return $this->_db->fetchAll($query);
		}
	
		public function loadOrder($profileID, $cartKey)
		{
			$select = $this->_db->select();
						
			/*if($object_type =='individualDue')
			{
				$club_id = $object->clubAdmin_id;
			}
			else
			{
				$club_id = $object->user_id;
			}
			*/
			
			$select->from('orders_profile', '*')
				   ->where('cart_key =?', $cartKey)
				   ->where('profile_id=?', $profileID);
				   // ->where('product_id =?', $productID)
				   //->where('product_type = ?', $object_type);
				   
			//echo "<br/> your select query is: ".$select;
			
			return $this->_load($select);	
		}
	
		
			
	
	}




?>