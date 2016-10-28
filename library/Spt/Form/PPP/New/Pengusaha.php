<?php

class Spt_Form_PPP_New_Pengusaha extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=pengusaha');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: pengusaha///////
        //
        //
        //Nama Pengusaha 
        $this->addElement(
                'ValidationTextBox',
                'pengusaha_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		//Alamat Pengusaha  
		$this->addElement(
                'Textarea',
                'pengusaha_address',
                array(
                    //'style'    => 'width: 200px;',
                )
            ); 
 
		//Poskod
		$this->addElement(
                'NumberTextBox',
                'pengusaha_postcode',
                array(
                    'trim'      => true,
					'required'  => true,
					'pattern'	=> '#',
					'invalidMessage' => 'Poskod Tidak Sah',
					'maxlength' => 5,
                )
            ); 
		//No Telefon
		$this->addElement(
                'NumberTextBox',
                'pengusaha_phone',
                array(
                    'trim'      => true,
					'required'	=> true,
					'pattern'	=> '#',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
		//No Faks
		$this->addElement(
                'NumberTextBox',
                'pengusaha_fax',
                array(
                    'trim'      => true,
					'required'	=> true,
					'pattern'	=> '#',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
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