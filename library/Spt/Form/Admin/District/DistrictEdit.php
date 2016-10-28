<?php 

class Spt_Form_Admin_District_DistrictEdit extends Spt_Form_Admin_District_DistrictAdd
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		parent::init();
		$this->setAction($front.'/admin/district/edit');
        $this->setMethod('post');
		
		$this->addElement('hidden', 'district_id', array(
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