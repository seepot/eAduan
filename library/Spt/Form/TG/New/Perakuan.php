<?php

class Spt_Form_TG_New_Perakuan extends Zend_Dojo_Form
{
    public function init()
    {
         parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		//$this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=perakuan');
        $this->setAction(SYSTEM_URL.'/tg/new/applynew/id/'.$id.'/currtab/perakuan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: Perakuan///////
        //
		//Rujukan 1
        //
        //Nama
		$this->addElement(
                'ValidationTextBox',
                'appl_ruj_name1',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					
                )
            );
		//Alamat
		$this->addElement(
                'Textarea',
                'appl_ruj_alamat1',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
        //Pekerjaan
        $this->addElement(
                'ValidationTextBox',
                'appl_ruj_pekerjaan1',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
                )
            );

       //Rujukan 2
        //
        //Nama
		$this->addElement(
                'ValidationTextBox',
                'appl_ruj_nama2',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
                )
            );
		//Alamat
		$this->addElement(
                'Textarea',
                'appl_ruj_alamat2',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
        //Pekerjaan
        $this->addElement(
                'ValidationTextBox',
                'appl_ruj_pekerjaan2',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
                )
            );
			
			
			
        //akui
        $this->addElement(
                'Checkbox',
                'appl_perakuan',
                array(
                    'required'      => true,
					'invalidMessage'=> 'Diperlukan',
					'checkedValue'	=> true,
					'uncheckedValue'=> false,
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