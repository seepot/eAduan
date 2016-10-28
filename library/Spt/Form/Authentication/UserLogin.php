<?php 

class Spt_Form_Authentication_UserLogin extends Zend_Dojo_Form
{
    public function init()
    {
        //setting environment
		$this->setAction(SYSTEM_URL.'/authentication/login');
		$this->setMethod('post');
		
        //Nama
		$this->addElement(
                'ValidationTextBox',
                'name',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
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
				'invalidMessage' => 'Diperlukan',
			)
		);
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
}

?>