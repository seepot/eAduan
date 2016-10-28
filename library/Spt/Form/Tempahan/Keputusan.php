<?php

class Spt_Form_Tempahan_Keputusan extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tempahan/new/kelulusan/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		$this->addElement(
			'RadioButton',
			'rad_keputusan',
			array(
				'multiOptions'  => array(
					1 => 'Diluluskan',
					0 => 'Tidak Diluluskan',
				),
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
			)						
		); 
		$this->addElement(
                'Textarea',
                'txt_ulasan',
                array(
					'style'	=>	'width: 400px;'
                )
            );	
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		

    }
	
}
?>