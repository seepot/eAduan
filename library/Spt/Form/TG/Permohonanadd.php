<?php
class Spt_Form_TG_Permohonanadd extends Zend_Dojo_Form
{	
	public function init()
    {
		//setting environment
		$this->setAction(SYSTEM_URL.'/tg/renew');
		$this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddPermohonanForm',
        ));
		
		$translate = Zend_Registry::get ( 'translate' );
	
	//section: am	
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'realname',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		//Alamat Rumah
		$this->addElement(
                'Textarea',
                'homeaddress',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
		
		//Poskod
		$this->addElement(
                'ValidationTextBox',
                'postcode',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d{5}',
					'invalidMessage' => 'Poskod Tidak Sah',
					'maxlength' => 5,
                )
            );
		
		//No Telefon
		$this->addElement(
                'ValidationTextBox',
                'phoneno',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d{10}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
		
		//Alamat untuk Dihubungi
		$this->addElement(
                'Textarea',
                'contactaddress',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
		
		//Taraf Pekerjaan
        $this->addElement(
                'RadioButton',
                'workingstatus',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Sepenuh Masa'),
                        '2' => $translate->_('Sambilan'),
                        '3' => $translate->_('Bebas'),
                    ),
					'required'	=> true,
					'separator' => '&nbsp;'
                )
            );
		
		//Nama & Alamat Majikan 
		$this->addElement(
                'Textarea',
                'curretnemployer',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
		
		//No Telefon Majikan
		$this->addElement(
                'ValidationTextBox',
                'employerphoneno',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d{10}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
		
		//No Lesen
		$this->addElement(
                'ValidationTextBox',
                'nolesen',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
	//section: persatuan
		
		//Nama Persatuan
		$this->addElement(
                'ValidationTextBox',
                'persatuanname',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
		//Tarikh Menjadi Ahli
		$this->addElement(
                'DateTextBox',
                'joindate',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
			
		//Jawatan
		$this->addElement(
                'ValidationTextBox',
                'jawatan',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
	//section: kerja memandu pelancung
		
		//Anggaran bilangan kerja memandu
		$this->addElement(
                'NumberSpinner',
                'bilkerja',
                array(
                    'smallDelta'        => 1,
                    'largeDelta'        => 10,
                    'defaultTimeout'    => 1000,
                    'timeoutChangeRate' => 100,
                    'min'               => 0,
                    'max'               => 100,
                    'places'            => 0,
                    'maxlength'         => 2,
					'value' => 0,
					'attribs' => array(
						'onClick' => 'bilkerja_detail(this)',
						'onblur' => 'bilkerja_detail(this)'
					)
                )
            );
		
		//Sebab/Ulasan Tiada 
		$this->addElement(
                'Textarea',
                'sebabtiada',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
			
	//section: dokumen sokongan
		/*
		//Salinan Kad Pemandu Pelancong
        $this->addElement(
                'file',
                'fail_kadPemandu',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 102400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

       //Salinan kad pengenalan
        $this->addElement(
                'file',
                'fail_kadPengenalan',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 102400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

       //Salinan Resit keahlian Persatuan Pemandu Pelancong
        $this->addElement(
                'file',
                'fail_resitKeahlian',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 102400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		*/
        //Jenis Lesen Pemandu Pelancong dan Tempoh Pembaharuan
        $this->addElement(
                'RadioButton',
                'jenistempohrenewal',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('City Guide (1 Tahun)'),
                        '2' => $translate->_('City Guide (2 Tahun)'),
                        '3' => $translate->_('Nature Guide (1 Tahun)'),
                        '4' => $translate->_('Nature Guide (2 Tahun)'),
                    ),
					'required'       => true,
                )
            );
			
	//section: perakuan
		
		//Tarikh Tamat Lesen
		$this->addElement(
                'DateTextBox',
                'lesenexp',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
		
		
		
		
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
		$this->setDecorators(array(
				'FormElements',                       
				array(array('data'=>'HtmlTag'),
				array('tag'=>'table','cellspacing'=>'4')),
				'DijitForm'
		));
		
	}	
	
}	
?>