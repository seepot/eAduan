<?php
class App_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract {
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		if(!$this->_accessValid($request)) {
			//we throw an exception because the error controller
			//can easily handle these
			throw new App_Exception_AccessDenied('Access denied');
		}
	}

	private function _accessValid(Zend_Controller_Request_Abstract $request) {
		$user = $request->getParam('user', null);
		
		//the identityloader plugin should have added a user to
		//the request and if it doesn't exist something is wrong
		if($user === null)
			return false;

		$params = $request->getParams();
		$factory = new App_AclFactory();
		$resource = null;

		echo "<pre>";
		print_r($request->getParams());
		echo "</pre>";
		
		if(isset($params['file'])) {
			$resource = File::findById($params['file']);
			$acl = $factory->createFileAcl($resource, $user);
		}
		elseif(isset($params['category'])) {
			$resource = Category::findById($params['category']);
			$acl = $factory->createCategoryAcl($resource, $user);
		}
		else {
			//since we only care about access to files/categories,
			//we'll return true if those aren't being accessed
			return true;
		}

		return $acl->hasRole($user) && $acl->has($resource)
			&& $acl->isAllowed($user, $resource);
	}
}