<?php 

class Menu_MesejController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->view->translate = Zend_Registry::get ( 'translate' );	
		
		$defSession = Zend_Registry::get ( 'defSession' );
		if (isset($defSession->css))
		{
			$this->view->css = $defSession->css;
		}
		else{
			$this->view->css = 'gold';
		}
	}
}
