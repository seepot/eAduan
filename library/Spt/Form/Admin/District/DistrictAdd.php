<?php 

class Spt_Form_Admin_District_DistrictAdd extends Spt_Form
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/admin/district/add');
        $this->setMethod('post');
		
		$state = new State();
        $stateOptions = $state->getStateOptions();
        $stateMultiOptions = array($translate->_('[--Sila Pilih Negeri--]')) + $stateOptions;
		
		$this->addElement('select', 'negeri', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
        	'validators' => array(
                new Zend_Validate_InArray(array_keys($stateOptions))
            ),
            'multioptions'   => $stateMultiOptions,
        ));
        		
        $this->addElement('text', 'daerah', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 40,
				//'style' => 'width:20px',
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'validators' => array(
                array('StringLength', false, array(3,50))
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
        
		$this->addElement('radio', 'status', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
            'attribs' =>   array(
                                'id'=>'country_id',
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