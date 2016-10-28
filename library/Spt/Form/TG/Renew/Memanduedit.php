<?php
class Spt_Form_TG_Renew_Memanduedit extends Spt_Form_TG_Renew_Memandu
{
	public function init()
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tg/renew/renewedit/id/'.$id.'/currtab/memandu');
		//$this->setAction(SYSTEM_URL.'/tg/renew/renew?currtab=memandu');
		$this->setMethod('post');

		$translate = Zend_Registry::get ( 'translate' );

		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));

		$this->setDecorators(array(
				'FormElements',
				array(array('data'=>'HtmlTag'),
				array('tag'=>'table','cellspacing'=>'4')),
				'DijitForm'
		));

	}	
}
?>