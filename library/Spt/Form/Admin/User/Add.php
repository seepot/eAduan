<?php 

class Spt_Form_Admin_User_Add extends Zend_Dojo_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
		//setting environment
		$this->setAction(SYSTEM_URL.'/admin/user/add');
		$this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddUserForm',
        ));
		//role pengguna dalaman
		$translate = Zend_Registry::get ( 'translate' );
		$roleDalaman = new AclRole();
        $roleDalamanOptions = $roleDalaman->getRoleDalamanOptions();
        $roleDalamanMultiOptions = array($translate->_('[--Sila Pilih Kumpulan Pengguna--]')) + $roleDalamanOptions;
		
		//role pengguna luaran
		$role = new AclRole();
        $roleOptions = $role->getRoleNameOptions();
        $roleMultiOptions = array($translate->_('[--Sila Pilih Kumpulan Pengguna--]')) + $roleOptions;
		/* 
		$this->addElement('ValidationTextBox', 'name', array(
			'decorators' => $this->element2Decorators,
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'label'          => 'Name',
            'required'       => true,
            'invalidMessage' => 'Please type your name.',
            'trim'      => true,
        ));
 */
	
		//Nama
		$this->addElement(
                'ValidationTextBox',
                'realname',
                array(
                    //'label'      => 'Nama',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',

                )
            );
		
		//No Kad Pengenalan
		$this->addElement(
                'ValidationTextBox',
                'nokp',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d{12}',
					'invalidMessage' => 'No Kad Pengenalan Tidak Sah',
					'maxlength' => 12,
					'setErrors' => 'The input is invalid. The value must have only alphabetic characters and spaces and its length must be between 3 and 50 characters.'

                )
            );	
		
		//Email
		$this->addElement(
                'ValidationTextBox',
                'email',
                array(
					'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
					'validators' => array(
						'EmailAddress',
					),
                )
            );
		
		//Tarikh Lahir
		$this->addElement(
                'DateTextBox',
                'date_bday',
                array(
					'invalidMessage' => 'Invalid date specified.',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
		//ID Pengguna
		$this->addElement(
                'ValidationTextBox',
                'username',
                array(
					'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '[\w]+',
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		//Password 1
		$this->addElement(
			'PasswordTextBox',
			'password',
			array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'regExp'         => '^[a-z0-9]{6,}$',
				'invalidMessage' => 'Invalid password; ' .
									'must be at least 6 alphanumeric characters',
			)
		);

		//Password 2
		$this->addElement(
			'PasswordTextBox',
			'password2',
			array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'regExp'         => '^[a-z0-9]{6,}$',
				'invalidMessage' => 'Invalid password; ' .
									'must be at least 6 alphanumeric characters',
			)
		);
		
		//Kumpulan Pengguna
		$this->addElement(
                'FilteringSelect',
                'roledalaman',
                array(
                    'autocomplete' => true,
					'validators' => array(
						new Zend_Validate_InArray(array_keys($roleDalamanOptions))
					),
                    'multiOptions' => $roleDalamanMultiOptions,
                )
            );
		
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
					'class' => 'input-control select size3'
                )
            );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		)); 
		
		$this->setDecorators(array(
				'FormElements',                       
				array(array('data'=>'HtmlTag'),
				array('tag'=>'table','cellspacing'=>'14')),
				'DijitForm'
		));
		//$this->clearDecorators();
		 //$this->setDecorators(array('FormElements','Form'));
    }
	
}

?>