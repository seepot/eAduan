<?php
 
class My_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    protected $_auth = null;

    protected $_acl = null;
    
	public function __construct(Zend_Auth $auth, Zend_Acl $acl)
    {
        $this->_auth = $auth;
        $this->_acl = $acl;        
    }
    
	public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	/* echo "<pre>";
		print_r($this->_auth);
		echo "</pre>"; */
		if ($this->_auth->hasIdentity()) {      	
            $this->_user = $this->_auth->getIdentity()->usr_id;        	
            if ($this->_acl->getrole($this->_user)){
        		$userRoleId = $this->_acl->getrole($this->_user);
            }
            else {
            	$userRoleId = '1';
            }
        } else {
        	$userRoleId = '1';
        }
		$acl = My_Acl::getInstance();
		$request = $this->getRequest();
		
		//echo $request->getModuleName().'_'.$request->getControllerName().' '.$request->getActionName();
		
		if($userRoleId <> 2){
			if (!$acl->hasRole($userRoleId)) {
				$error = "Sorry, the requested user role '".$userRoleId."' does not exist";									
			}
			if (!$acl->has($request->getModuleName().'_'.$request->getControllerName())) {
				$error = "Sorry, the requested controller '".$request->getControllerName()."' does not exist as an ACL resource";
			}
			if (!$acl->isAllowed($userRoleId, $request->getModuleName().'_'.$request->getControllerName(), $request->getActionName())) {
				$error = "Sorry, the page you requested does not exist or you do not have access";
			}
 		}
		if (isset($error)) {
			Zend_Layout::getMvcInstance()->getView()->error = $error;
			//$request->setControllerName('error');
			//$request->setActionName('error');
			//$request->setDispatched(false);
			$request->setModuleName('default');
            $request->setControllerName('error');
            $request->setActionName('error2');
		}
		
 
    }
 
}