<?php

class Spt_Form_Aduan_Baru extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		$jenis = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis');
        $this->setAction(SYSTEM_URL.'/bpm/aduan/add/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Maklumat Permohonan
        //
		// Country select using a lookup resource 
    /*$country = new Community_Resource_Country(); 
    $countrySelect = new Zend_Dojo_Form_Element_FilteringSelect('countryId');     
    $countrySelect->setLabel('Location') 
         ->setRequired(true); 
    $countrySelect->addMultiOption('', ''); 
    foreach ($country->getLookup() as $c) { 
      $countrySelect->addMultiOption($c->countryId, $c->name); 
    } 
    // IMPORTANT:  Whenever the country is changed, the data store 
    // for the dependent city select should also change 
    $countrySelect->setAttrib('onchange', 'dijit.byId("cityId").store = new dojo.data.ItemFileReadStore({ url: "/data/lookup/table/city/filterName/countryId/filterValue/" + dijit.byId("countryId").value });'); 
    $this->addElement($countrySelect); 
    */

   
		//Unit
		$unit = new Unit();
        $unitOptions = $unit->getUnitOptions();
		
		$this->addElement(
                'FilteringSelect',
                'sel_unit',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $unitOptions,
					'attribs'	=> array(
						'style' => 'width:300px',
						'onchange' => 'dijit.byId("sel_katmasalah").store = new dojo.data.ItemFileReadStore({ url: "/bpm/data/lookup/filterName/bpm_id/filterValue/" + dijit.byId("sel_unit").value });'
					),
                )
            );
			
		/*$this->addElement(
                'RadioButton',
                'rad_unit',
                array(
                    'multiOptions'  => $unitOptions,
					'required'       => true,
					'separator' => '<br/>'
					
                )
            );*/
		
		/*$city = new Community_Resource_City(); 
		$citySelect = new Zend_Dojo_Form_Element_FilteringSelect('cityId'); 
		$citySelect->setAutocomplete(true); 
		$citySelect->setLabel('City'); 
		$citySelect->setRequired(true); 
		$citySelect->setStoreId('city'); 
		$citySelect->setStoreType('dojo.data.ItemFileReadStore');  // important! 
		$this->addElement($citySelect);     */
	
	
		//Kategori Masalah
		
		$this->addElement(
                'FilteringSelect',
                'sel_katmasalah',
                array(
                    'autocomplete' => true,
					'storeid' => 'km_id',
					'storetype' => 'dojo.data.ItemFileReadStore',
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
		
		$problem = new Problem();
        $problemOptions = $problem->getProblemOptions();
        //$problemMultiOptions = array('[--Sila Pilih--]') + $problemOptions;
		
		//print_r($problemMultiOptions);
		/*$this->addElement(
                'FilteringSelect',
                'sel_katmasalah',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $problemOptions,
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );*/
		
		//Tarikh Masalah
		$this->addElement(
                'DateTextBox',
                'date_tarikhmasalah',
                array(
					'value'	=>  '',
					//'value'	=>  date('Y-m-d'),
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
		//Lokasi Masalah
		$lokasi = new Lokasi();
        $lokasiOptions = $lokasi->getLokasiOptions();
        $lokasiMultiOptions = array('[--Sila Pilih--]') + $lokasiOptions;
		
		$this->addElement(
                'FilteringSelect',
                'sel_lokasimasalah',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $lokasiMultiOptions,
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
		
		//Ringkasan Masalah
		$this->addElement(
                'SimpleTextarea',
                'txt_ringkasan',
                array(
					'style'    => 'width: 400px;',
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