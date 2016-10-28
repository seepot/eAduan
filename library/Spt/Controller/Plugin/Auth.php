<?php
 
class Spt_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		$userRoleId = Zend_Registry::get('userRoleId');
		$acl = My_Acl::getInstance();
		$request = $this->getRequest();
 
		if (!$acl->hasRole($userRoleId)) {
	  	    $error = "Sorry, the requested user role '".$userRoleId."' does not exist";									
	  	}
	  	if (!$acl->has($request->getModuleName().'_'.$request->getControllerName())) {
			$error = "Sorry, the requested controller '".$request->getControllerName()."' does not exist as an ACL resource";
 		}
		if (!$acl->isAllowed($userRoleId, $request->getModuleName().'_'.$request->getControllerName(), $request->getActionName())) {
			$error = "Sorry, the page you requested does not exist or you do not have access";
		}
 
		if (isset($error)) {
			Zend_Layout::getMvcInstance()->getView()->error = $error;
			$request->setControllerName('error');
			$request->setActionName('error');
			$request->setDispatched(false);
		}
 
    }
 
}