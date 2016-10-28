<?php 

class Spt_Form_Admin_State_StateEdit extends Spt_Form_Admin_State_StateAdd
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		parent::init();
		$this->setAction($front.'/admin/state/edit');
        $this->setMethod('post');
		
		$this->addElement('hidden', 'sta_id', array(
            'decorators' => $this->element2Decorators,
            'label' => 'ID Pengguna',
        	'class' => 'input-text required-entry',
        ));
	}
	
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
            'Errors'
        ));
    }
}

?>