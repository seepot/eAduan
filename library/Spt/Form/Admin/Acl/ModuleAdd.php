<?php 

class Spt_Form_Admin_Acl_ModuleAdd extends Zend_Dojo_Form
{
	public function init()
    {
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$this->setAction(SYSTEM_URL.'/admin/acl/module_add');
		$this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddModuleForm',
        ));
		
		//Module
		$this->addElement(
                'ValidationTextBox',
                'module',
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
		
		//Keterangan Module
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