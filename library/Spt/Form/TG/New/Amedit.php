<?php
class Spt_Form_TG_New_Amedit extends Spt_Form_TG_New_Am
{
    public function init()
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tg/new/applyview/id/'.$id.'/currtab/am');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
    }
}
?>