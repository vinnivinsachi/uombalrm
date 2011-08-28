<?php
//Uofmballroom

class UtilityController extends CustomControllerAction
	{
	
		//utility controller is here to facilitate the generation of page contents. 
		//captchaActoin is to output an image during sign in. 
		//image is to output allsorts of images on to the main objects.
		public function captchaAction()
		{
			$session = new Zend_Session_Namespace('captcha');
			
			//check for existing phrase in session
			$phrase = null;
			if(isset($session->phrase) && strlen($session->phrase)>0)
			{
				$phrase = $session->phrase;
			}
			
			$captcha = Text_CAPTCHA::factory('Image');
			
			$opts = array('font_size'    =>    20,
						  'font_path'    =>    Zend_Registry::get('config')->paths->data,
						  'font_file'    =>    'VeraBd.ttf');
						  
			$captcha->init(120, 60, $phrase, $opts);
			
			//write the phrase to sessoin
			$session->phrase = $captcha->getPhrase();
			
							
			//disable auto-rendering since we're outputting an image
			$this->_helper->viewRenderer->setNoRender();
			header('Content-type: image/png');
			echo $captcha->getCAPTCHAAsPng();
		}
		
		public function imageAction()
		{
			$request = $this->getRequest();
			$response = $this->getResponse();
			
			$id = (int) $request->getQuery('id'); //this gets the id value from the url
			$w = (int) $request->getQuery('w');
			$h =(int) $request->getQuery('h');
			$username = $request->getQuery('username');
			
			$hash = $request->getQuery('hash');
			
			$realHash = DatabaseObject_Image::GetImageHash($id, $w, $h);
			

			$this->_helper->viewRenderer->setNoRender();
			
			
			$image = new DatabaseObject_Image($this->db);
			
			
			if(!empty($username))
			{
			
			//echo "here";
			$image->setUsername($username);
			}
			
			
			
			if($hash != $realHash || !$image->load($id))
			{
				//echo "image not found";
				$response->setHttpResponseCode(404);
				return;
			}
			
			
			//try{ //if this fails, then try something different.
			//echo "here at try imageThumbnail"; 
				$fullpath = $image->createThumbnail($w, $h);
			//}
			//catch (Exception $ex)
			//{
				/*echo "here at failed thrumbnail";
				$fullpath = $image->getFullPath();
				echo $fullpath; */
			//}
			
			$info = getImageSize($fullpath);

			//$response->setHeader('content-type', $info['mime']);
			//$response->setHeader('content-type', filesize($fullpath));
			
			//echo $fullpath;
			echo "<img src='$fullpath.jpg'/>";
		}
	}
?>