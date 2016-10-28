<?php

class Spt_Form_Test extends Spt_Dojo_Form
{
    public function init()
    {
        $this->setName('myForm');
 
        $this->addElement('ValidationTextBox', 'name', array(
            'validators' => array(
                array('StringLength', false, array(0, 255)),
            ),
            'label'          => 'Name',
            'required'       => true,
            'invalidMessage' => 'Please type your name.',
            'trim'      => true,
        ));
 
 
        $this->addElement('SubmitButton', 'submitButton',
            array(
                'required'   => false,
                'ignore'     => true,
                'label'      => 'Save'
            )
        );
    }
}