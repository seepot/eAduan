<?php 

class Layout_AdminController extends Zend_Controller_Action
{
	public function headAction()
	{
		
		Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx4'
            )
        );
		
		$defSession = Zend_Registry::get ( 'defSession' );
		$this->view->role = $defSession->role;
		$this->view->request = $this->getRequest();
		$this->view->acl = My_Acl::getInstance();
		
		$this->view->translate = Zend_Registry::get ( 'translate' );	
    }
	
}