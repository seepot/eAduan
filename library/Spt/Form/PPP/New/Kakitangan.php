<?php

class Spt_Form_PPP_New_Kakitangan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=kakitangan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: kakitangan///////
        //
        //Bil Kakitangan Pengurusan 
		//
		//Warganegara  
		$this->addElement(
                'NumberTextBox',
                'management_staff_citizen',
                array(
                    'trim'       => true,
					'required'       => true,
					'pattern'	=> '#',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Bukan Warganegara  
		$this->addElement(
                'NumberTextBox',
                'management_staff_foreginer',
                array(
                    'trim'       => true,
					'required'       => true,
					'pattern'	=> '#',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            );
		//
        //Bil Kakitangan Sokongan 
		//
		//Warganegara  
		$this->addElement(
                'NumberTextBox',
                'support_staff_citizen',
                array(
                    'trim'       => true,
					'required'       => true,
					'pattern'	=> '#',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Bukan Warganegara  
		$this->addElement(
                'NumberTextBox',
                'support_staff_foreigner',
                array(
                    'trim'       => true,
					'required'       => true,
					'pattern'	=> '#',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
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