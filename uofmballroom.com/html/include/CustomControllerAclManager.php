<?php
	//pg58
	class CustomControllerAclManager extends Zend_Controller_Plugin_abstract
	{
		// default  user role if not logged or (or invalid role found)
		private $_defaultRole = 'guest';
		
		//the action to dispatch if a user doesn't have sufficient privileges
		//which is directing to login specific areas. //ahah!!!!! here is the 
		//part that direct people to when they don't have sufficient privileges.
		private $_authController = array('controller' => 'account', 'action' => 'login');
		
		
		public function __construct(Zend_Auth $auth)
		{
			$this->auth = $auth;
			$this->acl = new Zend_Acl();
			
			//add the different user roles
			$this->acl->addRole(new Zend_Acl_Role($this->_defaultRole));
			$this->acl->addRole(new Zend_Acl_Role('member'));
			$this->acl->addRole(new Zend_Acl_Role('clubAdmin'));
			$this->acl->addRole(new Zend_Acl_Role('administrator'), 'member');
			
			//add the resources we want to have control over
			$this->acl->add(new Zend_Acl_Resource('account'));
			$this->acl->add(new Zend_Acl_Resource('shoppingcart'));
			$this->acl->add(new Zend_Acl_Resource('blogmanager'));
			$this->acl->add(new Zend_Acl_Resource('productmanager'));
			$this->acl->add(new Zend_Acl_Resource('clubmemberdue'));
			//$this->acl->add(new Zend_Acl_Resource('affiliationmanager'));
			$this->acl->add(new Zend_Acl_Resource('membershipmanager'));
			$this->acl->add(new Zend_Acl_Resource('memberpreview'));
			$this->acl->add(new Zend_Acl_Resource('ordermanager'));
			$this->acl->add(new Zend_Acl_Resource('message'));
			//$this->acl->add(new Zend_Acl_Resource('admin'));		
			$this->acl->add(new Zend_Acl_Resource('checkout'));
			$this->acl->add(new Zend_Acl_Resource('eventmanager'));
			$this->acl->add(new Zend_Acl_Resource('guestorder'));
			$this->acl->add(new Zend_Acl_Resource('inventory'));
			$this->acl->add(new Zend_Acl_Resource('mediamanager'));
			$this->acl->add(new Zend_Acl_Resource('onlineregistrations'));
			
			//allow access to everything for all users by default
			//except for the account management and administration areas
			$this->acl->allow();
			$this->acl->deny(null,'account');
			$this->acl->deny(null, 'eventmanager');
			$this->acl->deny(null, 'onlineregistrations');
			//$this->acl->deny(null, 'affiliationmanager');
			$this->acl->deny(null, 'memberpreview');
			//$this->acl->deny(null, 'clubmemberdue');
			$this->acl->deny(null, 'message');
			//$this->acl->deny(null, 'admin');
			$this->acl->deny(null,'blogmanager');
			$this->acl->deny(null, 'productmanager');
			$this->acl->deny(null, 'membershipmanager');
			$this->acl->deny(null, 'ordermanager');
			$this->acl->deny(null, 'checkout');
			$this->acl->deny(null, 'inventory');
			$this->acl->deny(null, 'mediamanager');
			
			//add an exception so guests can log in or register
			//in order to gain privilege 
			//first argument is the role, second is the resources, and third are the actions allowed in that resources
			$this->acl->allow('guest', 'account', array('registermember','login', 'fetchpassword', 'registercomplete', 'guest','logout'));
			//registerclub is disabled.
			//register is disabled. 
			//only registermember is not disabled.
			

			//allow member asscess to the acount managemen area
			$this->acl->allow('member', 'account');
			$this->acl->allow('member', 'checkout');
			$this->acl->allow('guest', 'checkout', array('ipn', 'guest', 'checkoutfinal','createorder'));
			
			//$this->acl->allow('guest', 'ordermanager', array('view'));
			//$this->acl->allow('member', 'affiliationmanager');
			$this->acl->allow('member', 'ordermanager');
			$this->acl->allow('member', 'message');
			$this->acl->deny('member', 'message', array('compose'));
			$this->acl->allow('clubAdmin', 'memberpreview');
			$this->acl->allow('clubAdmin', 'account');
			$this->acl->allow('clubAdmin', 'onlineregistrations');
			$this->acl->allow('clubAdmin', 'checkout');
			$this->acl->allow('clubAdmin', 'inventory');
			$this->acl->allow('clubAdmin', 'membershipmanager');
			$this->acl->allow('clubAdmin', 'ordermanager');
			$this->acl->allow('clubAdmin', 'message');
			$this->acl->allow('clubAdmin', 'eventmanager');
			$this->acl->allow('clubAdmin', 'blogmanager');
			$this->acl->allow('clubAdmin', 'productmanager');
			$this->acl->allow('clubAdmin', 'mediamanager');
			$this->acl->allow('guest','mediamanager',array('video')); 
			//allows administrators access to the admin area
			//$this->acl->allow('administrator', 'admin');
		}
		
		
		/**
		* preDispatch
		*
		* Before an actino is dispatched, check if the current user has sufficient privileges. If not, disptch the default action instead. 
		*
		* @param Zend_Controller_Request_Abstract $request
		*/
		public function preDispatch(Zend_Controller_Request_Abstract $request)
		{
			//check if a user is logged in and has a valid role,
			//otherwise, assign them the default role(guest)
			
			if($this->auth->hasIdentity()) //hasIdentity is a build in function in Zend in Auth. 
			{
				$role=$this->auth->getIdentity()->user_type;
				//echo "role1: ".$role;
			}
			else
			{
				$role=$this->_defaultRole;
				//echo "role2: ".$role;
			}	
			
			if(!$this->acl->hasRole($role)) //hasRole is a build in function in Zend
			{
				$role = $this->_defaultRole;
				//echo "default role: ".$role;
			}
			
			//the ACL resource is the requested controller name
			$resource = $request->controller;
			//echo "resources: ".$resource;
			
			//the ACL privilege is the requested action name
			$privilege = $request->action;
			//echo "privilege: ".$privilege;
			
			//if we havn't explicitly added the resource, check the default
			//global permissions
			if(!$this->acl->has($resource))
			{
				$resource = null;
			}
			
			//access denied - reroute the request to the default action handler
			if(!$this->acl->isAllowed($role, $resource, $privilege))
			{
				$request->setControllerName($this->_authController['controller']);
				$request->setActionName($this->_authController['action']);
			}
		}
				
	}
?>