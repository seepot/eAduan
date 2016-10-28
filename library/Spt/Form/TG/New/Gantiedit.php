<?php

class Spt_Form_TG_New_Gantiedit extends Spt_Form_TG_New_Ganti
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=am');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        
        //Maklumat Am
      

        //Tarikh Lahir
		$this->addElement(
                'DateTextBox',
                'tarikh',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );

        //Jantina
        $this->addElement(
                'RadioButton',
                'sebab',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Rosak'),
                        '2' => $translate->_('Hilang')
                    ),
					'required'       => true,
                )
            );
       
			

        ////Maklumat Pekerjaan
        //
        //Pekerjaan Pendidikan

		///
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		

    }
}
?>