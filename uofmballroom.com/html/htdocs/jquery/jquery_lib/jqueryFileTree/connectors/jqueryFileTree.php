<?php
//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//

$_POST['dir'] = urldecode($_POST['dir']);

$root='/home/uofmballroom/uofmballroom.com/html';
if( file_exists($root . $_POST['dir']) ) {
	$files = scandir($root . $_POST['dir']);
	natcasesort($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
			
			//echo $file."<br/>";
			$secondFiles= scandir($root . $_POST['dir'].$file);
			//echo "top here";
				//All dirs
				$gallery=false;
				//echo "before foreach";
				foreach( $secondFiles as $secondFile ) {

					$ext = strrchr($secondFile, ".");
 
	   				if($ext == ".jpg") { 
	 					$gallery=true;
					}
				}
			
			
			if(!$gallery)
			{
				echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
				
			}
			else
			{
					echo "<li class=\"file ext_php\"><a class='galleryLink' href=\"" . htmlentities($_POST['dir'] . $file) . "\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
			}
		
		 }
			
		}
		// All files
		foreach( $files as $file ) {
			
			
			$ext = strrchr($file, ".");
 
	   		if($ext == "") { 
	 			if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
					$ext = preg_replace('/^.*\./', '', $file);
					echo "<li class=\"file ext_$ext\"><a class='galleryLink' href=\"" . htmlentities($_POST['dir'] . $file) . "\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
				}
	   }
		}
			
		echo "</ul>";	
	}
}


?>