<?php

class Spt_Form_PPP_Permohonan_Add extends Spt_Form
{	public function init()
	{
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/ppp/permohonan/add');
		$this->setMethod('post');
		
		
		$state = new State();
        $stateOptions = $state->getStateOptions();
        $stateMultiOptions = array($translate->_('[--Sila Pilih Kategori--]')) + $stateOptions;
		
		
		
		// premis section
		$premistype = new ;
        $premistypeOptions = $premistype->getTypeOptions();
        $premistypeMultiOptions = array($translate->_('[--Sila Pilih Jenis Premis--]')) + $premistypeOptions;
		
		//premis type
		$this->addElement('select', 'premistype', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
        	'validators' => array(
                new Zend_Validate_InArray(array_keys($premistypeOptions))
            ),
            'multioptions'   => $premistypeMultiOptions,
        ));
		// nama premis
		$this->addElement('text', 'namapremis', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 40,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// alamat premis
		$this->addElement('textarea', 'alamatpremis', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
		// negeri
		$this->addElement('select', 'negeripremis', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
        	'validators' => array(
                new Zend_Validate_InArray(array_keys($stateOptions))
            ),
            'multioptions'   => $stateMultiOptions,
        ));
        // daerah		
        $this->addElement('text', 'daerahpremis', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 40,
				//'style' => 'width:20px',
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		//poskod
		$this->addElement('ValidationTextBox', 'poskodpremis', array(
            'value'	=> '',
            'trim'  => true,
			'required'	=> true,
			'regExp'	=> '\d{12}',
			'invalidMessage' => 'Ruangan Diperlukan',
			'maxlength' => 12,
        ));	
		// telefon
		$this->addElement('text', 'telefonpremis', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));	
		// faks
		$this->addElement('text', 'fakspremis', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// keterangan
		$this->addElement('textarea', 'keterangan', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
		
		
		//pengusaha
		

        // daerah pengusaha		
        $this->addElement('text', 'daerahpengusaha', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 40,
				//'style' => 'width:20px',
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		//poskod pengusaha
		$this->addElement('ValidationTextBox', 'poskodpengusaha', array(
            'value'	=> '',
            'trim'  => true,
			'required'	=> true,
			'regExp'	=> '\d{12}',
			'invalidMessage' => 'Ruangan Diperlukan',
			'maxlength' => 12,
        ));	
		// telefon pengusaha
		$this->addElement('text', 'telefonpengusaha', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));	
		// faks pengusaha
		$this->addElement('text', 'fakspengusaha', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 20,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		
		//syarikat
		
		// no. pendaftaran
		$this->addElement('text', 'nopendaftaran', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 50,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Modal Dibenarkan
		$this->addElement('text', 'modaldibenarkan', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Modal Berbayar
		$this->addElement('text', 'modalberbayar', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		
		
		// Modal Bumiputera
		$this->addElement('text', 'modalbumiputera', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		
			
		// Modal Bumiputera
		$this->addElement('text', 'state', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
				
		// Modal Bumiputera
		$this->addElement('text', 'district', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Modal Bumiputera
		$this->addElement('text', 'premise_postcode', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// peratus Modal Bumiputera
		$this->addElement('text', 'peratusbumiputera', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Modal Bukan Bumiputera
		$this->addElement('text', 'modalbbumiputera', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// peratus Modal Bukan Bumiputera
		$this->addElement('text', 'peratusbbumiputera', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Modal Warga Asing
		$this->addElement('text', 'modalasing', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// peratus Modal Warga Asing
		$this->addElement('text', 'peratusasing', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Jumlah Modal
		$this->addElement('text', 'modaljumlah', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// jumlah peratus Modal
		$this->addElement('text', 'peratusjumlah', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		
		
		//Kakitangan
		
		// Pengurusan Warganegara
		$this->addElement('text', 'pengurusanw', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Pengurusan Bukan Warganegara
		$this->addElement('text', 'pengurusanbw', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Sokongan  Warganegara
		$this->addElement('text', 'sokonganw', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// Sokongan  Bukan Warganegara
		$this->addElement('text', 'sokonganbw', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		
		//Keahlian Persatuan Hotel 
		
		// Nama Persatuan
		$this->addElement('text', 'namapersatuan', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
        ));
		// No Ahli
		$this->addElement('text', 'noahli', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'maxlength' => 40,
                'size' => 30,
				'dojoType' => 'dijit.form.ValidationTextBox',
				'regExp' => '[\w]+',
				'required' => 'true',
				'invalidMessage' => $translate->_('Ruangan Diperlukan')
            ),
            'filters' => array('StringTrim'),
            'required' => true
			
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