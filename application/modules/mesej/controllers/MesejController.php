<?php 

class Mesej_MesejController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->_redirect('/admin/state/list');
	}
	
	public function listAction()
	{
		$this->view->translate = $this->translate();
	}
	
	public function addAction()
	{
		$this->view->translate = $this->translate();
	}


    public function viewAction()
    {
		$this->view->translate = $this->translate();
	}
   
	public function editAction()
    {
    	$this->view->translate = $this->translate();
    }
    
	public function deleteAction()
    {
    }
    
	protected function _repopulateForm($form, $item)
    {
    }
   
    protected function _reverseAutoFormat($string)
    {
    }
	
	//inbox mula====================================================================
	public function inboxAction()
	{
		$this->view->translate = $this->translate();
	}
	//inbox tamat===================================================================
	
	//inbox mula====================================================================
	public function outboxAction()
	{
		$this->view->translate = $this->translate();
	}
	//inbox tamat===================================================================
	
	//inbox mula====================================================================
	public function deletedAction()
	{
		$this->view->translate = $this->translate();
	}
	//inbox tamat===================================================================

}
?>