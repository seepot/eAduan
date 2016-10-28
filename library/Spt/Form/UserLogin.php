<?php 

class Spt_Form_UserLogin extends Spt_Form
{
    public function init()
    {
        $front = Zend_Controller_Front::getInstance(); 
		$this->setAction($front->getBaseUrl() .'/authentication/login');
        $this->setMethod('post');
 
        $this->addElement('text', 'name', array(
            'decorators' => $this->element2Decorators,
        	'filters' => array('StringTrim'),
            'required' => true,
        	'class' => 'inputbox',
        	'size' => '30',
			//'value' => 'Nama Pengguna',
			//'onfocus' => "if (this.value=='Nama Pengguna') this.value=''",
			//'onblur' => "if(this.value=='') { this.value='Nama Pengguna'; return false; }"
        ));

        $this->addElement('password', 'password', array(
            'decorators' => $this->element2Decorators,
        	'filters' => array('StringTrim'),
            'required' => true,
        	'class' => 'inputbox',
        	'size' => '30',
			//'value' => 'Katalaluan',
			//'onfocus' => "if (this.value=='Katalaluan') this.value=''",
			//'onblur' => "if(this.value=='') { this.value='Katalaluan'; return false; }"
        ));
 
        $this->addElement('button', 'submit', array(
            'decorators' => $this->buttonDecorators,
        	'type' => 'submit',
            'label' => 'Login',
        	'class' => 'scalable'
        ));
 
    }
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
            'Errors'
        ));
    }
}

?>