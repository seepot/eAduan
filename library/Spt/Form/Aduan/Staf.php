<?php

class Spt_Form_Aduan_Staf extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/bpm/aduan/staf/id/'.$id);
		$this->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('target',  'progressFrame');                
        $this->setAttrib('id', 'files-upload-form');  
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Status
        $status = new Status();
        $statusOptions = $status->getStatusOptions();
		
		/*$this->addElement(
			'RadioButton',
			'chk_status',
			array(
				'multiOptions'  => $statusOptions,
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
			)						
		); */
		$this->addElement(
                'FilteringSelect',
                'sel_status',
				array(
					'required' => true,
					'storeId'     => 'statusStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/bpm/aduan/status',
					),
					'dijitParams' => array(
						'searchAttr' => 'status_desc',
					),
				)
            );
			
		//Catatan
		$this->addElement(
                'Textarea',
                'txt_tindakan',
                array(
					'style'	=>	'width: 400px;'
                )
            );	
		
			
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		
		
		

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