<?php

class Spt_Form_Admin_Staff_Edit extends Spt_Form_Admin_Staff_Add
{
   
    public function init()
    {
        $translate = Zend_Registry::get ( 'translate' );
		/*
		$role = new AclRole();
        $roleOptions = $role->getRoleOptions();
        $roleMultiOptions = array($translate->_('[--Sila Pilih Kumpulan Pengguna--]')) + $roleOptions;
		*/
		//print_r($roleMultiOptions);
    	
    	parent::init();
        $this->setAction(SYSTEM_URL.'/admin/staff/edit');
       	$this->setMethod('post');
       	
        //ID Pengguna
		$this->addElement(
                'TextBox',
                'username',
                array(
					'readonly' => 'readonly',
                )
            );
        
		//Password 1
		$this->addElement(
			'PasswordTextBox',
			'password',
			array(
				'required'       => false,
			)
		);

		//Password 2
		$this->addElement(
			'PasswordTextBox',
			'password2',
			array(
				'required'       => false,
			)
		);
		
		//Status
        $this->addElement(
                'RadioButton',
                'status',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Aktif'),
                        '0' => $translate->_('Tidak Aktif'),
                    ),
					'required'       => true,
                )
            );
		/*
		//Kumpulan Pengguna
		$this->addElement(
                'FilteringSelect',
                'role',
                array(
                    'autocomplete' => true,
					'validators' => array(
						new Zend_Validate_InArray(array_keys($roleOptions))
					),
                    'multiOptions' => $roleMultiOptions,
                )
            );
		*/
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
   
}