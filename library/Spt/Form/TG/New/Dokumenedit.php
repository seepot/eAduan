<?php
class Spt_Form_TG_New_Dokumenedit extends Spt_Form_TG_New_Dokumen
{
	public function init()
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tg/new/applyview/id/'.$id.'/currtab/dokumen');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
	}
}
?>