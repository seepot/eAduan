<?php

class Spt_Form_Aduan_Penyelia extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/bpm/aduan/penyelia/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Pengesahan
        $this->addElement(
			'RadioButton',
			'chk_pengesahan',
			array(
				'multiOptions'  => array(
					1 => 'Disahkan',
					0 => 'Tidak Disahkan',
				),
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
			)						
		); 
		//Catatan
		$this->addElement(
                'Textarea',
                'txt_catatan',
                array(
					'style'	=>	'width: 400px;'
                )
            );	
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		
		//Had Pelulus
		$this->addElement(
                'CurrencyTextBox',
                'txt_hadpelulus',
                array(
                    'value'      => Zend_Auth::getInstance()->getIdentity()->usr_fullname,
                    'trim'       => true,
					'currency'	=> 'RM ',
                )
            );
		

    }
	
	// public function getRowUserDetail($field = '')
	// {
		// $db = Zend_Registry::get ( 'db' );
		// $rowuserdetail = $db->fetchRow(
			// $db->select()
					// ->from(array('a' => 'sys_user_detail'),
						// array(	'usr_date_birth','usr_religion', 'usr_sex', 'usr_nationality', 'usr_marital_status',
								// 'usr_education_level', 'usr_add_primary', 'usr_poscode_primary', 'usr_city_primary',
								// 'usr_state_primary', 'usr_country_primary', 'usr_phone_no', 'usr_mobile_no'))
					// ->where( 'usr_id = ?', $this->_id )
		// );
		// return $rowuserdetail[$field];
	// }
}
?>