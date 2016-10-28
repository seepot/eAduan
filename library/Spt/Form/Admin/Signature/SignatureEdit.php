<?php 

class Spt_Form_Admin_Signature_SignatureEdit extends Spt_Form_Admin_Signature_SignatureAdd
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		parent::init();
		$this->setAction($front.'/admin/signature/edit');
        $this->setMethod('post');
		
		$this->addElement('hidden', 'sig_id', array(
            'decorators' => $this->element2Decorators,
            'label' => 'ID Tandatangan',
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