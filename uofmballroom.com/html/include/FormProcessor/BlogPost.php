<?php

	class FormProcessor_BlogPost extends FormProcessor
	{
		protected $db = null;
		public $user = null;
		public $post = null;
		
		static $tags=array(
			'a' =>array('href', 'target','name'),
			'img' =>array('src', 'alt'),
			'b' =>array(),
			'strong' =>array(),
			'em' =>array(),
			'i' =>array(),
			'ul' =>array(),
			'li' =>array(),
			'ol' =>array(),
			'p' =>array(),
			'br' =>array(),
			);
		
		public function __construct($db, $userID, $post_id=0)
		{
			parent::__construct();
			
			$this->db = $db;
			$this->user= new DatabaseObject_User($db);
			$this->user->load($userID); //load everything about the user.
			
			$this->post= new DatabaseObject_BlogPost($db);			
			
			$databaseColumn = 'post_id';
			
			DatabaseObject_StaticUtility::loadObjectForUser($this->post, $this->user->getId(), $post_id, $databaseColumn); 
			
			if($this->post->isSaved())
			{
				//echo "<br/>post at is saved.";
				$this->title= $this->post->profile->title;
				$this->content = $this->post->profile->content;
				$this->ts_created = $this->post->ts_created;
				$this->title_link = $this->post->profile->title_link;
				$this->location = $this->post->profile->location;
				$this->locationURL = $this->post->profile->locationURL;
				$this->facebookURL = $this->post->profile->facebookURL;
				//echo "here at title link is".$this->title_link; 
			}
			else
			{
				//echo "<br/>post user_id is getId(): ".$this->user->getId();
				$this->post->user_id = $this->user->getId(); //$this->user_id at blogPost object came from this. 
			}
		}
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
			//echo "<br/>here at process.";
			$this->title = $this->sanitize($request->getPost('username'));
			$this->title = substr($this->title, 0, 255);
			
			if(strlen($this->title)==0)
			{
				$this->addError('title', 'Please enter a title for this post');//this is a giving FormProcessor.php function. 
			}
			
			$this->title_link = $this->sanitize($request->getPost('title_link'));
			
			//echo "the current year is: ".$request->getPost('ts_createdYear');
			//echo "the current month is: ".$request->getPost('ts_createdMonth');
			
			$date = array('y' => (int)$request->getPost('ts_createdYear'),
						  'm' => (int)$request->getPost('ts_createdMonth'),
						  'd' => (int)$request->getPost('ts_createdDay')
						  );
			
			$time = array('h' =>(int) $request->getPost('ts_createdHour'),
						  'm' =>(int) $request->getPost('ts_createdMinute')
						  );
			
			$time['h'] = max(1, min(12, $time['h']));
			$time['m'] = max(0, min(59, $time['m']));
			
			$meridian = strtolower($request->getPost('ts_createdMeridian'));
			
			if($meridian !='pm')
			{
				$meridian = 'am';
			}
			
			//conver the hour into 23 hour time
			if($time['h'] <12 && $meridian =='pm')
			{
				$time['h']+=12;
			}
			else if($time['h']==12 && $meridian =='am')
			{
				$time['h'] =0;
			}
			
			if(!checkDate($date['m'], $date['d'], $date['y']))
			{
				$this->addError('ts_created', 'Please select a valid date');
			}
			
			$this->ts_created = mktime($time['h'],
									   $time['m'],
									   0,
									   $date['m'],
									   $date['d'],
									   $date['y']
									  	);
			
			
			
			
			$cdate = array('y' => (int)$request->getPost('ev_createdYear'),
						  'm' => (int)$request->getPost('ev_createdMonth'),
						  'd' => (int)$request->getPost('ev_createdDay')
						  );
			
			$ctime = array('h' =>(int) $request->getPost('ev_createdHour'),
						  'm' =>(int) $request->getPost('ev_createdMinute')
						  );
			
			$ctime['h'] = max(1, min(12, $ctime['h']));
			$ctime['m'] = max(0, min(59, $ctime['m']));
			
			$cmeridian = strtolower($request->getPost('ev_createdMeridian'));
			
			
			
			if($cmeridian !='pm')
			{
				$cmeridian = 'am';
			}
			
			//conver the hour into 23 hour time
			if($ctime['h'] <12 && $cmeridian =='pm')
			{
				$ctime['h']+=12;
			}
			else if($ctime['h']==12 && $cmeridian =='am')
			{
				$ctime['h'] =0;
			}
			
			if(!checkDate($cdate['m'], $cdate['d'], $cdate['y']))
			{
				$this->addError('ts_created', 'Please select a valid date');
			}
			
			$this->ev_created = mktime($ctime['h'],
									   $ctime['m'],
									   0,
									   $cdate['m'],
									   $cdate['d'],
									   $cdate['y']
									  	);
										
			//echo "<br/>you are at the end of firs ttime";
			//------------------------------------------------------------------------------
			$edate = array('y' => (int)$request->getPost('ev_endedYear'),
						  'm' => (int)$request->getPost('ev_endedMonth'),
						  'd' => (int)$request->getPost('ev_endedDay')
						  );
			
			$etime = array('h' =>(int) $request->getPost('ev_endedHour'),
						  'm' =>(int) $request->getPost('ev_endedMinute')
						  );
			
			$etime['h'] = max(1, min(12, $etime['h']));
			$etime['m'] = max(0, min(59, $etime['m']));
			
			$emeridian = strtolower($request->getPost('ev_endedMeridian'));
			
			if($emeridian !='pm')
			{
				$emeridian = 'am';
			}
			
			//conver the hour into 23 hour time
			if($etime['h'] <12 && $emeridian =='pm')
			{
				$etime['h']+=12;
			}
			else if($etime['h']==12 && $emeridian =='am')
			{
				$etime['h'] =0;
			}
			
			if(!checkDate($edate['m'], $edate['d'], $edate['y']))
			{
				$this->addError('ts_created', 'Please select a valid date');
			}
			
			$this->ev_ended = mktime($etime['h'],
									   $etime['m'],
									   0,
									   $edate['m'],
									   $edate['d'],
									   $edate['y']
									  	);
			
			
			
			
			
			
			
			$this->location= $this->sanitize($request->getPost('location'));			
			//echo "the time that is created is: ".date('Y-m-d', $this->ts_created);
			
			$this->locationURL = $request->getPost('location_url');
			$this->facebookURL = $request->getPost('facebook_url');
			
			$this->content = self::cleanHtml($request->getPost('content'));
			
			//echo "<br/>here before there is error().";
			
			if(!$this->hasError())
			{
				$this->post->profile->title = $this->title;
				$this->post->ts_created = $this->ts_created;
				$this->post->ev_created = $this->ev_created;
				$this->post->ev_ended = $this->ev_ended;
				$this->post->profile->content = $this->content;
				$this->post->profile->title_link = $this->title_link;
				$this->post->profile->location=$this->location;
				$this->post->profile->locationURL = $this->locationURL;
				$this->post->profile->facebookURL = $this->facebookURL;
				
				
				$preview = !is_null($request->getPost('preview'));
				if(!$preview)
				{
					$this->post->sendLive();
				}
				$this->post->save();
			
			}
			
			return !$this->hasError();
		
		}
		
		//temporary placeholder for clean HTML
		public static function cleanHtml($html)
		{
			$chain = new Zend_filter();
			//$chain->addFilter(new Zend_Filter_StripTags(self::$tags));
			$chain->addFilter(new Zend_Filter_StringTrim());
			//$chain = new Zend_Filter_HtmlEntities();
			
			$html = $chain->filter($html);
			$html = stripslashes($html);
		
			//echo $html;
			$temp = $html;			
		while(1)
			{
				$html = preg_replace('/(<[^>]*)javascript:([^>]*>)/i', '$1$2', $html);
				
				//if nothing changed this iteration then break the loop
				if($html==$temp)
				{
					break;
				}
				
				$temp = $html;
			}
				

			return $html;
		}
		
	}
?>