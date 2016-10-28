<?php

class Spt_Form_PPP_Pengkelasan_KelulusanSUB extends Zend_Dojo_Form
{
    protected $_id;
	public function init()
    {
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $cls = Zend_Controller_Front::getInstance()->getRequest()->getParam('cls');
		$this->_id = $id;
		$this->setAction(SYSTEM_URL.'/ppp/classification/sub/cls/'.$cls);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
    
		// Keputusan
		$this->addElement(
				'RadioButton',
				'sub_approval',
				array(
					'multiOptions'  => array(
						1 => 'Lulus',
						0 => 'Tidak Lulus',
					),
					//'value' => 0,
					'required' => true,
					'separator' => '&nbsp;&nbsp;',
				)						
			); 
		// Comment
		$this->addElement(
                'Textarea',
                'sub_comment',
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