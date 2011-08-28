<?php
	
	class ClubpreviewController extends Profilehelper
	{
		public function preDispatch()
		{
			parent::preDispatch('clubImage', 'clubpreview', 'clubAdmin', 'L');
			
			
			
		////echo "your verification status: ".$this->user->verification;
		}
	
	
	
		public function indexAction()
		{
			$options=array('user_id' =>$this->user->getId()); //loading images
			
			////echo $this->user->getId();
			
			//DatabaseObject_Image::$username=$this->user->username;
			
			////echo "username: ".DatabaseObject_Image::$username;
			
			
			$images = DatabaseObject_Image::GetImages($this->db, $options, 'user_id', 'users_profiles_images');
			$this->view->images = $images;
			
			$this->breadcrumbs->addStep('club', $this->geturl('index'));
			
		}
	
	
	}
?>