<?php 

class Spt_Form_ProfilPersonal extends Spt_Form
{
	public function init()
    {
        $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		
		if(Zend_Controller_Front::getInstance()->getRequest()->getParam('tab'))
			$tab = Zend_Controller_Front::getInstance()->getRequest()->getParam('tab');
		else
			$tab = 'personal';
			
		$this->setAction($front.'/user/profil/personal/tab/'.$tab);
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
		
        $this->addElement('text', 'realname', array(
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
			
        ));
              
        $this->addElement('text', 'email', array(
            'decorators' => $this->element2Decorators,
            'label' => 'Alamat Emel',
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 40,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'required' => 'true',
				'invalidMessage' => 'Ruangan Diperlukan'
            ),
            'validators' => array(
                'EmailAddress',
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
        
        $this->addElement('text', 'date_bday', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
        		'size' => '8',
				'dojoType' => 'dijit.form.DateTextBox',
				'constraints' => "{datePattern:'dd-MM-yyyy'}",
				'invalidMessage' => 'Tarikh Tidak Sah<br>Contoh : 09-09-2009'
            ),
            'filters' => array('StringTrim'),
            'required' => false
        ));
		
		$this->addElement('text', 'age', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 3,
                'size' => 3,
				'style' => 'width:40px',
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '\d+',
				'invalidMessage' => 'Umur Tidak Sah'
            ),
            'validators' => array(
                array('Digits'),
            	array('StringLength', false, array(1,3)
                
                )
            ),
            'filters' => array('StringTrim')
        ));
        
        $this->addElement('select', 'gender', array(
            'decorators' => $this->_standardRadioElementDecorator,
			'dojoType' => 'dijit.form.FilteringSelect',
			'autocomplete'=>'true',
			'onChange' => 'setVal1',
            'multioptions'   => $genderMultiOptions,
        ));

		$this->addElement('select', 'religion', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
			'dojoType' => 'dijit.form.FilteringSelect',
			'autocomplete'=>'true',
			'onChange' => 'setVal1',
            'multioptions'   => $religionMultiOptions,
        ));
        
		$this->addElement('select', 'nationality', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
			'dojoType' => 'dijit.form.FilteringSelect',
			'autocomplete'=>'true',
			'onChange' => 'setVal1',
            'multioptions'   => $nationalityMultiOptions,
        ));
		
		$this->addElement('select', 'marital', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
			'dojoType' => 'dijit.form.FilteringSelect',
			'autocomplete'=>'true',
			'onChange' => 'setVal1',
            'multioptions'   => $maritalMultiOptions,
        ));
		
		$this->addElement('select', 'education', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
			'dojoType' => 'dijit.form.FilteringSelect',
			'autocomplete'=>'true',
			'onChange' => 'setVal1',
            'multioptions'   => $educationMultiOptions,
        ));
		
		$this->addElement('textarea', 'address', array(
            'decorators' => $this->element2Decorators,
            'label' => 'Nama',
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 40,
                'cols' => 5,
				'style' => 'width:300px;',
				'dojoType' => 'dijit.form.Textarea'
            ),
			
        ));
		
		$this->addElement('text', 'poscode', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 5,
                'size' => 5,
				'style' => 'width:80px',
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '\d{5}',
				'invalidMessage' => 'Poskod Tidak Sah'
            ),
            'validators' => array(
                array('StringLength', false, array(5,5))
            ),
            'filters' => array('StringTrim')
			
        ));
		
		$this->addElement('text', 'city', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
				'dojoType' => 'dijit.form.ValidationTextBox',
				'invalidMessage' => 'Bandar Tidak Sah'
            ),
            'filters' => array('StringTrim')	
        ));
		
		$this->addElement('select', 'state', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
			'value' => 'aaa',
			'dojoType' => 'dijit.form.FilteringSelect',
			'autocomplete'=>'true',
			'onChange' => 'setVal1',
            'multioptions'   => $stateMultiOptions,
        ));
		
		$this->addElement('text', 'country', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'invalidMessage' => 'Negara Tidak Sah'
            ),
            'filters' => array('StringTrim')	
        ));
		
		$this->addElement('text', 'phone', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\d]+',
				'invalidMessage' => 'Data Tidak Sah<br>Contoh : 0388880000'
            ),
            'validators' => array(
                array('StringLength', false, array(5,5))
            ),
            'filters' => array('StringTrim')	
        ));
		
		$this->addElement('text', 'mobile', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\d]+',
				'invalidMessage' => 'Data Tidak Sah<br>Contoh : 0123456789'
            ),
            'validators' => array(
                array('StringLength', false, array(5,5))
            ),
            'filters' => array('StringTrim')	
        ));
		
        $this->addElement('button', 'submit', array(
            'decorators' => $this->button2Decorators,
            'label' => 'Simpan',
        	'type' => 'submit',
        	'class' => 'scalable save'
        ));
        
        $this->addElement('button', 'reset', array(
            'decorators' => $this->button2Decorators,
            'label' => 'Semula',
        	'type' => 'reset',
        	'class' => 'scalable'
        ));
    }
	
    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
            'Errors'
        ));
    }
}

?>