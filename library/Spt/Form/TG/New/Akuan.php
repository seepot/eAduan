<?php

class Spt_Form_TG_New_Akuan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/perakuan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		//Catatan
		$this->addElement(
			'Textarea',
			'appl_peraku_perakuan',
			array(
				'style'    => 'width: 400px;',
			)
		);
		
		//Tarikh Peraku
		$this->addElement(
			'DateTextBox',
			'appl_peraku_tkh2',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		//Tarikh Peraku
		$this->addElement(
			'DateTextBox',
			'appl_peraku_tkh',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		
		//Nama Pegawai Lulus
		$this->addElement(
			'TextBox',
			'txtLulusName',
			array(
				'attribs' => array(
					'readonly' => 'readonly'
				),
			)
		);
		
		//Nama Pegawai Lulus
		$this->addElement(
			'Hidden',
			'txtLulusId',
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