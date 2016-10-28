<?php 

class Menu_ReportController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->view->translate = Zend_Registry::get ( 'translate' );	
		
		$defSession = Zend_Registry::get ( 'defSession' );
		$this->view->role = $defSession->role;
		$this->view->request = $this->getRequest();
		$this->view->acl = My_Acl::getInstance();
		
		if (isset($defSession->css))
		{
			$this->view->css = $defSession->css;
		}
		else{
			$this->view->css = 'gold';
		}
	}
}
