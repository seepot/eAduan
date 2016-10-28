<?php

class Spt_Form_TG_New_Perakuan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=perakuan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: Semakan///////

        //Catatan
		$this->addElement(
                'Textarea',
                'appl_semak_catatan',
                array(
                    'trim'       => true,
					
                )
            );
		//Disemak oleh
		$this->addElement(
                'Textarea',
                'appl_ruj_alamat1',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
        //Tarikh semak
        $this->addElement(
                'ValidationTextBox',
                'appl_ruj_pekerjaan1',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
                )
            );

       //Disahkan oleh
		$this->addElement(
                'ValidationTextBox',
                'appl_ruj_nama2',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
                )
            );
		//Tarikh sah
		$this->addElement(
                'Textarea',
                'appl_ruj_alamat2',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
        //Pengesyor
        $this->addElement(
                'ValidationTextBox',
                'appl_ruj_pekerjaan2',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
                )
            );
			
        $this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
    }
}
?>