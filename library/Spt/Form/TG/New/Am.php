<?php

class Spt_Form_TG_New_Am extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
        $this->_id = $id;
		echo $this->_id;
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		//$this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=am');
        $this->setAction(SYSTEM_URL.'/tg/new/applynew/id/'.$id.'/currtab/am');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Maklumat Am
        //
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'appl_nama_penuh',
                array(
                    'value'      => Zend_Auth::getInstance()->getIdentity()->usr_fullname,
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
        //Nama Lain
        $this->addElement(
                'ValidationTextBox',
                'appl_nama_lain',
                array(
                    //'value'      => Zend_Auth::getInstance()->getIdentity()->usr_date_birth,
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
        //Tarikh Lahir
		$this->addElement(
                'DateTextBox',
                'appl_tkh_lahir',
                array(
					'value'	=>  $this->getRowUserDetail('usr_date_birth'),
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
			
        //Umur 
        $this->addElement(
                'ValidationTextBox',
                'appl_umur',
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
                'appl_tmpt_lahir',
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
                'FilteringSelect',
                'sta_id',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($stateOptions))
                    ),
					'value'			 => $this->getRowUserDetail('usr_state_primary'),
                    'multioptions'   => $stateMultiOptions,
                )
            ); 
			
        //Jantina
        $this->addElement(
                'RadioButton',
                'gender_id',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Lelaki'),
                        '2' => $translate->_('Perempuan')
                    ),
					'value'			 => $this->getRowUserDetail('usr_sex'),
					'required'       => true,
                )
            );
			
        //Taraf Perkahwinan
        $this->addElement(
                'RadioButton',
                'usrmrd_id',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Berkahwin'),
                        '2' => $translate->_('Belum Berkahwin')
                    ),
					'value'			 => $this->getRowUserDetail('usr_marital_status'),
					'required'       => true,
					//'separator' => '&nbsp'
                )
            );
			
        //Warganegara
        $this->addElement(
                'RadioButton',
                'nationality_id',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Warganegara'),
                        '2' => $translate->_('Bukan Warganegara')
                    ),
					'value'			 => $this->getRowUserDetail('usr_nationality'),
					'required'       => true,
                )
            );
			
        //No Sijil Kerakyatan
        $this->addElement(
                'ValidationTextBox',
                'appl_no_kerakyatan',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
        //No KP Lama/Baru / No Passport
		$this->addElement(
                'ValidationTextBox',
                'appl_kp_passport',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d{12}',
					'invalidMessage' => 'No Kad Pengenalan Tidak Sah',
					'maxlength' => 12,
                )
            );
			
        //Warna KP
		$this->addElement(
                'ValidationTextBox',
                'appl_warna_kp',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
        //Tarikh Dikeluarkan
		$this->addElement(
                'DateTextBox',
                'appl_kp_keluar_tkh',
                array(
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
			
        //Tempat Dikeluarkan
		$this->addElement(
                'ValidationTextBox',
                'appl_kp_keluar_tmpt',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
		//Alamat Rumah
		$this->addElement(
                'Textarea',
                'appl_alamat_rumah',
                array(
                    'value'	=>  $this->getRowUserDetail('usr_add_primary'),
                )
            );
			
		//Poskod
		$this->addElement(
                'ValidationTextBox',
                'appl_poskod',
                array(
                    'value'	=>  $this->getRowUserDetail('usr_poscode_primary'),
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
                'appl_tel_rumah',
                array(
                    'value'			 => $this->getRowUserDetail('usr_phone_no'),
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					//'regExp'         => '\d{10}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
			
		//No Telefon (HP)
		$this->addElement(
                'ValidationTextBox',
                'appl_tel_bimbit',
                array(
                    'value'			 => $this->getRowUserDetail('usr_mobile_no'),
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					//'regExp'         => '\d{10}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
			
		//Alamat untuk Dihubungi
		$this->addElement(
                'Textarea',
                'appl_alamat_lain',
                array(
                    //'style'    => 'width: 200px;',
                )
            );

        ////Maklumat Pekerjaan
        //
        //Pekerjaan Sekarang
		$this->addElement(
                'ValidationTextBox',
                'appl_pekerjaan',
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
                'appl_majikan_alamat',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
			
		//No Telefon Majikan
		$this->addElement(
                'ValidationTextBox',
                'appl_majikan_tel',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					//'regExp'         => '\d{9}',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
			
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		

    }
	
	public function getRowUserDetail($field = '')
	{
		$db = Zend_Registry::get ( 'db' );
		$rowuserdetail = $db->fetchRow(
			$db->select()
					->from(array('a' => 'sys_user_detail'),
						array(	'usr_date_birth','usr_religion', 'usr_sex', 'usr_nationality', 'usr_marital_status',
								'usr_education_level', 'usr_add_primary', 'usr_poscode_primary', 'usr_city_primary',
								'usr_state_primary', 'usr_country_primary', 'usr_phone_no', 'usr_mobile_no'))
					->where( 'usr_id = ?', $this->_id )
		);
		return $rowuserdetail[$field];
	}
}
?>