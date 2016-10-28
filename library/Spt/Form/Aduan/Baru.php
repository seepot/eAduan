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
		$this->setAttrib('enctype', 'multipart/form-data');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Maklumat Permohonan
        //
		
		
		//Unit
		$unit = new Unit();
        $unitOptions = $unit->getUnitOptions();
		
		$this->addElement(
                'FilteringSelect',
                'sel_unit',
				array(
					
					'storeId'     => 'stateStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/bpm/aduan/bpm2',
					),
					'dijitParams' => array(
						'searchAttr' => 'bpm_name',
					),
					'attribs'	=> array(
						'onChange' => "dijit.byId('sel_katmasalah').query.bpm_id = this.value || ' ';",
								//  dijit.byId('sel_katmasalah').attr('value', '');",
				//		'onchange' => 'dijit.byId("sel_katmasalah").store = new dojo.data.ItemFileReadStore({ url: "masalah" + dijit.byId("sel_unit").value });'
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
		
	
	
		//Kategori Masalah
		$this->addElement(
                'FilteringSelect',
                'sel_katmasalah',
                array(
                   //'query' => "{bpm_id:' '}",
				   'query' => "{bpm_id:' '}",
					'autocomplete' => true,
					'storeId' => 'kmId',
					'storeType' => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/bpm/aduan/masalah',
					),
					'dijitParams' => array(
						'searchAttr' => 'km_desc',
					),
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
		/*$this->addElement(
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
            );*/
		
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
		/*
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
		$this->addElement(
                'FilteringSelect',
                'sel_lokasimasalah',
				array(
					'required' => true,
					'storeId'     => 'unitStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => 'unit',
					),
					'dijitParams' => array(
						'searchAttr' => 'unit_desc',
					),
				)
            );*/
		
		$this->addElement(
                'ValidationTextBox',
                'sel_lokasimasalah',
                array(
                    'trim'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 50,
					'style' => 'width:400px',
					'validators' => array(
						array('StringLength', false, array(3,50))
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
	
}
?>