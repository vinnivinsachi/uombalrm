<?php
	class Message extends DatabaseObject
	{
		protected $memberID;
		protected $clubID;
		public $profile=null;	
		public $sender;	
		
		public function __construct($db, $message, $message_id, $profile_object)
		{
			parent::__construct($db, $message, $message_id);
		
			
			$this->add('sender_id');
			$this->add('receiver_id');
			$this->add('status', 'unread');
			$this->add('date_started', time(), self::TYPE_TIMESTAMP);
			
			//echo "individual_dues_key is: ".$this->individual_dues_key;
			$this->profile = $profile_object;
		}
		

		protected function postLoad()
		{
		
			$this->profile->setMessageId($this->getId());
			$this->profile->load();
			
		}
		
		protected function postInsert()
		{
			$this->profile->setMessageId($this->getId());
			$this->profile->save(false);
			
			//echo "<br/>at profile->save";
			return true;
		}
		
		protected function postUpdate()
		{
			$this->profile->save(false);
			return true;
		}
		
		protected function preDelete()
		{
			/*$this->getImages();
			foreach ($this->images as $image)
			{
				$image->delete(false);
			}
			*/
			$this->profile->delete();
			return true;
		}
		
		
		public function checkSenderMessages($userID, $message_id)
		{
			$select =$this->_db->select();
			
			$select->from(array('m' => 'sender_messages'), '*')
				   ->where('m.sender_id = ?', $userID)
				   ->where('messages_id = ?', $message_id);
				   
			$return1 = $this->_db->fetchAll($select);
			
			
			if(count($return1) ==0)
			{
				return false;
			}
			else
			{
				if(count($return1)>0)
				{
					return $this->_load($select);
				}
			}
		}
		
		public function checkReceiverMessages($userID, $message_id)
		{
			$select =$this->_db->select();
			
			$select->from(array('m' => 'receiver_messages'), '*')
				   ->where('m.receiver_id = ?', $userID)
				   ->where('messages_id = ?', $message_id);
				   
			$return1 = $this->_db->fetchAll($select);
			
			
			if(count($return1) ==0)
			{
				return false;
			}
			else
			{
				if(count($return1)>0)
				{
					return $this->_load($select);
				}
			}
		}
		
		
		public static function loadMessages($db, $user_id, $type)
		{
		
			$select = $db->select();
			
			
			if($type=='inbox')
			{
			$select->from('receiver_messages', '*')
				   ->where('receiver_id = ?', $user_id)
				   ->order('date_started desc');
			}
			elseif($type=='outbox')
			{
			$select->from('sender_messages', '*')
				   ->where('sender_id = ?', $user_id)
				   ->order('date_started desc');

			}
			
			$data = $db->fetchAll($select);
			
			$products = self::BuildMultiple($db,__CLASS__,$data); 
			
			echo "<br/>numbe rof products are: ".count($products);
			/*loading of user*/
				if($type=='inbox')
				{
					foreach($products as $k=>$v)
					{
						$sender[$k] = $products[$k]->sender_id;
					}
				}
				elseif($type=='outbox')
				{
					foreach($products as $k=>$v)
					{
						$sender[$k] = $products[$k]->receiver_id;
					}
				}
					$select->from('users', '*')
						   ->where('userID in (?) ', $sender);
						   
					$data = $db->fetchAll($select);
			
					$users = DatabaseObject::BuildMultiple($db, 'DatabaseObject_User', $data);
					
			
			$products_ids = array_keys($products);
			
			if(count($products_ids)==0)
			{
				return array();
			}
			

			$profiles =Profile::BuildMultiple($db, 'Profile_Message', array('message_id'=>$products_ids));
			
			foreach($products as $product_id =>$product)
			{
				if(array_key_exists($product_id, $profiles) && $profiles[$product_id] instanceof Profile_Message)
				{
					$products[$product_id]->profile=$profiles[$product_id]; 
					
					//echo "<br/>user unit: ".$products[$product_id]->sender_id;
					//echo "<br/>User unit: ".$users[25]->profile->public_club_name;
					if($type=='inbox')
					{	
						$products[$product_id]->sender = $users[$products[$product_id]->sender_id];
					}
					elseif($type=='outbox')
					{
						$products[$product_id]->sender = $users[$products[$product_id]->receiver_id];
					}
					//echo "<br/>After user unit: ".$products[$product_id]->sender->username;
				}
				else
				{
					$products[$product_id]->profile->setProductId($product_id);
				}
				
			}
			
			
			//echo "<br/>before return count of products is: ".count($products);
			
			return $products;
		
		}
		
		public function getTeaser($length)
		{
			return DatabaseObject_StaticUtility::GetTeaser($this->profile->content, $length);
		}		

		

	}
?>