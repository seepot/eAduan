<?php

class Spt_Form_Tempahan_ApplyNew extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tempahan/new/apply/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Maklumat Am
        //
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'txt_nama',
                array(
                    'value'      => Zend_Auth::getInstance()->getIdentity()->usr_fullname,
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
        //Jawatan
        $this->addElement(
                'ValidationTextBox',
                'txt_jawatan',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		//Bahagian/Cawangan
        $this->addElement(
                'ValidationTextBox',
                'txt_bahagian',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );	
		
		$date = (date('d')+3);
        //Tarikh Diperlukan
		$this->addElement(
                'DateTextBox',
                'date_tarikh_mula',
                array(
					'value'	=>  date('Y')."-".date('m')."-".$date,
					//'value'	=>  date('Y-m-d'),
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
					'attribs'	=>	array(
						'onChange'	=>	'func_checkdate(\'mula\');',
					),
                )
            );
		//Tarikh Diperlukan
		$this->addElement(
                'DateTextBox',
                'date_tarikh_tamat',
                array(
					'value'	=>  date('Y')."-".date('m')."-".$date,
					//'value'	=>  date('Y-m-d'),
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );	
		//Tarikh Diperlukan
		$this->addElement(
                'TimeTextBox',
                'time_masa_mula',
                array(
					'required'       => true,
					'visibleRange'       => 'T04:00:00',
					'visibleIncrement'   => 'T00:10:00',
					'clickableIncrement' => 'T00:10:00',
					'formatLength'   => 'short',
                )
            );
		//Masa Diperlukan
		$this->addElement(
                'TimeTextBox',
                'time_masa_tamat',
                array(
					'required'       => true,
					'visibleRange'       => 'T04:00:00',
					'visibleIncrement'   => 'T00:10:00',
					'clickableIncrement' => 'T00:10:00',
                )
            );
		//Tujuan
		$this->addElement(
                'Textarea',
                'txt_tujuan',
                array(
					'style'	=>	'width: 400px;'
                )
            );	
		//Bil peserta	
		$this->addElement(
				'NumberSpinner',
				'no_bil',
				array(
					'smallDelta'        => 1,
					'largeDelta'        => 10,
					'defaultTimeout'    => 1000,
					'timeoutChangeRate' => 100,
					'min'               => 0,
					'max'               => 10000,
					'places'            => 0,
					'maxlength'         => 2,
					'style'    			=> 'width: 100px;',
					'value' 			=> 0
				)
			);
		//Pengerusi
        $this->addElement(
                'ValidationTextBox',
                'txt_pengerusi',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
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