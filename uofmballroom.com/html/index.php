<?php
/*-------------------------SETUP---------------------------------
*first create the right folders
*second install the zend framework
*put the right settings in apache's httpd.conf and php.ini 
*third set smarty and change view rendering up the template system 
	 because zend uses its own template system
     or you will receive errors
*fourth make sure all the right template are put into the right
     controller folder.
	 
NOTE: Zend required very detailed file structuring, 
		strick naming conventions
---------------------------------------------------------------------*/
///*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


ini_set(include_path, "/home/uofmballroom/uofmballroom.com/html/include");
//echo "heloo there";

error_reporting(E_ALL);  
ini_set('display_startup_errors', 1);  
ini_set('display_errors', 1); 


define('EMAIL_FROM_NAME', 'uofmballroom-NO-REPLY');
define('EMAIL_FROM_EMAIL', 'uofmballroom-NO-REPLY@uofmballroom.com');
define( "PHP_SIMPLE_XLS_GEN", 1 );


require_once "Zend/Loader.php"; 
Zend_Loader::registerAutoload(); 

$logger = new Zend_Log(new Zend_Log_Writer_Null());

/*try{*/

	$writer=new EmailLogger('vinnivinsachi@gmail.com');
	$writer->addFilter(new Zend_Log_Filter_Priority(Zend_Log::WARN));
	$logger->addWriter($writer);

//registers the initial configuration of everything. 
$config = new Zend_Config_Ini('settings.ini', 'development');

//set the settings in registry as config
Zend_Registry::set('config', $config);

//configure database stuff given from the setttings.ini
$params = array('host'     => 'localhost',
				'username' => 'root',
				'password' => 'tangoschmango',
				'dbname'   => 'uofmballroom');

//I guess combining the type of sql with the informatin in params
$db = Zend_Db::factory("pdo_mysql", $params);

$db->getConnection();
//echo "you have good db!";

//setting the information in $db as db statically I think. 
Zend_Registry::set('db', $db);

/*$user = new DatabaseObject_User($db);
$user->username = 'chinamannnz';  //shove it inthe username colume. 
$user->password = '11141986'; //shove it in the password colume. 
$user->profile->first_name = 'Nian';
$user->profile->last_name='Zhang';
$user->save();
*/


///*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

$auth = Zend_Auth::getInstance();
$auth->setStorage(new Zend_Auth_Storage_Session());

//create the applicatin logger
$logger->addWriter( new Zend_Log_Writer_Stream($config->loggin->files));

$writer->setEmail($config->loggin->email);
	$writer->addFilter(new Zend_Log_Filter_Priority(Zend_Log::CRIT));
	$logger->addWriter($writer);

Zend_Registry::set('logger', $logger);

//$logger->crit('test message');

$orderLog = new Zend_log(new Zend_Log_Writer_Stream($config->order->files));
Zend_Registry::set('orderLog', $orderLog);


//starting to display shit and handlling user requests
$controller=Zend_Controller_Front::getInstance();

$controller->throwExceptions(true); 

$controller->setControllerDirectory($config->paths->base.'/include/Controllers');

//storing the $auth object in the application registry suing Zend_Reistry. 
$controller->registerPlugin(new CustomControllerAclManager($auth));


//setup the view renderer
$vr = new Zend_Controller_Action_Helper_ViewRenderer();
$vr->setView(new Templater());
$vr->setViewSuffix('tpl');
Zend_Controller_Action_HelperBroker::addHelper($vr);


//----------------------------------CLUB POST ACTIONS------------------------------------------
/*$route = new Zend_Controller_Router_Route('clubpreview/:username/*', array('controller'=>'clubpreview', 'action'=>'index'));
$controller->getRouter()->addRoute('clubpreview', $route); */

$route = new Zend_Controller_Router_Route('clubpost/:username/:action/*', array('controller'=>'clubpost', 'action'=>'index'));
$controller->getRouter()->addRoute('clubpost', $route);
   
//adding the club/username/view/:url
$route = new Zend_Controller_Router_route('clubpost/:username/view/:url/*', array('controller'=>'clubpost', 'action'=>'view'));

$controller->getRouter()->addRoute('clubpostview', $route); 

$route = new Zend_Controller_Router_route('clubpost/:username/archive/:year/:month/*', array('controller'=>'clubpost', 'action' =>'archive'));

$controller->getRouter()->addRoute('clubpostarchive', $route);

$route = new Zend_Controller_Router_route('clubpost/:username/tag/:tag/*', array('controller' => 'clubpost', 'action' => 'tag'));

$controller->getRouter()->addRoute('clubposttagspace', $route);



//----------------------------------CLUB PRODUCT ACTION----------------------------------------

$route = new Zend_Controller_Router_Route('clubproduct/:username/:action/*', array('controller'=>'clubproduct', 'action'=>'index'));
$controller->getRouter()->addRoute('clubproduct', $route);

$route = new Zend_Controller_Router_Route('clubproduct/:username/view/:url/*', array('controller'=>'clubproduct', 'action'=>'view'));
$controller->getRouter()->addRoute('clubproductview', $route); 

$route = new Zend_Controller_Router_Route('clubproduct/:username/archive/:year/:month/*', array('controller'=>'clubproduct','action'=>'archive'));
$controller->getRouter()->addRoute('clubproductarchive', $route);

$route = new Zend_Controller_Router_Route('clubproduct/:username/tag/:tag/*', array('controller'=>'clubproduct', 'action'=>'tag'));
$controller->getRouter()->addRoute('clubproducttagspace', $route);


//----------------------------------UMICH COMPETITION-------------------------------------------
$route = new Zend_Controller_Router_route('umichcompetition/:year/:info/*', array('controller'=>'umichcompetition', 'action'=>'index'));
$controller->getRouter()->addRoute('umichcompetition', $route);

//----------------------------------CLUB EVENT ACTION-------------------------------------------
$route = new Zend_Controller_Router_Route('registration/:action/*', array('controller'=>'clubevent', 'action'=>'index'));
$controller->getRouter()->addRoute('clubevent', $route);


$route = new Zend_Controller_Router_Route('registration/view/:url/*', array('controller'=>'clubevent', 'action'=>'view'));
$controller->getRouter()->addRoute('clubeventview', $route); 

$route = new Zend_Controller_Router_Route('registration/archive/:year/:month/*', array('controller'=>'clubevent','action'=>'archive'));
$controller->getRouter()->addRoute('clubeventarchive', $route);

$route = new Zend_Controller_Router_Route('registration/tag/:tag', array('controller'=>'clubevent', 'action'=>'tag'));
$controller->getRouter()->addRoute('clubeventtagspace', $route);



//----------------------------------CLUB MEMBERDUE ACTION-------------------------------------------


$route = new Zend_Controller_Router_Route('clubmemberdue/:memberusername/*', array('controller'=>'clubmemberdue', 'action'=>'index'));
$controller->getRouter()->addRoute('clubmemberdue', $route);

$route = new Zend_Controller_Router_Route('clubmemberdue/:memberusername/view/:url/*', array('controller'=>'clubmemberdue', 'action'=>'view'));
$controller->getRouter()->addRoute('clubmemberdueview', $route); 

/*$route = new Zend_Controller_Router_Route('clubmemberdue/:memberusername/individual/*', array('controller'=>'clubmemberdue',
'action'=>'individualdue'));

$controller->getRouter()->addRoute('clubmemberindividualdue', $route);

*/
$route = new Zend_Controller_Router_Route('clubmemberdue/:memberusername/archive/:year/:month/*', array('controller'=>'clubmemberdue','action'=>'archive'));
$controller->getRouter()->addRoute('clubmemberduearchive', $route);


$route = new Zend_Controller_Router_Route('clubmemberdue/:memberusername/tag/:tag/*', array('controller'=>'clubmemberdue', 'action'=>'tag'));
$controller->getRouter()->addRoute('clubmemberduetagspace', $route);


//----------------------------------MEMBERSHIPMANAGER ACTION-------------------------------------------


$route = new Zend_Controller_Router_Route('membershipmanager/:action/:memberusername/*', array('controller'=>'membershipmanager', 'action'=>'index'));

$controller->getRouter()->addRoute('membershipmanager', $route);

$route = new Zend_Controller_Router_Route('membershipmanager/memberpreview/:memberusername', array('controller'=>'membershipmanager', 'action'=>'memberpreview'));

$controller->getRouter()->addRoute('memberpreview', $route);

//----------------------------------INEDEX UNIVERSITY ACTION-------------------------------------------


/*$route = new Zend_Controller_Router_Route('index/university/:universityID/*', array('controller'=>'index', 'action'=>'university'));
$controller->getRouter()->addRoute('indexuniversity', $route);
*/
//-----------------------------------SHOPPING CART ACTIONS--------------------------------------

$route = new Zend_Controller_Router_Route('shoppingcart/:username/:producttype/:action/*', array('controller'=>'shoppingcart', 'action'=>'index'));

$controller->getRouter()->addRoute('shoppingcart', $route);


/*
$route = new Zend_Controller_Router_Route('memberpreview/:username', array('controller'=>'memberpreview', 'action'=>'index'));

$controller->getRouter()->addRoute('clubmemberpreview', $route);
*/


///*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



/*$route = new Zend_Controller_Router_Route('affiliationmanager/:username/:action/*', array('controller'=>'affiliationmanager', 'action'=>'index'));
$controller->getRouter()->addRoute('affiliationmanager', $route);*/

//-----------------------------------MESSAGING ACTIONS--------------------------------------

/*$route = new Zend_Controller_Router_Route('message/:action/:username/*', array('controller'=>'message', 'action'=>'index'));

$controller->getRouter()->addRoute('message', $route);
*/
/*
$route = new Zend_Controller_Router_Route('/lists/', '/include/lists');
$controller->getRouter()->addRoute('lists', $route);*/
///*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 

$controller->dispatch();
/*} catch(Exception $ex){

	$logger->emerg($ex->getMessage());
	 
	echo $ex->getMessage();
	header('location: /staticError.html'); 
	exit;

}*/

?>