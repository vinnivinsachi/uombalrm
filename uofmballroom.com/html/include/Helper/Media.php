<?php

	class Helper_Media
	{
		
		private $basedir;
		private $thumb_max=120;
		
		public function Helper_Media($basedir)
		{
			$this->basedir = $basedir;	
		}
				
		public function list_dir($dir, $path)
		{
			$dirs = array();
			$imgs = array();
			$others = array();
			
			$d = dir($dir);
			//echo $d;
			
			while(false != ($entry = $d->read()))
			{
					if(is_dir(implode('/', array($dir, $entry))))
					{
						if(($entry!='.') && ($entry!='..'))
						{
							$dirs[]=$entry;
						}
					}
					elseif($this->is_image_file($entry, $path))
					{
						$bits=explode('.', $entry);
						$imgs[]=$bits[0];
					}
					else
					{
						$others[]=$entry; 
					}
			}
			$results = array(
							 	'dirs' => $dirs,
								'imgs' => $imgs,
								'others' => $others
								);
			return $results;
		}
			
		
		public function is_image_file($entry, $path)
		{
			/*echo "here at is_image_file";
			return true;*/
			
			$is_image = false;
			$bits=explode('.',$entry);
			$last = count($bits)-1;
			if($bits[$last]=='jpg')
			{
				$is_image = ($bits[$last-1]!='thumb');
				if($is_image)
				{
					$this->ensure_thumbnail($bits[0], $path);
				}
			}
			return $is_image;
			
		}
		
		public function ensure_thumbnail($base_name, $path)
		{
			/*echo "<br/>here at ensure_thumbnails";
			echo "<br/>base_name at ensure_thumbnail is: ".$base_name;
			echo "<br/>path at ensure_thumbnails is: ".$path;*/
			
			
			$thumb_name = join('/',array($this->basedir, $path.$base_name.'.thumb.jpg'));
		//	echo "<br/>final thumb_name is: ".$thumb_name."<br/>";
			
			if(!file_exists($thumb_name)) 
			{
				$source_name = join('/',array($this->basedir, $path. $base_name.'.jpg'));
			//	echo "source for thumb_name is: ".$source_name;
				$source_img = imagecreatefromjpeg($source_name);
				$source_x= imageSX($source_img);
				$source_y= imageSY($source_img);
				$thumb_x = ($source_x>$source_y)?$this->thumb_max:$this->thumb_max*($source_x/$source_y);
				$thumb_y = ($source_x< $source_y)?$this->thumb_max:$this->thumb_max*($source_y/$source_x);
				 
				$thumb_img = ImageCreateTrueColor($thumb_x, $thumb_y);
				imagecopyresampled($thumb_img, $source_img, 0,0,0,0,$thumb_x,$thumb_y,$source_x,$source_y);
				imagejpeg($thumb_img,$thumb_name);
				imagedestroy($source_img);
				imagedestroy($thumb_img);
			}
			
		}
		
		public function get_breadcrumbs($path)
		{
			$bits=split('/',$path);
			$crumbs=array();
			$tmp_path='';
			$crumbs[]=array(
							'name'=>'home',
							'path'=>$tmp_path
							);
			foreach($bits as $i =>$value)
			{
				if(strlen($value) >0)
				{
					$tmp_path.=$value.'/';
					$crumbs[]=array(
									'name'=>$value,
									'path'=>$tmp_path
									);
				}
			}
			
			return $crumbs;
		}
			
		public function is_close_up($name)
		{
			
			$result = false;
			$bits=explode('.',$name);
			$last=$bits[count($bits)-1];
			if($last=='jpg')
			{
				$result=true;
			}
			return $result;
		}
			
			
		
		
		
	}



?> 