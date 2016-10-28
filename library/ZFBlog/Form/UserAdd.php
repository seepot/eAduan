<?php

class ZFBlog_Form_UserAdd extends ZFBlog_Form
{
   
    public function init()
    {
        $this->setAction('/admin/user/add');

        // Display Group #1 : Entry Data
       
        $this->addElement('text', 'realname', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Real Name:',
            'attribs' => array(
                'maxlength' => 50,
                'size' => 50
            ),
            'validators' => array(
                array('StringLength', false, array(3,50))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
        
        $this->addElement('text', 'email', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Email:',
            'attribs' => array(
                'maxlength' => 30,
                'size' => 30
            ),
            'validators' => array(
                'EmailAddress',
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
        
        $this->addElement('text', 'username', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'User Name:',
            'attribs' => array(
                'maxlength' => 20,
                'size' => 20
            ),
            'validators' => array(
                array('StringLength', false, array(3,20))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
        
        $this->addElement('password', 'password', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Password:',
            'attribs' => array(
                'maxlength' => 20,
                'size' => 20
            ),
            'validators' => array(
                array('StringLength', false, array(3,20))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
        
        $this->addElement('hidden', 'hid', array(
            'decorators' => $this->_standardElementDecorator,
            ));
        
        /*
        $captcha_image = new Zend_Captcha_Image(array(
        		'name'=>'foo',
                'height'=>'50',
                'width'=>'150',
                'wordLen'=> '6',
                'expiration' => '60',
                'font'=>'fonts/DejaVuSansMono.ttf',
                //'imgDir'=>'images/captcha',
                //'imgUrl' => 'images/captcha',
                'fontSize' => '24',
                'class' => 'captcha' 
        ));
        
        $captcha_element = new Zend_Form_Element_Captcha(
        		'captcha',array(
        			'captcha' 	=> $captcha_image,
	        		//'decorators'=> $this->_standardElementDecorator,
		        	'label'     => 'Please enter the 5 letters displayed below:',
		            'required'  => true	)
        );
        
        $this->addElement($captcha_element, 'captcha2', array('decorators' => $this->_standardElementDecorator));
        */
        
        $this->addElement('captcha', 'captcha', array(
            //'decorators' => $this->_standardElementDecorator,
        	'label'      => 'Please enter the 5 letters displayed below:',
            'required'   => true,
            'captcha'    => array('captcha' => 'Image', 'wordLen' => 5, 
            		'timeout' => 10, 'dotNoiseLevel' => 40, 'lineNoiseLevel' => 3, 
            		'font' => 'fonts/DejaVuSansMono.ttf')
        ));
       	/*
        $this->addElement('text', 'date', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Date:',
            'attribs' => array(
                'maxlength' => 16,
                'size' => 16
            ),
            'value' => Zend_Date::now()->toString('yyyy-MM-dd HH:mm'),
            'validators' => array(
                array('Date', false, array('yyyy-MM-dd HH:mm', 'en'))
            ),
            'required' => true
        ));
       
        $this->addElement('textarea', 'entrybody', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Entry Body:',
            'filters' => array('HtmlBody'),
            'required' => true
        ));
       
        $this->addElement('textarea', 'entrybodyextended', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Extended Body:',
            'filters' => array('HtmlBody')
        ));
       */
        $this->addDisplayGroup(
            array('realname','username','password','email','hid','captcha'), 'entrydata',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Tambah Pengguna'
            )
        );
       
        // Display Group #2 : Submit

        $this->addElement('submit', 'submit', array(
            'decorators' => $this->_buttonElementDecorator,
            'label' => 'Simpan'
        ));

        $this->addDisplayGroup(
            array('submit'), 'entrydatasubmit',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_buttonGroupDecorator,
                'class' => 'submit'
            )
        );
    }
}