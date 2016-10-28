<?php 

class Spt_Form_Bp_FeedbackAdd extends Zend_Dojo_Form
{
	public function init()
    {
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$this->setAction(SYSTEM_URL.'/bp/feedback/add/');
		$this->setMethod('post');
		
		//Feedback
		$this->addElement(
                'Textarea',
                'feedback',
                array(
                    'style'    => 'width: 500px;',
                )
            );
		
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
	}
}