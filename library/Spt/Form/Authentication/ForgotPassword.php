<?php 

class Spt_Form_Authentication_ForgotPassword extends Zend_Dojo_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
		//setting environment
		$this->setAction(SYSTEM_URL.'/authentication/forgotpassword');
		$this->setMethod('post');
	
		//Email
		$this->addElement(
                'ValidationTextBox',
                'txt_email',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
					'style' => 'width:300px',
                )
            );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
    }
	
}

?>