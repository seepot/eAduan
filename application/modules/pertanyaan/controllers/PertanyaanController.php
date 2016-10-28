<?php 

class Pertanyaan_PertanyaanController extends Spt_Controller_Action
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
	
	//pertanyaan mula====================================================================
	public function pertanyaanAction()
	{
		$this->view->translate = $this->translate();
	}
	//pertanyaan tamat===================================================================

}
?>