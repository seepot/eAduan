<?php

class Spt_Form_Admin_User_Edit extends Spt_Form_Authentication_Register
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
        $this->setAction(SYSTEM_URL.'/admin/user/edit');
       	$this->setMethod('post');
       	
        //ID Pengguna
		$this->addElement(
                'TextBox',
                'username',
                array(
					'readonly' => 'readonly',
                )
            );
		//ID Pengguna
		$this->addElement(
                'TextBox',
                'user_id',
                array(
					'required' => false,
                )
            );
        
		//Password 1
		$this->addElement(
			'PasswordTextBox',
			'user_password1',
			array(
				'required'       => false,
			)
		);

		//Password 2
		$this->addElement(
			'PasswordTextBox',
			'user_password2',
			array(
				'required'       => false,
			)
		);
		
		//Status
        $this->addElement(
                'RadioButton',
                'status',
                array(
                    'decorators' => array(
        'ViewHelper',
        array('HtmlTag', array('tag' => '<div>')),
    ),
					'multiOptions'  => array(
                        '1' => $translate->_('Aktif'),
                        '0' => $translate->_('Tidak Aktif'),
                    ),
					'required'       => true,
					'separator' => '',
                )
				
            );
		//->setSeparator('  ');
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
		
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));*/
		$this->clearDecorators();
		$this->addDecorator('FormElements')
			->addDecorator('HtmlTag', array('tag' => '<ul>'))
			->addDecorator('Form');

		$this->setElementDecorators(array(
			'DijitElement',
				'Errors',
			array('Label', array('separator'=>'<blockquotes>:</blockquotes>')),
			
			
		));
    }
   
}