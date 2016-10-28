<?php

class Spt_Form_PPP_Pengkelasan_TarikhPemeriksaan extends Zend_Dojo_Form
{
    protected $_id;
	public function init()
    {
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $cls = Zend_Controller_Front::getInstance()->getRequest()->getParam('cls');
		$this->_id = $id;
		$this->setAction(SYSTEM_URL.'/ppp/classification/tarikh/cls/'.$cls);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
    
		//Tarikh Pemeriksaan
		$this->addElement(
			'DateTextBox',
			'checking_date2',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		$this->addElement(
			'DateTextBox',
			'checking_date',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);

		// Comment
		$this->addElement(
                'Textarea',
                'ulasan',
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