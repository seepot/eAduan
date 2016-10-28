<?php

class ZFBlog_Form_AuthorLogin extends ZFBlog_Form
{

    public function init()
    {
    	
    	$this->setAction('/authentication/login');

        // Display Group #1 : Credentials

        $this->addElement('text', 'name', array(
            'decorators' => $this->_standardElementDecorator,
        	'filters' => array('StringTrim'),
            'required' => true,
        	'class' => 'input-text required-entry',
        	'size' => '50',
            'label' => 'ID Pengguna'
        ));

        $this->addElement('password', 'password', array(
            'decorators' => $this->_standardElementDecorator,
        	'filters' => array('StringTrim'),
            'required' => true,
        	'class' => 'input-text required-entry',
        	'size' => '50',
        	//'errors' => array('class'=>'validation-failed'),
            'label' => 'Katalaluan'
        ));

        $this->addDisplayGroup(
            array('name', 'password'), 'authorlogin',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_yusriGroupDecorator
            	//'class' => 'form-list'
                //'legend' => 'Daftar Masuk'
            )
        );

        // Display Group #2 : Submit

        $this->addElement('submit', 'submit', array(
            'decorators' => $this->_buttonElementDecorator,
            'label' => 'Login',
        	'class' => 'form-button'
        ));
		
        
        $this->addDisplayGroup(
            array('submit'), 'authorloginsubmit',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_yusriGroupDecorator
            )
        );
		
    }

}