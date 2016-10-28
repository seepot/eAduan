<?php

class Spt_Form_PPP_Pengkelasan_UlasanPSU extends Zend_Dojo_Form
{
    protected $_id;
	public function init()
    {
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $cls = Zend_Controller_Front::getInstance()->getRequest()->getParam('cls');
		$this->_id = $id;
		$this->setAction(SYSTEM_URL.'/ppp/classification/psu/cls/'.$cls);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
    
		// Comment
		$this->addElement(
                'Textarea',
                'psu_comment',
                array(
                    'style'  => 'width: 400px;',
                )
            );		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
	}
	
						
}

?>