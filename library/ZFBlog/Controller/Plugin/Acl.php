<?php

class ZFBlog_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

    protected $_auth = null;

    protected $_acl = null;

    public function __construct(Zend_Auth $auth, Zend_Acl $acl)
    {
        $this->_auth = $auth;
        $this->_acl = $acl;
        
        //if($auth->hasIdentity())
        //	$this->_user = $this->_auth->getIdentity()->usr_id;
        //else
        //	$this->_user = "";
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        
    	// Before you lot start, this is the laziest possible
        // means of assigning roles. Hands up - I’m guilty!
        // Store to the Author table if you prefer.
        if ($this->_auth->hasIdentity()) {
            $role = 'user';
        	/*
            $this->_user = $this->_auth->getIdentity()->usr_id;        	
            if ($this->_acl->getrole($this->_user)){
        		$role = $this->_acl->getrole($this->_user);
            }
            else {
            	$role = 'guest';
            }*/
        } else {
        	$role = 'guest';
        }
       //$user = $request->getParam('user', null);
        // Mapping to determine which Resource the current
        // request refers to (really simple for this example!)
        $resource = $request->module."_".$request->controller;
		$privilege = $request->action;
        //echo "<pre>";
        //print_r($request);
        //echo "</pre>";
        
        if (!$this->_acl->has($resource)) {
            $resource = null;
        }
		//echo $role.$resource;
        // ACL Access Check
        if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
            if ($this->_auth->hasIdentity()) {
                // authenticated, denied access, forward to index
            	$request->setModuleName('admin');
                $request->setControllerName('index');
                $request->setActionName('noaccess');
            } else {
                // not authenticated, forward to login form
                $request->setModuleName('default');
                $request->setControllerName('authentication');
                $request->setActionName('login');
            }
        }
    }
}