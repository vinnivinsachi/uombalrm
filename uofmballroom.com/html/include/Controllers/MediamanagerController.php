<?php
	//the alphabet link is only for testing as of now. it is not incorporated into anyother pages. 
	
	//require_once 'Zend/Controller/Action.php'; 
	
	class MediamanagerController extends CustomControllerAction
	{
	
		protected $university;
		
		protected $developerKey='AI39si6JuA1zsN_9nlphxN-D2imsROdPxlkKAI3AdOCF-c4dq1UVdhNPOfueCEobv_foFEi7ZUXN1opGvfw9q33QDBloAdbd0A';
	
		public function preDispatch()
		{
			parent::preDispatch();	
			$_SESSION['categoryType'] = 'product';
		}
	
	
		public function indexAction()
		{
			/*$config = new Zend_Config_Ini('settings.ini', 'development');

			$basedir=$config->paths->media;
			$Media = new Helper_Media($basedir);
			
			
			$path = $this->getRequest()->getQuery('path');			
			echo $path;
			
			if(isset($path))
			{
				$fulldir=implode('/',array($basedir, $path));
			}
			else
			{
				$path="";
				$fulldir=$basedir;
			}
			echo "<br/>path now: ".$path;
			echo "<br/>fulldir: ".DatabaseObject_StaticUtility::show_php($fulldir); 
			
			$crumbs = $Media->get_breadcrumbs($path);
			$cc=count($crumbs);
			if($cc>0)
			{
				$closeup = $Media->is_close_up($crumbs[$cc-1]['name']);
			}
			else
			{
				$closeup=false;
			}
			
			if($closeup==false)
			{
				$listings=$Media->list_dir($fulldir,$path);	
				$subdirs=$listings['dirs'];
				$imgs=$listings['imgs'];
				$others=$listings['others'];
			}
			
			echo "<br/>listings: ".DatabaseObject_StaticUtility::show_php($listings);
			echo "<br/>subdirs: ".DatabaseObject_StaticUtility::show_php($subdirs);

			echo "<br/>imgs: ".DatabaseObject_StaticUtility::show_php($imgs);

			echo "<br/>others: ".DatabaseObject_StaticUtility::show_php($others);
			
			$this->view->listings = $listings;
			$this->view->subdirs = $subdirs;
			$this->view->imgs = $imgs;
			$this->view->others = $others;*/

			
			/*$breadcrumbs=$Media->get_breadcrumbs($path);
			echo "<br/>breadcrumbs: ".DatabaseObject_StaticUtility::show_php($breadcrumbs); */
			
			
		}
	
		
		public function photoAction()
		{
		
		
		}
		
		public function albumAction()
		{
			$this->view->photoAlbum = 'true';
			$this->view->photoAlbumManager='true';
			
			
		}
		
		public function videoAction()
		{
				$this->view->videoEditing='true';
				
				$printer = new Helper_YouTube();
				$yt = $printer->getYtService(); //you must first associsate yourself with youtube videos. 
			
				/*if(strlen($yt>0))
				{
					$this->view->needToLogin='true';
					
				}*/
				
				if($yt==false)
				{
					
					$this->view->needToLogin='true';

				}
				else
				{
					
				
					$request= $this->getRequest();
					$params['videoTitle']=$request->getQuery('videoTitle');
					$this->view->videoTitle=$params['videoTitle'];
					$params['videoDescription']=$request->getQuery('videoDescription');
					$this->view->videoDescription = $params['videoDescription'];
					$params['year']=$request->getQuery('year');
					$this->view->year = $params['year'];
					$params['event']=$request->getQuery('event');
					$this->view->event = $params['event'];
					$params['location']=$request->getQuery('location');
					$this->view->location = $params['location'];
					$params['level']=$request->getQuery('level');
					$this->view->level= $params['level'];
					$params['style']=$request->getQuery('style');
					$this->view->style = $params['style'];
					
					$error=array();
					if($params['videoTitle']=='')
					{
						$error['videoTitle']='Please fill out a videoTitle';
					}
					if($params['videoDescription']=='')
					{
						$error['videoDescription']='Please fill out a video description';
					}
					
					if(count($error)>0)
					{
						$this->view->error=$error;
					}
					else
					{
						
				
						$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
	
						$myVideoEntry->setVideoTitle($params['videoTitle']);
						$myVideoEntry->setVideoDescription($params['videoDescription']);
					// The category must be a valid YouTube category!
						$myVideoEntry->setVideoCategory('Sports');
	
					// Set keywords. Please note that this must be a comma-separated string
					// and that individual keywords cannot contain whitespace
					
						$categoryString='';
						if($params['year']!='')
						{
							$categoryString.=''.$params['year'];
							$this->view->year = $params['year'];
						}
						
						if($params['event']!=''&& $params['year']!='')
						{
							$categoryString.=', '.$params['event'];
							$this->view->event = $params['event'];
						}
						elseif($params['event']!='')
						{
							$categoryString.=$params['event'];
							$this->view->event = $params['event'];
						}
						
						if($params['location']!='' &&($params['event']!=''|| $params['year']!=''))
						{
							$categoryString.=', '.$params['location'];
							$this->view->location = $params['location'];
						}
						elseif($params['location']!='')
						{
							$categoryString.=$params['location'];
							$this->view->location = $params['location'];
						}
						
						if($params['level']!='' &&($params['event']!=''|| $params['year']!='' || $params['location']!=''))
						{
							$categoryString.=', '.$params['level'];
							$this->view->level = $params['level'];
						}
						elseif($params['level']!='')
						{
							$categoryString.=$params['level'];
							$this->view->level = $params['level'];
						}
						
						if($params['style']!='' && ($params['event']!=''|| $params['year']!='' || $params['location']!='' || $params['level']!=''))
						{
							$categoryString.=', '.$params['style'];
							$this->view->style = $params['style'];
						}
						elseif($params['style']!='')
						{
							$categoryString.=$params['style'];
							$this->view->style = $params['style'];
						}
						
						echo "<br/>category tags are ".$categoryString;
						$myVideoEntry->SetVideoTags($categoryString);
				
						$tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
						try{ 
							$tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl); 
							}catch (Zend_Gdata_App_HttpException $http_ex) 
							{ print $http_ex->getMessage(); } 
						$tokenValue = $tokenArray['token'];
						$postUrl = $tokenArray['url'];
				
						$nextUrl = 'http://www.visachidesign.com/media/video';
				
					
						$this->view->postUrl = $postUrl;
						$this->view->nextUrl = $nextUrl;
						$this->view->tokenValue=$tokenValue;
				
					// build the form
						$form = '<form action="'. $postUrl .'?nexturl='. $nextUrl .
						'" method="post" enctype="multipart/form-data">'. 
						'<input name="file" type="file"/>'. 
						'<input name="token" type="hidden" value="'. $tokenValue .'"/>'.
						'<input value="Upload Video File" type="submit" />'. 
						'</form>';
					}
					
				//$this->view->uploadVideoForm = $form;
			
				}
		
		
	
		}
		
		public function uploadvideoAction()
		{
			
			
			$printer = new Helper_YouTube();
				$yt = $printer->getYtService(); //you must first associsate yourself with youtube videos. 
			
				$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

				$myVideoEntry->setVideoTitle('showcase two daisy and vincent');
				$myVideoEntry->setVideoDescription('test video description');
				// The category must be a valid YouTube category!
				$myVideoEntry->setVideoCategory('Sports');

				// Set keywords. Please note that this must be a comma-separated string
				// and that individual keywords cannot contain whitespace
				$myVideoEntry->SetVideoTags('2009, union, showcase, rumba');
				
				$tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
				try{ 
					$tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl); 
				}catch (Zend_Gdata_App_HttpException $http_ex) 
					{ print $http_ex->getMessage(); } 
				$tokenValue = $tokenArray['token'];
				$postUrl = $tokenArray['url'];
			
				$nextUrl = 'http://www.visachidesign.com/media/video';
			
				// build the form
					$form = '<form action="'. $postUrl .'?nexturl='. $nextUrl .
					'" method="post" enctype="multipart/form-data">'. 
					'<input name="file" type="file"/>'. 
					'<input name="token" type="hidden" value="'. $tokenValue .'"/>'.
					'<input value="Upload Video File" type="submit" />'. 
					'</form>';
					
				$this->view->uploadVideoForm = $form;
			
			
			
			
			
			
		}
		
		
		
		
		
		public function helpAction()
		{
		
		
		}
		
		public function termsAction()
		{
		
			$this->breadcrumbs->addStep('Terms');

		}
		
		public function contactAction()
		{
		
		
		
		
		
		}
		
		
			
		public function testAction()
		{
		

					//$this->_helper->viewRenderer->setNoRender();

		 
			/*
			excell checker
			$this->_helper->viewRenderer->setNoRender();
			header ( "Expires: 0" );
			header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
			header ( "Pragma: no-cache" );
			header ( "Content-type: application/x-msexcel" );
			header ( "Content-Disposition: attachment; filename=test.xls" );
			header ( "Content-Description: PHP Generated XLS Data" );
			
			$data = array(
					array('name'=>'joe', 'id'=>5, 'phone'=>'615-957-4320'),
					array('name'=>'bob', 'id'=>6, 'phone'=>'615-322-8419'));
		
		
			echo "<table>
					<tr>
						<td><strong>Name:</strong></td><td><strong>Id:</strong></td><td><strong>phone</strong></td>
					</tr>";
		
			foreach($data as $k=>$v)
			{
			
				echo "<tr>
						<td>".$data[$k]['name']."</td><td>".$data[$k]['id']."</td><td>".$data[$k]['phone']."</td></tr>";
			}
			
			echo "</table>";
			*/
		}

	}
?>