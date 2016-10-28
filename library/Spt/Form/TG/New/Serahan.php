<?php

class Spt_Form_TG_New_Serahan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/serahan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		 //Kelulusan
        $this->addElement(
			'TextBox',
			'appl_serah_resit',
			array(
				'attribs' => array(
					
				),
			)
		);
		
		//Tarikh Serah
		$this->addElement(
			'DateTextBox',
			'appl_serah_tkh',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		
		$this->addElement(
			'TextBox',
			'appl_serah_usr_id',
			array(
				'attribs' => array(
					
				),
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