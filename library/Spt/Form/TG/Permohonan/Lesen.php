<?php

class Spt_Form_TG_Permohonan_Lesen extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/permohonan/lesenbaru');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Maklumat Am
        //
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
        //Nama Lain
        $this->addElement(
                'ValidationTextBox',
                'othername',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
        //Tarikh Lahir
		$this->addElement(
                'DateTextBox',
                'birthdate',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
        //Umur
        $this->addElement(
                'ValidationTextBox',
                'age',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
        //Tempat Lahir
        $this->addElement(
                'ValidationTextBox',
                'birthplace',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		//Negeri
		$state = new State();
        $stateOptions = $state->getStateOptions();
        $stateMultiOptions = array($translate->_('[--Sila Pilih Negeri--]')) + $stateOptions;

        $this->addElement(
                'select',
                'state',
                array(
                    'decorators' => $this->_standardRadioElementDecorator,
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($stateOptions))
                    ),
                    'multioptions'   => $stateMultiOptions,
                )
            );
        //Jantina
        $this->addElement(
                'RadioButton',
                'gender',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Lelaki'),
                        '2' => $translate->_('Perempuan')
                    ),
					'required'       => true,
                )
            );
        //Taraf Perkahwinan
        $this->addElement(
                'RadioButton',
                'maritalstatus',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Lelaki'),
                        '2' => $translate->_('Perempuan')
                    ),
					'required'       => true,
                )
            );
        //Warganegara
        $this->addElement(
                'RadioButton',
                'jantina',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Warganegara'),
                        '2' => $translate->_('Bukan Warganegara')
                    ),
					'required'       => true,
                )
            );
        //No Sijil Kerakyatan
        $this->addElement(
                'ValidationTextBox',
                'nokerakyatan',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
        //No KP Lama/Baru / No Passport
		$this->addElement(
                'ValidationTextBox',
                'icno',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					//'regExp'         => '\d{12}',
					'invalidMessage' => 'No Kad Pengenalan Tidak Sah',
					'maxlength' => 12,
                )
            );
        //Warna KP
		$this->addElement(
                'ValidationTextBox',
                'iccolor',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
        //Tarikh Dikeluarkan
		$this->addElement(
                'DateTextBox',
                'issueddate',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
        //Tempat Dikeluarkan
		$this->addElement(
                'ValidationTextBox',
                'issuedlocation',
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
		//No Telefon (R)
		$this->addElement(
                'ValidationTextBox',
                'phoneno',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d{9}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
		//No Telefon (HP)
		$this->addElement(
                'ValidationTextBox',
                'mobileno',
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

        ////Maklumat Pekerjaan
        //
        //Pekerjaan Sekarang
		$this->addElement(
                'ValidationTextBox',
                'currentemployment',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
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
					'regExp'         => '\d{9}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
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