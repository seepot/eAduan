<?php

class Spt_Form_PPP_Pengkelasan_KeputusanPanel extends Zend_Dojo_Form
{
    protected $_id;
	public function init()
    {
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $cls = Zend_Controller_Front::getInstance()->getRequest()->getParam('cls');
		$this->_id = $id;
		$this->setAction(SYSTEM_URL.'/ppp/classification/panel/cls/'.$cls);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
    
		// Keputusan
		$this->addElement(
				'RadioButton',
				'panel_decision',
				array(
					'multiOptions'  => array(
						1 => 'Setuju',
						0 => 'Tidak Setuju',
					),
					//'value' => 0,
					'required' => true,
					'separator' => '&nbsp;&nbsp;',
				)						
			); 
		// Comment
		$this->addElement(
                'Textarea',
                'panel_comment',
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