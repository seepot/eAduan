<?php

class Spt_Form_TG_New_Semakan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/semakan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		//Catatan
		$this->addElement(
			'Textarea',
			'appl_semak_catatan',
			array(
				'style'    => 'width: 400px;',
			)
		);
		
		//Tarikh Semak
		$this->addElement(
			'DateTextBox',
			'appl_semak_tkh',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		//Tarikh Semak
		$this->addElement(
			'DateTextBox',
			'appl_semak_tkh2',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		
		//Nama Pengesah
		$this->addElement(
			'TextBox',
			'txtSahName',
			array(
				'attribs' => array(
					'readonly' => 'readonly'
				),
			)
		);
		
		//Nama Pengesah
		$this->addElement(
			'Hidden',
			'txtSahId',
			array(
			)
		);
		
		//Tarikh Sah
		$this->addElement(
			'DateTextBox',
			'appl_sah_tkh',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		
		//Nama Pengesyor
		$this->addElement(
			'TextBox',
			'txtSyorName',
			array(
				'attribs' => array(
					'readonly' => 'readonly'
				),
			)
		);
		
		//Nama Pengesyor
		$this->addElement(
			'Hidden',
			'txtSyorId',
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