<?php 

class Spt_Form_Admin_Penganjur_PenganjurEdit extends Spt_Form_Admin_Penganjur_PenganjurAdd
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		parent::init();
		$this->setAction($front.'/admin/penganjur/edit');
        $this->setMethod('post');
		
		$this->addElement('hidden', 'p_id', array(
            'decorators' => $this->element2Decorators,
            'label' => 'ID Penganjur',
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