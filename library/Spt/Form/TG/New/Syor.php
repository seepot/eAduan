<?php

class Spt_Form_TG_New_Syor extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/syor');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		//Catatan
		$this->addElement(
			'Textarea',
			'appl_syor_ulasan',
			array(
				'style'    => 'width: 400px;',
			)
		);
		
		//Tarikh Syor
		$this->addElement(
			'DateTextBox',
			'appl_syor_tkh2',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		//Tarikh Syor
		$this->addElement(
			'DateTextBox',
			'appl_syor_tkh',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		
		//Nama Peraku
		$this->addElement(
			'TextBox',
			'txtAkuName',
			array(
				'attribs' => array(
					'readonly' => 'readonly'
				),
			)
		);
		
		//Nama Pengesah
		$this->addElement(
			'Hidden',
			'txtAkuId',
			array(
			)
		);
		
		///
        $this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		
		
    }
}
?>