<?php
class Spt_Form_TG_Renew_Persatuanedit extends Spt_Form_TG_Renew_Persatuan
{
	protected $_id;
	
	public function init($id = 0)
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tg/renew/renewedit/id/'.$id.'/currtab/persatuan');
		//$this->setAction(SYSTEM_URL.'/tg/renew/renew?currtab=persatuan');
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