<?php

class IndexController extends Zend_Controller_Action
{
   
	public function indexAction()
    {
       /*  Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx'
            )
        ); */
		
		$this->view->title = 'New Framework';
        
        //$this->_redirect('/authentication/login');
		/*
     	if(Zend_Auth::getInstance()->getIdentity())
     	{
     		$this->_redirect('/admin');
     	}
     	else 
     	{
     		$this->_redirect('/authentication/login');
     	}
		*/
		//$url = Zend_Controller_Front::getInstance()->getRequest()->getParam('url');
		//if(isset($url)){
		//echo $url;
		//die();
		//}
		
		$defSession = Zend_Registry::get ( 'defSession' );
		$lang = Zend_Controller_Front::getInstance()->getRequest()->getParam('lang');
		if($lang <> ''){
			$defSession->lang = $lang;
			$this->_redirect('');
		}
		
		$css = Zend_Controller_Front::getInstance()->getRequest()->getParam('css');
		if($css <> ''){
			$defSession->css = $css;
			$this->_redirect('');
		}
		
		
		if(Zend_Auth::getInstance()->getIdentity())
     	{
     		 Zend_Layout::startMvc(
				array(
					'layoutPath' => SYSTEM_PATH . '/application/layouts',
					'layout' => 'adminx'
				)
			);
			$this->view->pages = SYSTEM_URL.'/admin';
     	}
     	else 
     	{
     		/* $this->_helper->layout->disableLayout(); */
			Zend_Layout::startMvc(
				array(
					'layoutPath' => SYSTEM_PATH . '/application/layouts',
					'layout' => 'login'
				)
			);
			$this->view->pages = SYSTEM_URL.'/authentication/login';
     	}
		
    }
   
}