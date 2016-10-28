<?php 

class Spt_Form_Admin_Masalah_Edit extends Spt_Form_Admin_Masalah_Add
{
	public function init()
    {
		parent::init();
		
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/masalah/edit/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
			
    }
}

?>