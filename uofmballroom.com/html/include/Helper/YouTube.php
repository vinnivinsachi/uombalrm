<?php

	class Helper_YouTube
	{
		
		public function printVideoEntry($videoEntry)
		
		{
			 echo 'Video: ' . $videoEntry->getVideoTitle() . "<br/>";
  			echo 'Video ID: ' . $videoEntry->getVideoId() . "<br/>";
 	 		echo 'Updated: ' . $videoEntry->getUpdated() . "<br/>";
  			echo 'Description: ' . $videoEntry->getVideoDescription() . "<br/>";
  			echo 'Category: ' . $videoEntry->getVideoCategory() . "<br/>";
  			echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "<br/>";
  			echo 'Watch page: ' . $videoEntry->getVideoWatchPageUrl() . "<br/>";
  			echo 'Flash Player Url: ' . $videoEntry->getFlashPlayerUrl() . "<br/>";
  			echo 'Duration: ' . $videoEntry->getVideoDuration() . "<br/>";
  			echo 'View count: ' . $videoEntry->getVideoViewCount() . "<br/>";
  			echo 'Rating: ' . $videoEntry->getVideoRatingInfo() . "<br/>";
  			echo 'Geo Location: ' . $videoEntry->getVideoGeoLocation() . "<br/>";
  			echo 'Recorded on: ' . $videoEntry->getVideoRecorded() . "<br/>";
  
  // see the paragraph above this function for more information on the 
  // 'mediaGroup' object. in the following code, we use the mediaGroup
  // object directly to retrieve its 'Mobile RSTP link' child
  			foreach ($videoEntry->mediaGroup->content as $content) {
    			if ($content->type === "video/3gpp") {
     			 echo 'Mobile RTSP link: ' . $content->url . "<br/>";
    			}
 			 }
  
  			echo "Thumbnails:<br/>";
  			$videoThumbnails = $videoEntry->getVideoThumbnails();

  			foreach($videoThumbnails as $videoThumbnail) {
				echo $videoThumbnail['time'] . ' - ' . $videoThumbnail['url'];
				echo ' height=' . $videoThumbnail['height'];
				echo ' width=' . $videoThumbnail['width'] . "<br/>";
  			}

			
			
			
		}
		
		public function printVideoFeed($videoFeed)
		{
  			$count = 1;
  			foreach ($videoFeed as $videoEntry) {
    			echo "Entry # " . $count . "<br/>";
    			$this->printVideoEntry($videoEntry);
    			echo "<br/>";
    			$count++;
  		}
}
		
		
		public function getUserUploads($userName)        
		{
			$yt = new Zend_Gdata_YouTube();
  			$yt->setMajorProtocolVersion(2);
 			return $yt->getuserUploads($userName);
		}
		
		public function searchAndPrint($searchTerms = array())
		{
			$yt = new Zend_Gdata_YouTube();
  			$yt->setMajorProtocolVersion(2);
  			$query = $yt->newVideoQuery();
			
			if(isset($searchTerms['setAuthor']))
			{
				$query->setAuthor($searchTerms['setAuthor']);
			}
			if(isset($searchTerms['setMaxResults']))
			{
				$query->setMaxResults($searchTerms['setMaxResults']);
			}
			if(isset($searchTerms['setOrderBy']))
			{
				$query->setOrderBy($searchTerms['setOrderBy']); //ELEVANCE, VIEW_COUNT, UPDATED, or RATING.
			}
			if(isset($searchTerms['setStartIndex']))
			{
				$query->setStartIndex($searchTerms['setStartIndex']);
			}
			if(isset($searchTerms['setCategory']))
			{
				$query->setCategory($searchTerms['setCategory']);
			}
								
			//echo "here at get video Feed";
			//echo "<br/>query is: ".$query;
			
			$video['videos']=$yt->getVideoFeed($query);
			
			
			//________________________________trying to make sure that previous and next are avialble
			//________________________________the previous and next are both boolean values!!!
				$videoFeed = $yt->getRecentlyFeaturedVideoFeed();

				// See if the feed specifies a previous page of results.
				// In this example, the following lines of code would throw an 
				// exception since the $videoFeed contains the first page of results.
				try {
				  $video['previous']= $videoFeed->getPreviousFeed();
				 // echo "here at setting prevoius";
				} catch (Zend_Gdata_App_Exception $e) {
				  //echo $e->getMessage() . "\n";
				}
				
				// See if the feed specifies a next page of results.
				try {
				  $video['next'] = $videoFeed->getNextFeed();
				} catch (Zend_Gdata_App_Exception $e) {
				 // echo $e->getMessage() . "\n";
				}
				
				
							
			
			return $video;//$yt->getVideoFeed($query);

			
			
		}
		
		
		public function getAuthSubRequestUrl()
		{
			$next = 'http://www.visachidesign.com/mediamanager/video';
			$scope = 'http://gdata.youtube.com';
			$secure = false;
			$session = true;
			return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
		}
		
		public function getYtService()
		{
			if (!isset($_SESSION['sessionToken']) && !isset($_GET['token']) ){
				echo '<a href="' . $this->getAuthSubRequestUrl() . '">Login!</a>';
								return false;

			} else if (!isset($_SESSION['sessionToken']) && isset($_GET['token'])) {
			  $_SESSION['sessionToken'] = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
			}
		
			$httpClient = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
			$verification = $_SESSION['sessionToken'];
			
			
			$httpClient->setHeaders('X-GData-Key', "key=AI39si5crFKOiplyFnyAfoJp8u8XObPeXjZucrsZJl5f0OxcYh_FmTLzqrzBo2xihqiziCU9VYpQKZBM_V8sIFTIdoZ5BenKLQ"); 
			
			$httpClient->setHeaders('Authorization', "AuthSub token=$verification");  //this is VERYV ERY VERY VERY VERY VERY important!!! because you will get error 403 forever!!!
			$developerKey='AI39si5xBEeFphgyN0vRsxNsXCWE-6em4mr9UPQokJOCM1Z0t72Fp9VNzxusxP_m9rQciPL0rNIJ0A5JOuPaJwZd5dGFpvIY5w';
			$applicationId = 'theumbdt';
			$clientId = 'theumbdt';

			try{
			$yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
			}
			catch(Zend_Gdata_App_HttpException $http_ex) 
					{ print $http_ex->getMessage(); } 
			return $yt; 
		}
		
		
	}
	
?>