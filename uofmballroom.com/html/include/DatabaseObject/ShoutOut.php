<?php

	class DatabaseObject_ShoutOut extends DatabaseObject
	{


		public $images = array();

		public function __construct($db)
		{
			
			parent::__construct($db, 'shout_out', 'shoutout_id');
		
			$this->add('your_name');
			$this->add('email');
			$this->add('phone');
			$this->add('type');
			$this->add('image_url', 'null');
			$this->add('text');
			$this->add('price');
			$this->add('ts_created', time(), self::TYPE_TIMESTAMP);
			
			$this->image = new DatabaseObject_Image($db);
		}
		
		
		protected function preInsert()
		{
		
			//$this->_newPassword = Text_Password::create(8);
			//$this->password = $this->_newPassword;
			//$this->profile->num_posts =10;
			
			return true;
		}
		
		protected function postLoad()
		{
			
			$this->loadImage();
			//$this->profile->setUserId($this->getId());
			//$this->profile->load();
			
	
		}
		
		protected function postInsert()
		{
			/*$this->profile->setUserId($this->getId());
			$this->profile->save(false);
			
			$this->sendEmail('user-register.tpl');
			
			if($this->user_type == 'clubAdmin')
			{
				DatabaseObject_StaticUtility::addClubNumber($this->_db, $this->university_id);
				DatabaseObject_StaticUtility::addTypeClubNumber($this->_db, $this->type_id);
			}*/
			
			//echo "message being sent";
			//$this->addToIndex();
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
		
		
		public function loadByID($id)
		{
			$select = $this->_db->select();
			
			$select->from('shout_out')
				   ->where('shoutout_id = ?', $id);
		
			return $this->_load($select);
		}
		
		public function sendEmail($tpl, $secondUser='', $invoiceID='')
		{
			$templater = new Templater();
			$templater->user = $this;
			
			if($secondUser != '')
			{
			$templater->member = $secondUser;
			}
			
			//fetch teh e-amil body
			$body = $templater->render('email/'.$tpl);
			
			//extract the subject from the first line
			list($subject, $body) = preg_split('/\r|\n/', $body, 2);
			
			//now set up and send teh email
			
			echo "here at mail"."<br/>";
			$mail = new Zend_Mail();
			
			//set the to address and the user's full name in the 'to' line
			echo "the email sent out is: ".$this->email."<br />";
			$mail->addTo($this->email, trim($this->first_name.' '.$this->last_name));
			
			//get the admin 'from details form teh config
			$mail->setFrom('bt-no-reply@uofmballroom.com', 'bt-no-reply');
			
			//set the subject and boy and send the mail
			$mail->setSubject(trim($subject));
			$mail->setBodyText(trim($body));
			$mail->send();
		}
		
		public function loadImage()
		{
			$options=array('shoutout_id' =>$this->getId()); //loading images
			$this->images = DatabaseObject_Image::GetImages($this->getDb(), $options, 'shoutout_id', 'shout_out_image');
		}
	}
?>