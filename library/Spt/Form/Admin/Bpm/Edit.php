<?php 

class Spt_Form_Admin_Bpm_Edit extends Spt_Form_Admin_Bpm_Add
{
	public function init()
    {
		parent::init();
		
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/unitbpm/edit/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
			
    }
}

?>