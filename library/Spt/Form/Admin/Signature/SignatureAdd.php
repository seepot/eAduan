<?php 

class Spt_Form_Admin_Signature_SignatureAdd extends Spt_Form
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/admin/signature/add');
        $this->setMethod('post');
		
		$user = new SysUser();
        $userOptions = $user->getUserOptions();
        $userMultiOptions = array($translate->_('[--Sila Pilih Pengguna--]')) + $userOptions;
		
		$type = new SysType();
        $typeOptions = $type->getTypeOptions();
        $typeMultiOptions = array($translate->_('[--Sila Pilih Unit--]')) + $typeOptions;
		
		$this->addElement(
			'select', 
			'user', 
			array(
					'decorators' => $this->_standardRadioElementDecorator,
					'required'   => true,
					'validators' => array( 
											new Zend_Validate_InArray(array_keys($userOptions)) 
										),
					'attribs' =>   array(
										'invalidMessage' => $translate->_('Ruangan Diperlukan')
										),
            'multioptions'   => $userMultiOptions,
        ));
		
		$this->addElement('select', 'unit', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
        	'validators' => array(
                new Zend_Validate_InArray(array_keys($typeOptions))
            ),
            'multioptions'   => $typeMultiOptions,
        ));
        		
        $this->addElement('radio', 'status', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
            'attribs' =>   array(
                                'id'=>'aktif_id',
								'dojoType' => 'dijit.form.RadioButton'
                            ),
            'multioptions'   => array('1' => $translate->_('Aktif'), '0' => $translate->_('Tidak Aktif')),
        ));
		
        $this->addElement('button', 'submit', array(
            'decorators' => $this->button2Decorators,
            'label' => $translate->_('Simpan'),
        	'type' => 'submit',
        	'class' => 'scalable save'
        ));
        
        $this->addElement('button', 'reset', array(
            'decorators' => $this->button2Decorators,
            'label' => $translate->_('Semula'),
        	'type' => 'reset',
        	'class' => 'scalable'
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