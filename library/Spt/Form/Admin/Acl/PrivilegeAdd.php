<?php 

class Spt_Form_Admin_Acl_PrivilegeAdd extends Zend_Dojo_Form
{
	public function init()
    {
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$this->setAction(SYSTEM_URL.'/admin/acl/privilege_add');
		$this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddPrivilegeForm',
        ));
		
		//module
		$module = new Module();
        $moduleOptions = $module->getModuleOptions();
        $moduleMultiOptions = array('[--Pilih--]') + $moduleOptions;
		
		//Privilege
		$this->addElement(
                'ValidationTextBox',
                'privilege',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 40,
					'validators' => array(
						array('StringLength', false, array(3,50))
					),
                )
            );
		
		//Keterangan Privilege
		$this->addElement(
                'Textarea',
                'desc',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 40,
					'validators' => array(
						array('StringLength', false, array(3,100))
					),
					'style'    => 'width: 500px;',
                )
            );
		/*
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
		*/
		//Module
		$this->addElement(
                'FilteringSelect',
                'module',
				array(
					'required' => true,
					'storeId'     => 'moduleStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/admin/acl/modulex',
					),
					'dijitParams' => array(
						'searchAttr' => 'acl_module_name',
					),
					'attribs'	=> array(
						'onChange' => "dijit.byId('resource').query.acl_module_id = this.value || ' ';",
					),
				)
            );
		//Resource
		$this->addElement(
                'FilteringSelect',
                'resource',
                array(
					'required' => true,
					'query' => "{acl_module_id:' '}",
					'autocomplete' => true,
					'storeId' => 'resourceStore',
					'storeType' => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/admin/acl/resourcex',
					),
					'dijitParams' => array(
						'searchAttr' => 'acl_resource_name',
					),
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