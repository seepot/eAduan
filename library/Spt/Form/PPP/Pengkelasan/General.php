<?php

class Spt_Form_PPP_Pengkelasan_General extends Zend_Dojo_Form
{
    protected $_id;
	public function init()
    {
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $cls = Zend_Controller_Front::getInstance()->getRequest()->getParam('cls');
		$this->_id = $id;
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew/id/'.$id.'/cls/'.$cls);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
    
		//Butir2 pemberi maklumat	
		//Nama Pemberi Maklumat
		$this->addElement(
                'ValidationTextBox',
                'supplier_name',
                array(
                    'required'	=> true,
                )
            );

		// Jawatan 
		$this->addElement(
                'ValidationTextBox',
                'supplier_designation',
                array(
                    'required'	=> true,
                )
            );

		
		// Comment
		$this->addElement(
                'ValidationTextBox',
                'overall_comments',
                array(
                    'required'	=> true,
                )
            );		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
	}
	
						
}

?>