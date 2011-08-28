<?php
//uofmballroom

	class FormProcessor_Image extends FormProcessor
	{
		protected $post;
		protected $product;
		protected $user;
		protected $event;
		protected $universalDue;
		public $image;
		
		public function __construct(DatabaseObject $object)
		{
			parent::__construct();
			
			if($_SESSION['categoryType']=='shoutout')
			{
				
				$this->shoutout=$object;
			}
			
			if($_SESSION['categoryType']=='post')
			{
				$this->post=$object;
			}
			elseif($_SESSION['categoryType']=='product')
			{
				$this->product=$object;
			}
			elseif($_SESSION['categoryType']=='clubImage')
			{
				$this->user = $object;
			}
			elseif($_SESSION['categoryType']=='event')
			{
				$this->event = $object;
			}
			elseif($_SESSION['categoryType']=='universalDueImage')
			{
				$this->universalDue = $object;
			}
			
			$this->image = new DatabaseObject_Image($object->getDb());
			
			if($_SESSION['categoryType']=='post')
			{
				$this->image->post_id = $this->post->getId();
			}
			
			elseif($_SESSION['categoryType']=='product')
			{
				$this->image->product_id = $this->product->getId();
			}
			
			elseif($_SESSION['categoryType']=='clubImage')
			{
				$this->image->user_id = $this->user->getId();
			}
			elseif($_SESSION['categoryType']=='event')
			{
				$this->image->event_id = $this->event->getId();
			}
			elseif($_SESSION['categoryType']=='universalDueImage')
			{
				$this->image->universal_dues_id = $this->universalDue->getId();
			}
			elseif($_SESSION['categoryType']=='shoutout')
			{
				$this->image->shoutout_id = $this->shoutout->getId();
			}
			
		}
		
		public function process(Zend_Controller_Request_Abstract $request)
		{
		
			if(!isset($_FILES['image']) || !is_array($_FILES['image']))
			{
				$this->addError('image', 'Invalid upload data');
				
				return false;
			}
		
			$file = $_FILES['image'];
			
			//echo "<br/>".$file['tmp_name'];
			//echo "<br/>".$file['name'];
			
			//echo "<br/>".$file['type'];
			
			//echo "<br/>".$file['error'];
			
			switch($file['error'])
			{
				case UPLOAD_ERR_OK:
					//echo "upload okay";
					break;
				case UPLOAD_ERR_FORM_SIZE:
					//only used if max_file_size specified in fomr
				case UPLOAD_ERR_PARTIAL:
					$this->addError('image', 'The uploaded file was too large');
					break;
				case UPLOAD_ERR_NO_FILE:
					$this->addError('image', 'No file was uploaded');
					break;
				case UPLOAD_ERR_NO_TMP_DIR:
					$this->addError('image','Temporary folder not found');
					break;
				case UPLOAD_ERR_CANT_WRITE:
					$this->addError('image', 'Unable to write file');
					break;
				case UPLOAD_ERR_EXTENSION:
					$this->addError('image', 'Invalid file extension');
					break;
				
				default:
					$this->addError('image', 'Unkonw error code');
					
			}
					
			if($this->hasError())
			{
				return false;
			}
			
			echo "<br/> at after hasError";
			
			$info = getImageSize($file['tmp_name']);
			if(!$info)
			{
				$this->addError('type', 'Uploaded file was not an image');
				return false;
			}
			
			//echo $info[2];
			
			
			
			switch($info[2])
			{
				case IMAGETYPE_PNG:
				case IMAGETYPE_GIF:
				case IMAGETYPE_JPEG:
				case IMAGETYPE_JPG:
					break;
				
				default:
					$this->addError('type', 'Invalid image type uploaded');
					return fase;
			}
			
			//if no errors hav eoccurred save the image
			if(!$this->hasError())
			{
				$this->image->uploadFile($file['tmp_name']);
				$this->image->filename = basename($file['name']);
				$this->image->save();
				
				$thumnail1 = $this->image->createThumbnail(150, 0, "homeFrontFour");
				echo "here ate product suppliment1: {$thumnail1}<br/>";

				$thumnail2=$this->image->createThumbnail(263,0,"mainFrontThree");
				echo "here ate product suppliment2: {$thumnail2}<br/>";

				$thumnail3=$this->image->createThumbnail(403,0,"mainFrontTwo");
				echo "here ate product suppliment3: {$thumnail3}<br/>";

				$thumnail4=$this->image->createThumbnail(207,0,"mainFrontFour");
				echo "here ate product suppliment4: {$thumnail4}<br/>";
				
				$thumnail5=$this->image->createThumbnail(205,0,"sidePanelPic");
				echo "here ate product suppliment4: {$thumnail4}<br/>";
				
				$thumnail6=$this->image->createThumbnail(140,0,"postThumb");
				
				$thumnail7=$this->image->createThumbnail(0, 65,"editThumb");
			}
			
			return !$this->hasError();
		}
		
		
		
		
		

	}
	
	
?>