<?php

class Spt_Form_PPP_New_Premis extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=premis');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: premis///////
        //
        //
		//Jenis Premis
		$premis = new Premise();
        $premisOptions = $premis->getPremiseOptions();
        $premisMultiOptions = array($translate->_('[--Sila Pilih--]')) + $premisOptions;

        $this->addElement(
                'FilteringSelect',
                'premise_type_id',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($premisOptions))
                    ),
                    'multioptions'   => $premisMultiOptions,
                )
            );
        //Nama Premis
        $this->addElement(
                'ValidationTextBox',
                'premise_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		//Alamat Premis 
		$this->addElement(
                'Textarea',
                'premise_address',
                array(
                    'required'	=> true,
                )
            ); 
		//Negeri 
		/* $state = new State();
        $stateOptions = $state->getStateOptions();
        $stateMultiOptions = array($translate->_('[--Sila Pilih Negeri--]')) + $stateOptions;

        $this->addElement(
                'FilteringSelect',
                'premise_state_id',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($stateOptions))
                    ),
                    'multioptions'   => $stateMultiOptions,
                )
            );  */
		//Daerah
		/* $district = new District();
        $districtOptions = $district->getDistrictOptions();
        $districtMultiOptions = array($translate->_('[--Sila Pilih Daerah--]')) + $districtOptions;

        $this->addElement(
                'FilteringSelect',
                'premise_region_id',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($districtOptions))
                    ),
                    'multioptions'   => $districtMultiOptions,
                )
            );  */
		//Poskod
		$this->addElement(
                'NumberTextBox',
                'premise_postcode',
                array(
                    'trim'      => true,
					'required'  => true,
					'pattern'	=> '#',
					'invalidMessage' => 'Poskod Tidak Sah',
					'maxlength' => 5,
                )
            ); 
		//No Telefon
		$this->addElement(
                'NumberTextBox',
                'premise_phone',
                array(
                    'trim'      => true,
					'required'	=> true,
					'pattern'	=> '#',
					'invalidMessage' => 'No Telefon Tidak Sah',
					'maxlength' => 12,
                )
            );
		//No Faks
		$this->addElement(
                'NumberTextBox',
                'premise_fax',
                array(
                    'trim'      => true,
					'required'  => true,
					'pattern'	=> '#',
					'invalidMessage' => 'No Faks Tidak Sah',
					'maxlength' => 12,
                )
            );
		//Keterangan Premis 
		$this->addElement(
                'Textarea',
                'premise_description',
                array(
                    'required'	=> true,
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