<?php

class Spt_Form_TG_New_Kemaskini extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=am'); 
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Kemaskini kad/lesen
        //
		//Tarikh kemaskini
		$this->addElement(
                'DateTextBox',
                'tarikhkemaskini',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
        //Jenis Kemaskini
        $this->addElement(
                'RadioButton',
                'jeniskemaskini',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Tukar Kawasan'),
                        '2' => $translate->_('Tambah Bahasa'),
                        '3' => $translate->_('Tukar Status')
                    ),
					'required'       => true,
                )
            );
        
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		

    }
}
?>