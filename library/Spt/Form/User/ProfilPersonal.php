<?php 

class Spt_Form_User_ProfilPersonal extends Zend_Dojo_Form
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
		
		//warganegara
		$nationality = new Nationality();
        $nationalityOptions = $nationality->getNationalityOptions();
        $nationalityMultiOptions = array('[--Pilih--]') + $nationalityOptions;
		
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
					'validators' => array(
						array('StringLength', false, array(3,50))
					),
                )
            );
		
		//Gambar
		$this->addElement(
                'file',
                'picture',
                array(
				'dojoType' => 'dijit.form.ValidationTextBox',
				'class' => 'dijitFileInput'
				)
			);
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
		
		//Umur
		$this->addElement(
                'ValidationTextBox',
                'age',
                array(
                    'trim'       => true,
					'regExp'         => '\d+',
					'invalidMessage' => 'Umur Tidak Sah',
					'maxlength' => 12,
					'validators' => array(
						array('Digits'),
						array('StringLength', false, array(1,3)
						
						)
					),
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
		
		//Agama
		$this->addElement(
                'FilteringSelect',
                'religion',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $religionMultiOptions,
                )
            );
        
		//Warganegara
		$this->addElement(
                'FilteringSelect',
                'nationality',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $nationalityMultiOptions,
                )
            );
		
		//Status Perkahwinan
		$this->addElement(
                'FilteringSelect',
                'marital',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $maritalMultiOptions,
                )
            );
		
		//Taraf Pendidikan
		$this->addElement(
                'FilteringSelect',
                'education',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $educationMultiOptions,
                )
            );
		
		//Alamat
		$this->addElement(
                'Textarea',
                'address',
                array(
                    'style'    => 'width: 500px;',
                )
            );
		
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
		
		//Bandar
		$this->addElement(
                'ValidationTextBox',
                'city',
                array(
                    'trim'       => true,
					'invalidMessage' => 'Diperlukan',
					'validators' => array(
						array('StringLength', false, array(3,40))
					),
                )
            );
		
		//Negeri
		$this->addElement(
                'FilteringSelect',
                'state',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $stateMultiOptions,
                )
            );
		
		//Negara
		$this->addElement(
                'ValidationTextBox',
                'country',
                array(
                    'trim'       => true,
					'invalidMessage' => 'Diperlukan',
					'validators' => array(
						array('StringLength', false, array(3,40))
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