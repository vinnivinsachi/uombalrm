<?php

	class DatabaseObject_Helper_Registration extends DatabaseObject
	{
		
		public static function retrieveRegistrants($db, $date=''){
			$select=$db->select();
			
			$select->from('guests', '*')
			->order('ts_created DESC');
			
			return $db->fetchAll($select);
		}
	}
?>