<?php

	//this class works for all controller/action because all other controller will extend from this one. 
	class CustomControllerAction extends Zend_Controller_Action //this can set post dispatch items. for header.tpl and footer.tpl
	{
		public $db;
		public $breadcrumbs;
		public $messenger;
		protected $shoppingCart;
		//public $cartID;
		private $username;
		protected $secondMember; //if logged in as user, then this is club. if logged in as club, then this is user.
		protected $auth;
		
		protected $affiliated;
		
		protected $alphabetLink = array();
		
		protected $returnPage;
		
		protected $cartObject;
		
		protected $logger;
		
		protected $checkoutCartID;
		protected $_sanitizeChain;
		
		//protected $productTypeArray();
		
		
		public function init()
		{
			$this->db = Zend_Registry::get('db');
			$this->breadcrumbs = new Breadcrumbs();
			//$this->breadcrumbs->addStep('Home','/');
			$this->logger =Zend_Registry::get('orderLog');			

			$this->messenger = $this->_helper->_flashMessenger;
		}
		
		public function preDispatch()
		{
		$_SESSION['clubUsername'] = 'uofmballroom';
			$this->auth=Zend_Auth::getInstance();
			if($this->auth->hasIdentity())
			{
				if($this->auth->getIdentity()->user_type =='member')
				{
					
					//echo "you are a buyer";
					$this->view->userType = 'buyer';
					
				
				}
				elseif($this->auth->getIdentity()->user_type =='clubAdmin')
				{
					//echo "you are a seller";
					$this->view->userType = 'seller';
					
					//purelly for template use only.
					//echo "status is: ".$this->auth->getIdentity()->status;	
				}
				
				
				$this->view->authenticated = true;
				
				$signedInUser = new DatabaseObject_User($this->db);
				if($signedInUser->loadByUserId($this->auth->getIdentity()->userID))
				{
				$this->view->identity=$signedInUser; //the value in idenity is passed into the page that called it. 
				}
			}
			else
			{
				$this->view->authenticated = false;
			}
			
			//$this->universityList = DatabaseObject_StaticUtility::loadUniversities($this->db);
			
			//$this->view->universitylist = $this->universityList;
			
			
			unset($_COOKIE['cartID']);
			
			//-------------------shopping cart material-------------------------
			$this->shoppingCart = new DatabaseObject_ShoppingCart($this->db);
			
			//$this->cartID = $this->shoppingCart->getCartID();
		
		//this loads a order, if that order exists then the corresponding shopping cart will be deleted!___---------------------------must add back to real lauch------------
		//-------------------------------------------------------------
			$tempOrder = new DatabaseObject_Order($this->db);
			
			if($tempOrder->loadOrderByUrl($this->shoppingCart->getCartID()))
			{
				
				
				$this->shoppingCart->deleteShoppingCart($this->shoppingCart->getCartID());
				$this->shoppingCart = new DatabaseObject_ShoppingCart($this->db);
			}
		//---------------------------------------------------------------------
		
		
			if($this->shoppingCart->loadCartOnly($this->shoppingCart->getCartID()))
			{
				$this->checkoutCartID = $this->shoppingCart->getCartID();
				$this->view->cartID = $this->shoppingCart->getCartID();
				$this->cartObject=DatabaseObject_ShoppingCart::loadCart($this->db, $this->shoppingCart->getCartID());
			
				//echo "here";
				if(count($this->cartObject)>0)
				{
					
				//echo "here at count object: ".count($this->cartObject);
					$this->view->cartObject = $this->cartObject;
				
					$this->view->total = DatabaseObject_ShoppingCart::getTotalAmount($this->db, $this->shoppingCart->getCartID());
				//}
				//Zend_Debug::dump($this->cartObject);
				}
			}
			
			
			if(isset($_SESSION['guestSignIn']))
			{
				$guest = new DatabaseObject_Guest($this->db);
				$guest->loadByID($_SESSION['guestSignIn']);
				$this->view->signInAsGuest='true';
				$this->view->guest = $guest;
			}
			
			//-----------------------check to see if order needs to be created----
			
			
			
			
			
			
			//--------------------------alphabetic links-------------------------------
			
			$this->alphabetLink = array('a' => '', 
							 'b' => '',
							 'c' => '',
							 'd' => '',
							 'e' => '',
							 'f' => '',
							 'g' => '',
							 'h' => '',
							 'i' => '',
							 'j' => '',
							 'k' => '',
							 'l' => '',
							 'm' => '',
							 'n' => '',
							 'o' => '',
							 'p' => '',
							 'q' => '',
							 'r' => '',
							 's' => '',
							 't' => '',
							 'u' => '',
							 'v' => '',
							 'w' => '',
							 'x' => '',
							 'y' => '',
							 'z' => '');
							 
							 
			 $this->returnPage = $_SERVER['REQUEST_URI'];
			 
	
		
		}
		
		public function postDispatch()
		{
			$this->view->breadcrumbs = $this->breadcrumbs;
			$this->view->title=$this->breadcrumbs->getTitle();
			
			$this->view->messages=$this->messenger->getMessages();
			
			$this->view->isXmlHttpRequest=$this->getRequest()->isXmlHttpRequest();
		}
		
		public function getUrl($action=null, $controller=null)
		{
			$url = rtrim($this->getRequest()->getBaseUrl(), '/');
			$url .=$this->_helper->url->simple($action, $controller); //simple funciton does this.
			return $url;
		}
		
		public function getCustomUrl($options, $route=null)//first argument is the url parameter, and second argument is name of route. 
		{
			return $this->_helper->url->url($options, $route); //this returns a string. //check the zend framework on this url thing. 
		
		}
		
		public function sendJson($data) //this is a wrappe to Zend_json
		{
			$this->_helper->viewRenderer->setNoRender(); //no output here
			
			$this->getResponse()->setHeader('content-type','application/json');
			echo Zend_Json::encode($data);
		}
		
		 public function sanitize($value)
        {
            if (!$this->_sanitizeChain instanceof Zend_Filter) {
                $this->_sanitizeChain = new Zend_Filter();
                $this->_sanitizeChain->addFilter(new Zend_Filter_StringTrim())
                                     ->addFilter(new Zend_Filter_StripTags());
            }

            // filter out any line feeds / carriage returns
            $ret = preg_replace('/[\r\n]+/', ' ', $value);

            // filter using the above chain
            return $this->_sanitizeChain->filter($ret);
        }
	
		
	}

?>