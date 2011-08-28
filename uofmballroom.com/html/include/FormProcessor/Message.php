<?php
	class FormProcessor_Message extends FormProcessor
	{
	
		protected $db = null;
		public $sender = null;
		public $receiver = null;
		public $outboxMessage = null;
		public $inboxMessage = null;
		
				
		public function __construct($db, $senderID=0, $receiverID=0)
		{
			parent::__construct();
			
			$this->db = $db;
				
			$this->sender = $senderID;
			
			$this->receiver = $receiverID;
			
			$this->outboxMessage= new DatabaseObject_SenderMessage($db);		
			$this->inboxMessage = new DatabaseObject_ReceiverMessage($db);
		}
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			$this->subject = $this->sanitize($request->getPost('subject'));
			
			$this->subject = substr($this->subject, 0, 255);
			
			
			
			$this->content = FormProcessor_BlogPost::cleanHtml($request->getPost('content'));
			
			if(strlen($this->content)==0)
			{
				$this->addError('content', 'you must enter a message');
			}

			if(!$this->hasError())
			{
			
				//echo "<br/>you are at no error";
				$this->outboxMessage->sender_id = $this->sender;
				$this->outboxMessage->receiver_id = $this->receiver;
				
				$this->outboxMessage->profile->subject = $this->subject;
				$this->outboxMessage->profile->content = $this->content;
				//echo "<br/>you are at before save()";
				$this->outboxMessage->save();
				
				$this->inboxMessage->sender_id = $this->sender;
				$this->inboxMessage->receiver_id = $this->receiver;
				
				$this->inboxMessage->profile->subject = $this->subject;
				$this->inboxMessage->profile->content = $this->content;
				//echo "<br/>you are at before save()";
				$this->inboxMessage->save();
			}
			
			
			return !$this->hasError();
		}
	
	}	
?>