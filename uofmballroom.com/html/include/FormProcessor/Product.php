<?php

	class FormProcessor_Product extends FormProcessor
	{
		protected $db = null;
		public $user = null;
		public $product = null;
		
		
		public function __construct($db, $userID, $product_id = 0)
		{
			parent::__construct();
		
			$this->db = $db;
			
			$this->user = new DatabaseObject_User($db);
			$this->user->load($userID);
			
			//echo "The user at product: ".$this->user->username;
		
			$this->product = new DatabaseObject_Product($db);
			
			//$this->product->url = 'blah blah';
			//Now I must load the object so I can edit it.
			//echo "<br/>the user id is: ".$userID; 
			//echo "<br/>The produc Id is: ".$product_id;

			
			
			DatabaseObject_StaticUtility::loadObjectForUser($this->product, $this->user->getId(), $product_id, 'product_id');
			//$this->product->delete();
			
		
			if($this->product->isSaved())
			{
				$this->product_name = $this->product->profile->name;
				$this->product_price = $this->product->profile->price;
				$this->product_description = $this->product->profile->description;
				$this->ts_created = $this->product->ts_created;
			}
			else
			{
				$this->product->user_id = $this->user->getId();
				
			}
			
		}
	
	
		public function process(Zend_Controller_Request_Abstract $request)
		{
		
			//echo "<br/> Here at process";
		
			$this->product_name = $this->sanitize($request->getPost('form_product_name'));
			$this->product_name = substr($this->product_name, 0, 255);
			
			//echo "current product name: ".$this->product_name;
			if(strlen($this->product_name)==0)
			{
				$this->addError('product_name', 'Please enter a valid product name');
			}
			
			$this->product_price = $this->sanitize($request->getPost('form_product_price'));
			
			if($this->product_price=="FREE")
			{
				echo "here at free product";
				$this->product_price=0;
			}
			
			if(!is_numeric($this->product_price))
			{
				$this->product_price=0;
				//$this->addError('product_price', 'Please enter a valid product price');
			}
			
			
			$this->product_description = FormProcessor_BlogPost::cleanHtml($request->getPost('product_description'));
			
			if(!$this->hasError())
			{
				$this->product->profile->name = $this->product_name;
				$this->product->profile->price = $this->product_price;
				$this->product->profile->description = $this->product_description;
				
				$this->product->save();
				
			}
			
			return !$this->hasError();
	
		}
		
	
		
	
	
	
	
	}