<?php 

class Spt_Form_ProfilPassword extends Spt_Form
{
	public function init()
    {
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		
		$this->setAction($front.'/user/profil/personal/tab/password');
        $this->setMethod('post');
		
		$this->addElement('password', 'oldpassword', array(
            'decorators' => $this->element2Decorators,
            'label' => 'Kata Laluan',
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 20,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => 'Ruangan Diperlukan'
            ),
            'validators' => array(
                array('StringLength', false, array(3,20))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
		
		$this->addElement('password', 'newpassword1', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 20,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'required' => 'true',
				'intermediateChanges' => 'false',
				'invalidMessage' => 'Ruangan Diperlukan'
            ),
            'validators' => array(
                array('StringLength', false, array(3,20))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
        
        $this->addElement('password', 'newpassword2', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 20,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'constraints' => "{'other': 'newpassword1'}",
				'validator' => 'confirmPassword',
				'intermediateChanges' => 'false',
				'required' => 'true',
				'invalidMessage' => 'Kata Laluan Tidak Sama'
            ),
            'validators' => array(
                array('StringLength', false, array(3,20))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
	}
}