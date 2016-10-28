<?php 

class Spt_Form_Bp_ProfilPersonal extends Zend_Dojo_Form
{
	public function init()
    {
        //get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		if(Zend_Controller_Front::getInstance()->getRequest()->getParam('tab'))
			$tab = Zend_Controller_Front::getInstance()->getRequest()->getParam('tab');
		else
			$tab = 'personal';
			
		$this->setAction(SYSTEM_URL.'/bp/personal/profileedit/tab/'.$tab);
		$this->setMethod('post');
				
		//jantina
		$gender = new Gender();
        $genderOptions = $gender->getGenderOptions();
        $genderMultiOptions = array('[--Pilih--]') + $genderOptions;

		//agama
		$religion = new Religion();
        $religionOptions = $religion->getReligionOptions();
        $religionMultiOptions = array('[--Pilih--]') + $religionOptions;
		
		//bangsa
		$race = new Race();
        $raceOptions = $race->getRaceOptions();
        $raceMultiOptions = array('[--Pilih--]') + $raceOptions;
		
		//perkhidmatan
		//$service = new Service();
        //$serviceOptions = $service->getServiceOptions();
        //$serviceMultiOptions = array('[--Pilih--]') + $serviceOptions;
		
		//pangkat
		//$pangkat = new Pangkat();
        //$pangkatOptions = $pangkat->getPangkatOptions();
        //$pangkatMultiOptions = array('[--Pilih--]') + $pangkatOptions;
		
		//para berhenti
		//$para = new Para();
        //$paraOptions = $para->getParaOptions();
        //$paraMultiOptions = array('[--Pilih--]') + $paraOptions;
		
		//marital
		$marital = new Marital();
        $maritalOptions = $marital->getMaritalOptions();
        $maritalMultiOptions = array('[--Pilih--]') + $maritalOptions;
		
		//education
		$education = new Education();
        $educationOptions = $education->getEducationOptions();
        $educationMultiOptions = array('[--Pilih--]') + $educationOptions;
		
		//state
		$state = new State();
        $stateOptions = $state->getStateOptions();
        $stateMultiOptions = array('[--Pilih--]') + $stateOptions;
		
		//Nama
		$this->addElement(
                'ValidationTextBox',
                'realname',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 40,
					'style' => 'width:400px',
					'validators' => array(
						array('StringLength', false, array(3,50))
					),
                )
            );
		
		//No Jabatan
		$this->addElement(
                'ValidationTextBox',
                'jhevno',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Ruangan Diperlukan',
					'maxlength' => 40,
					'style' => 'width:160px',
					'validators' => array(
						array('StringLength', false, array(3,50))
					),
                )
            );
		
		//No MyKad
		$this->addElement(
                'ValidationTextBox',
                'nomykad',
                array(
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '\d+',
					'invalidMessage' => 'Sila Masukkan Nombor Sahaja',
					'maxlength' => 40,
					'style' => 'width:160px',
					'validators' => array(
						array('StringLength', false, array(3,50))
					),
                )
            );
		
		
		//Gambar
		/* $this->addElement(
                'file',
                'picture',
                array(
				'dojoType' => 'dijit.form.ValidationTextBox',
				'class' => 'dijitFileInput'
				)
			); */
		/* $this->addElement('text', 'realname', array(
            'decorators' => $this->element2Decorators,
            'label' => 'Nama',
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 40,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'required' => 'true',
				'invalidMessage' => 'Ruangan Diperlukan'
            ),
            'validators' => array(
                array('StringLength', false, array(3,50))
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        )); */
		//Email
		$this->addElement(
                'ValidationTextBox',
                'email',
                array(
					'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
					'validators' => array(
						'EmailAddress',
					),
                )
            );
        
		//Tarikh Lahir
		$this->addElement(
                'DateTextBox',
                'date_bday',
                array(
					'required'       => false,
					'invalidMessage' => 'Tarikh Tidak Sah<br>Contoh : 09-09-2009',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
		//Jantina
		$this->addElement(
                'FilteringSelect',
                'gender',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $genderMultiOptions,
                )
            );
		
		//Bahagian
		$this->addElement(
                'FilteringSelect',
                'jhev_dept',
				array(
					'required' => true,
					'storeId'     => 'deptStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/authentication/dept',
					),
					'dijitParams' => array(
						'searchAttr' => 'desc',
					),
					'attribs'	=> array(
						'onChange' => "dijit.byId('jhev_unit').query.dept_id = this.value || ' ';",
						'style' => 'width:300px'
					),
				)
            );
		//Unit
		$this->addElement(
                'FilteringSelect',
                'jhev_unit',
                array(
					'required' => true,
					'query' => "{dept_id:' '}",
					'autocomplete' => true,
					'storeId' => 'unitStore',
					'storeType' => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/authentication/unit',
					),
					'dijitParams' => array(
						'searchAttr' => 'unit_desc',
					),
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
        
		
		//Kategori Perkhidmatan
		/*$this->addElement(
                'FilteringSelect',
                'perkhidmatan',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $serviceMultiOptions,
                )
            );
		
		//Pangkat
		$this->addElement(
                'FilteringSelect',
                'pangkat',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $pangkatMultiOptions,
                )
            );
		
		//Para Berhenti
		$this->addElement(
                'FilteringSelect',
                'para',
                array(
                    'style'    => 'width: 500px;',
					'autocomplete' => true,
                    'multiOptions' => $paraMultiOptions,
                )
            );
		
		//Tarikh Mula Khidmat
		$this->addElement(
                'DateTextBox',
                'tkh_mulakhidmat',
                array(
					'required'       => false,
					'invalidMessage' => 'Tarikh Tidak Sah<br>Contoh : 09-10-2009',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
		//Tarikh Lahir
		$this->addElement(
                'DateTextBox',
                'tkh_tamatkhidmat',
                array(
					'required'       => false,
					'invalidMessage' => 'Tarikh Tidak Sah<br>Contoh : 09-10-2009',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
			*/
		//Alamat
		$this->addElement(
                'Textarea',
                'alamat1',
                array(
                    'style'    => 'width: 500px;',
                )
            );
		/* $this->addElement(
                'ValidationTextBox',
                'alamat1',
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
		$this->addElement(
                'ValidationTextBox',
                'alamat2',
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
		$this->addElement(
                'ValidationTextBox',
                'alamat3',
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
		*/
		//Poskod
		$this->addElement(
                'ValidationTextBox',
                'poscode',
                array(
                    'trim'       => true,
					'regExp'         => '\d{5}',
					'invalidMessage' => 'Poskod Tidak Sah',
					'style' => 'width:80px',
					'maxlength' => 5,
					'validators' => array(
						array('Digits'),
						array('StringLength', false, array(5,5)
						
						)
					),
                )
            );	
		
		$this->addElement(
                'FilteringSelect',
                'state',
				array(
					'required' => true,
					'storeId'     => 'stateStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/default/authentication/state',
					),
					'dijitParams' => array(
						'searchAttr' => 'sta_name',
					),
					'attribs'	=> array(
						'onChange' => "dijit.byId('city').query.sta_id = this.value || ' ';",
						'style' => 'width:300px'
					),
				)
            );
		//Bandar / Daerah
		$this->addElement(
                'FilteringSelect',
                'city',
                array(
					'required' => true,
					'query' => "{sta_id:' '}",
					'autocomplete' => true,
					'storeId' => 'districtStore',
					'storeType' => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/authentication/district',
					),
					'dijitParams' => array(
						'searchAttr' => 'district_name',
					),
					'attribs'	=> array(
						'style' => 'width:300px'
					),
                )
            );
		//No Telefon
		$this->addElement(
                'ValidationTextBox',
                'phone',
                array(
                    'value'      => '',
                    'trim'       => true,
					'regExp'         => '[\d]+',
					'invalidMessage' => 'No Telefon Tidak Sah<br>Contoh : 0388880000',
					'validators' => array(
						array('Digits'),
						)
					)
            );
			
		//No Telefon Bimbit
		$this->addElement(
                'ValidationTextBox',
                'mobile',
                array(
                    'value'      => '',
                    'trim'       => true,
					'regExp'         => '[\d]+',
					'invalidMessage' => 'No Telefon Tidak Sah<br>Contoh : 0123456789',
					'validators' => array(
						array('Digits'),
					)
                )
            );	
		
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
	
}

?>