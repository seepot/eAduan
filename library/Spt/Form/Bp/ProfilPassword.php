<?php 

class Spt_Form_Bp_ProfilPassword extends Zend_Dojo_Form
{
	public function init()
    {
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$this->setAction(SYSTEM_URL.'/bp/personal/password/');
		$this->setMethod('post');
		
		//Password Lama
		$this->addElement(
			'PasswordTextBox',
			'oldpassword',
			array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'invalidMessage' => 'Ruangan Diperlukan',
			)
		);

		//Password Baru 1
		$this->addElement(
			'PasswordTextBox',
			'newpassword1',
			array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'regExp'         => '^[a-z0-9]{6,}$',
				'invalidMessage' => 'Invalid password; ' .
									'must be at least 6 alphanumeric characters',
			)
		);
			
		//Password Baru 2
		$this->addElement(
			'PasswordTextBox',
			'newpassword2',
			array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'regExp'         => '^[a-z0-9]{6,}$',
				'invalidMessage' => 'Invalid password; ' .
									'must be at least 6 alphanumeric characters',
			)
		);
		
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
	}
}