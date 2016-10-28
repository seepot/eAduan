<?php

class Spt_Form_PPP_New_Syarikat extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=syarikat');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: syarikat///////
        //
        //
        //No Pendaftaran 
        $this->addElement(
                'ValidationTextBox',
                'company_registration_no',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            ); 
		//Modal Dibenarkan
		$this->addElement(
                'NumberTextBox',
                'authorized_capital',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Berbayar 
		$this->addElement(
                'NumberTextBox',
                'paid_up_capital',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Bumiputera (RM)
		$this->addElement(
                'NumberTextBox',
                'capital_bumiputera',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Bumiputera Peratus 
		$this->addElement(
                'NumberTextBox',
                'capital_bumiputera_percentage',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Bukan Bumiputera (RM)
		$this->addElement(
                'NumberTextBox',
                'capital_non_bumiputera',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Bukan Bumiputera Peratus 
		$this->addElement(
                'NumberTextBox',
                'capital_non_bumiputera_percentage',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Warga Asing (RM)
		$this->addElement(
                'NumberTextBox',
                'capital_foreign',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Warga Asing Peratus 
		$this->addElement(
                'NumberTextBox',
                'capital_foreign_percentage',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Jumlah (RM)
		$this->addElement(
                'NumberTextBox',
                'capital_total',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
					'maxlength' => 12,
					'invalidMessage' => 'Nilai Tidak Sah',
                )
            ); 
		//Modal Jumlah Peratus 
		$this->addElement(
                'NumberTextBox',
                'capital_total_percentage',
                array(
                    'trim'      => true,
					'required'	=> true,
					'type'	=>	'decimal',
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