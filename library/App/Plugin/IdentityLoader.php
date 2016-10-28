<?php
/**
 * This loads a user identity to the request so access can be determined
 */
class App_Plugin_IdentityLoader extends Zend_Controller_Plugin_Abstract {
	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		//non-authed users are just anonymous users
		$user = new GuestUser();

		$auth = Zend_Auth::getInstance();
		
		if($auth->hasIdentity()) {
			$user = User::findById($auth->getIdentity()->usr_id);
			
		}
		//print_r($user);
		$request->setParam('user', $user);
	}
}