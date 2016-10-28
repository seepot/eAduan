<?php 

class Spt_Form_Admin_Acl_ResourceAdd extends Zend_Dojo_Form
{
	public function init()
    {
        //get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$this->setAction(SYSTEM_URL.'/admin/acl/resource_add');
		$this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddResourceForm',
        ));
		
		//module
		$module = new Module();
        $moduleOptions = $module->getModuleOptions();
        $moduleMultiOptions = array($translate->_('[--Pilih--]')) + $moduleOptions;
		
		//Resources
		$this->addElement(
                'ValidationTextBox',
                'resources',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 40,
					'validators' => array(
						array('StringLength', false, array(2,50))
					),
                )
            );
		
		//Keterangan Resources
		$this->addElement(
                'Textarea',
                'desc',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 40,
					'validators' => array(
						array('StringLength', false, array(3,50))
					),
					'style'    => 'width: 500px;',
                )
            );
		
		//Module
		$this->addElement(
                'FilteringSelect',
                'module',
                array(
                    'autocomplete'=>'true',
					'onChange' => 'setVal1',
					'validators' => array(
						new Zend_Validate_InArray(array_keys($moduleOptions))
					),
                    'multiOptions' => $moduleMultiOptions,
                )
            );
		
		//Status
        $this->addElement(
                'RadioButton',
                'show',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Ya'),
                        '0' => $translate->_('Tidak'),
                    ),
					'required'       => true,
                )
            );
        
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
    }
	
}

?>