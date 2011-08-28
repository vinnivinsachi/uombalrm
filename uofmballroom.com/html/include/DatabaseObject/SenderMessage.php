<?php
	class DatabaseObject_SenderMessage extends Message
	{
		public function __construct($db)
		{
			$profile = new Profile_SenderMessage($db);
			
			parent::__construct($db, 'sender_messages', 'messages_id', $profile);
		
		}
		
		public static function loadMessages($db, $user_id, $options)
		{
		
			$select = $db->select();
			
			$select->from(array('s'=>'sender_messages'), '*')
				   ->where('s.sender_id = ?', $user_id);
				   

			if(!empty($options['alphabetLink']) && strlen($options['alphabetLink'])>0)
				{
					$select->joinInner(array('p'=>'users'), 's.receiver_id = p.userID');
					$select->where('p.first_name like "'.$options['alphabetLink'].'%"');
				}
			
			if(!empty($options['limit']) && is_numeric($options['limit']))
				{
					$select->limitpage($options['limit'], 15);
				}
			
			if(!empty($options['limitTotal']) && is_numeric($options['limitTotal']))
			{
				//echo "<br/> here at limitTotal";
					$select->limit((($options['limitTotal']+3)*15),(($options['limitTotal']*15)));	
			}
			
			$select->order('date_started desc');
			
			$data = $db->fetchAll($select);
			
			$products = self::BuildMultiple($db,__CLASS__,$data); 
			
			//echo "<br/>numbe rof products are: ".count($products);
			/*loading of user*/
			if(count($products)>0)
			{	
					foreach($products as $k=>$v)
					{
						$sender[$k] = $products[$k]->receiver_id;
					}
					
					$select2=$db->select();
				
					$select2->from('users', '*')
						   ->where('userID in (?) ', $sender);
						   
					$data = $db->fetchAll($select2);
			
					$users = DatabaseObject::BuildMultiple($db, 'DatabaseObject_User', $data);
					
			}
			$products_ids = array_keys($products);
			
			if(count($products_ids)==0)
			{
				return array();
			}
			

			$profiles =Profile::BuildMultiple($db, 'Profile_SenderMessage', array('message_id'=>$products_ids));
			
			foreach($products as $product_id =>$product)
			{
				if(array_key_exists($product_id, $profiles) && $profiles[$product_id] instanceof Profile_SenderMessage)
				{
					$products[$product_id]->profile=$profiles[$product_id]; 
					
					//echo "<br/>user unit: ".$products[$product_id]->sender_id;
					//echo "<br/>User unit: ".$users[25]->profile->public_club_name;
					
					$products[$product_id]->sender = $users[$products[$product_id]->receiver_id];
					
					//echo "<br/>After user unit: ".$products[$product_id]->sender->username;
				}
				else
				{
					$products[$product_id]->profile->setMessageId($product_id);
				}
				
			}
			
			
			//echo "<br/>before return count of products is: ".count($products);
			
			return $products;
		
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
	
	}
?>