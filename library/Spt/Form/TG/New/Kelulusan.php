<?php

class Spt_Form_TG_New_Kelulusan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/kelulusan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		 //Kelulusan
        $this->addElement(
                'RadioButton',
                'rad_kelulusan',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_(' Diluluskan'),
                        '2' => $translate->_(' Tidak Diluluskan')
                    ),
					'required'       => true,
					'separator' => '&nbsp;&nbsp;',
                )
            );
		
		//Tarikh Peraku
		$this->addElement(
			'DateTextBox',
			'appl_lulus_tkh2',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		$this->addElement(
			'Hidden',
			'usr_id',
			array(
			)
		);
		$this->addElement(
			'Hidden',
			'tg_no',
			array(
			)
		);
		$this->addElement(
			'Hidden',
			'tg_type_id',
			array(
			)
		);
		$this->addElement(
			'Hidden',
			'appl_id',
			array(
			)
		);
		
		//Tarikh Peraku
		$this->addElement(
			'DateTextBox',
			'appl_lulus_tkh',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
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