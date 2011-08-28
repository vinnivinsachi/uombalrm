<?php

	class InventoryController extends CustomControllerAction
	{
		public function init()
		{
			parent::init();
			
			$this->breadcrumbs->addStep('product manager', $this->getUrl(null, 'productmanager'));
			$this->identity=Zend_Auth::getInstance()->getIdentity();
			
			$user = new DatabaseObject_User($this->db);
			if($user->loadByUserId($this->identity->userID))
			{
			$this->view->clubManager =$user;
			}
			
			////echo $user->profile->paypalEmail;
			$_SESSION['categoryType'] = 'product';

		}
		
		
		public function indexAction()
		{ 
		
			$shoppingcarts = new Profile_Cart($this->db);
			
			$profiles = $shoppingcarts->loadPastDueProfile();
			
			
			/*if(count($profiles)==0)
			{
				//echo "<br/>there is none";
			}
			else
			{
				//echo "<br/>there is :".count($profiles);
				
			}*/
			
			$this->view->profiles = $profiles;		
		}
		
		public function clearcartsAction()
		{
		
			$shoppingcarts = new Profile_Cart($this->db);
			
			$profiles = $shoppingcarts->loadPastDueProfile();
			
			foreach ($profiles as $k =>$v)
			{
				echo $profiles[$k]->cart_key;
				$this->shoppingCart->deleteShoppingCart($profiles[$k]->cart_key);

			}
		
		}

	
		public function addinventoryAction()
		{
			$request=$this->getRequest();
			
			$invProfile= new DatabaseObject_Invprofile($this->db);
			
			$invProfile->size = $request->getPost('inv-size');
			$invProfile->heel = $request->getPost('inv-heel');
			$invProfile->color = $request->getPost('inv-color');
			$invProfile->width = $request->getPost('inv-width');
			$invProfile->comment = $request->getPost('inv-comment');
			$invProfile->price = $request->getPost('inv-price');
			$invProfile->quantity = $request->getPost('inv-quantity');
			$invProfile->product_id = $request->getPost('product_id');
			$invProfile->leather = $request->getPost('inv-leather');
			$invProfile->length = $request->getPost('inv-length');
			$invProfile->hip = $request->getPost('inv-hip');
			$invProfile->waist = $request->getPost('inv-waist');
			$invProfile->height = $request->getPost('inv-height');
			$invProfile->save();
			
			$this->_redirect($this->getUrl('preview', 'productmanager').'?id='.$request->getPost('product_id'));
		
		}
		
		public function deleteinventoryAction()
		{
			$request=$this->getRequest();
			
			$invProfile=new DatabaseObject_Invprofile($this->db);
			$invProfile->loadItem($request->getPost('id'));
			$invProfile->delete();
			
			$this->_redirect($this->getUrl('preview', 'productmanager').'?id='.$request->getPost('product_id'));
			
			
		}

}


?>