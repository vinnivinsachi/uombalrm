<?php	//the alphabet link is only for testing as of now. it is not incorporated into anyother pages. 
	
	//require_once 'Zend/Controller/Action.php'; 
	
	class MediaController extends CustomControllerAction
	{
	
		protected $university;
		
		protected $developerKey='AI39si6JuA1zsN_9nlphxN-D2imsROdPxlkKAI3AdOCF-c4dq1UVdhNPOfueCEobv_foFEi7ZUXN1opGvfw9q33QDBloAdbd0A';
		//this key is for visachidesign only. 
	
		public function preDispatch()
		{
			//parent::preDispatch();	
			//$_SESSION['categoryType'] = 'product'; 
			$this->view->SecondTier = 'Media';
			
		}
		
		public function albumsAction()
		{
		}
		
		public function	 albumgalleryAction()
		{
			$filePath = $this->getRequest()->getQuery('file');
			//$this->_helper->viewRenderer->setNoRender();
			//echo $filePath;
			
			// open this directory
			$d = $_SERVER['DOCUMENT_ROOT'].$filePath;			
			// get each entry
			if(file_exists($d))
			{
				$entry = scandir($d);
				natcasesort($entry);
			}

			foreach($entry as $key=>$value)
			{
				   if(strpos($value, '.jpg') && !strpos($value, '.thumb')) $photos[] = $filePath.'/'.$value;
				   
			}
			
			// close directory
			$this->view->galleryTitle = $filePath;
			
			$this->view->photos= $photos;
 
			
			
			//$dirname= dirname(string $filepath);
			//echo $dirname;
		}
	
	
		public function indexAction()
		{
			/*
			$config = new Zend_Config_Ini('settings.ini', 'development');

			$basedir=$config->paths->media;
			$Media = new Helper_Media($basedir);
			
			
			$path = $this->getRequest()->getQuery('path');			
			//echo $path;
			
			if(isset($path))
			{
				$fulldir=implode('/',array($basedir, $path));
			}
			else
			{
				$path="";
				$fulldir=$basedir;
			}
		//	echo "<br/>path now: ".$path;
			//echo "<br/>fulldir: ".DatabaseObject_StaticUtility::show_php($fulldir);
			
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
				
				$this->view->subdirs = $subdirs;
				$this->view->imgs = $imgs;
				$this->view->others = $others;
				
			//		echo "<br/>listings: ".DatabaseObject_StaticUtility::show_php($listings);
			//echo "<br/>subdirs: ".DatabaseObject_StaticUtility::show_php($subdirs);

			//echo "<br/>imgs: ".DatabaseObject_StaticUtility::show_php($imgs);

			//echo "<br/>others: ".DatabaseObject_StaticUtility::show_php($others);
			//echo "<br/>crubms: ".DatabaseObject_StaticUtility::show_php($crumbs);
			
			}
			
			//$this->view->listings = $listings;
			$this->view->crumbs = $crumbs;
			$this->view->path=$path;

			$this->view->closeup = $closeup;

		*/
			
		
			
			
		}

		public function albumAction()
		{
			$this->view->photoAlbum='true';
			
			
		}
		
		public function imagerequestjasonAction()
		{
			
	
			header("Content-type: text/xml; charset=utf-8");
			
			$config = new Zend_Config_Ini('settings.ini', 'development');

			$basedir=$config->paths->media;
			$Media = new Helper_Media($basedir);
			
			
			$path = $this->getRequest()->getQuery('path');			
			//echo $path;
			
			if(isset($path))
			{
				$fulldir=implode('/',array($basedir, $path));
			}
			else
			{
				$path="";
				$fulldir=$basedir;
			}
		/*	echo "<br/>path now: ".$path;
			echo "<br/>fulldir: ".DatabaseObject_StaticUtility::show_php($fulldir); */
			
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
				
				$this->view->subdirs = $subdirs;
				$this->view->imgs = $imgs;
				$this->view->others = $others;
				
			/*		echo "<br/>listings: ".DatabaseObject_StaticUtility::show_php($listings);
			echo "<br/>subdirs: ".DatabaseObject_StaticUtility::show_php($subdirs);

			echo "<br/>imgs: ".DatabaseObject_StaticUtility::show_php($imgs);

			echo "<br/>others: ".DatabaseObject_StaticUtility::show_php($others);
			echo "<br/>crubms: ".DatabaseObject_StaticUtility::show_php($crumbs);*/
			
			}
			
			//$this->view->listings = $listings;
			$this->view->crumbs = $crumbs;
			$this->view->path=$path;

			$this->view->closeup = $closeup;
			
			
			
			
			
			$this->_helper->viewRenderer->setNoRender();
			
			echo "<gallery path = '$path' pre= '$fulldir'>";
			
			if(count($subdirs)>0)
			{
				echo "<folders>";
				foreach($subdirs as $i =>$value)
				{
					echo "<folder>".$value."</folder>";
				}
				echo "</folders>";
			}
			
			if(count($imgs)>0)
			{
				echo "<images>";
				foreach($imgs as $i=>$value)
				{
					echo "<image>".$value."</image>";
				}
				echo "</images>";
			}
				
			echo "</gallery>";
			
		}
		
		public function videoAction()
		{
			
			
			//**********************************here is the example that would allow the retrival of information!
			
			$request = $this->getRequest();
			$params['year'] = $request->getQuery('year');
			$params['event'] = $request->getQuery('event');
			$params['location'] = $request->getQuery('location');
			$params['level']=$request->getQuery('level');
			$params['style']=$request->getQuery('style');
			
			$params['uploader']=$request->getQuery('uploader');
			$params['counter']=$request->getQuery('counter');
			
			
			$categoryString='';
			if($params['year']!='')
			{
				$categoryString.=''.$params['year'];
				$this->view->year = $params['year'];
			}
			
			if($params['event']!=''&& $params['year']!='')
			{
				$categoryString.='/'.$params['event'];
				$this->view->event = $params['event'];
			}
			elseif($params['event']!='')
			{
				$categoryString.=$params['event'];
				$this->view->event = $params['event'];
			}
			
			if($params['location']!='' &&($params['event']!=''|| $params['year']!=''))
			{
				$categoryString.='/'.$params['location'];
				$this->view->location = $params['location'];
			}
			elseif($params['location']!='')
			{
				$categoryString.=$params['location'];
				$this->view->location = $params['location'];
			}
			
			if($params['level']!='' &&($params['event']!=''|| $params['year']!='' || $params['location']!=''))
			{
				$categoryString.='/'.$params['level'];
				$this->view->level = $params['level'];
			}
			elseif($params['level']!='')
			{
				$categoryString.=$params['level'];
				$this->view->level = $params['level'];
			}
			
			if($params['style']!='' && ($params['event']!=''|| $params['year']!='' || $params['location']!='' || $params['level']!=''))
			{
				$categoryString.='/'.$params['style'];
				$this->view->style = $params['style'];
			}
			elseif($params['style']!='')
			{
				$categoryString.=$params['style'];
				$this->view->style = $params['style'];
			}
			
			
			
						//echo "the category prints are: ".$categoryString;
			
			
						$printer = new Helper_YouTube();
			
						//$videoEntry = $yt->getVideoEntry('k004RpRspdM'); //this works!!!!!
			
						//$printer->printVideoEntry($videoEntry);
						
						//$video = $printer->getUserUploads('umbdt'); //this workds
						//$printer->printVideoFeed($video); //this workds
			$videos = array();
					
			if($params['uploader']=='')
			{
			
				$params['setAuthor']='UMBDT';      //this works
				$this->view->uploader = 'UMBDT';
			}
			else
			{
				$params['setAuthor']=$params['uploader'];
				$this->view->uploader = $params['uploader'];

			}
			
			if(isset($params['setOrderBy']))
			{
				$params['setOrderBy']=$params['setOrderBy'];
			}
			else
			{	
				$params['setOrderBy']='viewCount';
			}
			
			
			if($categoryString!='')
			{
				$params['setCategory']=$categoryString;				 //this works
			}
				
			
			if($params['counter']!='')
			{
				$params['setStartIndex']=$params['counter']*20;	
			}
			else
			{
				$params['setStartIndex']=0;
			}
				
				
				
				
				$params['setMaxResults']=20;
			
				$video=$printer->searchAndPrint($params);              //this works
				
				
				
				
				foreach($video['videos'] as $k=>$v)
				{
					//echo "k is: ".$k."<br/>";
					$videos[$k]['title']=$video['videos'][$k]->getVideoTitle();
					$videos[$k]['ID']=$video['videos'][$k]->getVideoId();
					$videos[$k]['Updated']=$video['videos'][$k]->getUpdated();
					$videos[$k]['Description']=$video['videos'][$k]->getVideoDescription();
					$videos[$k]['Category']=$video['videos'][$k]->getVideoCategory() ;
					$videos[$k]['Tags']=$video['videos'][$k]->getVideoTags();
					$videos[$k]['Watchpage']=$video['videos'][$k]->getVideoWatchPageUrl();
					$videos[$k]['FlashPlayerUrl']=$video['videos'][$k]->getFlashPlayerUrl();
					$videos[$k]['Duration']=$video['videos'][$k]->getVideoDuration();
					$videos[$k]['Viewcount']=$video['videos'][$k]->getVideoViewCount();
					$videos[$k]['Rating']=$video['videos'][$k]->getVideoRatingInfo();
					$videos[$k]['GeoLocation']=$video['videos'][$k]->getVideoGeoLocation();
					$videos[$k]['Recordedon']=$video['videos'][$k]->getVideoRecorded();
						$clips = $video['videos'][$k]->getVideoThumbnails();
						//echo "the clips are here: ".$clips[0]['url']."<br/>";
					$videos[$k]['clipUrl']=$clips[0]['url'];
					//echo "the clipUrl is:".$videos[$k]['clipUrl'];
				}
				
				
				
				
				$this->view->video = $videos;
				//$printer->printVideoFeed($video);					//this works
						
				$this->view->videoAlbum = 'true';
				
				
				
				if($params['counter']>0)
				{
					
					$this->view->previousLink = $params['counter']-1;
				}
				else{
					$this->view->previousLink='';
				}
				if($video['next'])
				{
					$this->view->nextLink = $params['counter']+1;
				}
				
				
				
		}
		
		
		public function videogeneratorAction()
		{
			$request=$this->getRequest();
			$videoValue = $request->getQuery('videoValue');
			$this->view->videoValue=$videoValue;
			
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