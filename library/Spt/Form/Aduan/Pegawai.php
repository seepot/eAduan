<?php

class Spt_Form_Aduan_Pegawai extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/bpm/aduan/pegawai/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: am///////
        //
        //Kelulusan
        $this->addElement(
			'RadioButton',
			'chk_kelulusan',
			array(
				'multiOptions'  => array(
					1 => 'Diluluskan',
					0 => 'Tidak Diluluskan',
				),
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
			)						
		); 
		//Tahap Keutamaan
		$tahap = new Tahap();
        $tahapOptions = $tahap->getTahapOptions();
		
		$this->addElement(
			'RadioButton',
			'chk_tahap',
			array(
				'multiOptions'  => $tahapOptions,
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
			)						
		); 
		
		//Unit
		$this->addElement(
                'FilteringSelect',
                'sel_unit',
				array(
					'required' => true,
					'storeId'     => 'unitStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/bpm/aduan/bpm',
					),
					'dijitParams' => array(
						'searchAttr' => 'bpm_name',
					),
					'attribs'	=> array(
						'onChange' => "dijit.byId('sel_staf').query.jhev_unit = this.value || ' ';",
					),
				)
            );
		//Staf BPM
		$this->addElement(
                'FilteringSelect',
                'sel_staf',
                array(
					'required' => true,
					'query' => "{jhev_unit:' '}",
					'autocomplete' => true,
					'storeId' => 'userStore',
					'storeType' => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/bpm/aduan/stafbpm',
					),
					'dijitParams' => array(
						'searchAttr' => 'usr_id',
					),
                )
            );
		//Unit
		/*
		$unit = new Unit();
        $unitOptions = $unit->getUnitOptions();
        $unitMultiOptions = array('[--Sila Pilih--]') + $unitOptions;
		
		$this->addElement(
                'FilteringSelect',
                'sel_unit',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $unitMultiOptions,
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
		//Staf
		$staf = new Staf();
        $stafOptions = $staf->getStafOptions();
        $stafMultiOptions = array('[--Sila Pilih--]') + $stafOptions;
		
		$this->addElement(
                'FilteringSelect',
                'sel_staf',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $stafMultiOptions,
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
		*/
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
		
    }
	
}
?>