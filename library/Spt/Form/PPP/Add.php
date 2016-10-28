<?php

class Spt_Form_PPP_Pengkelasan_Add extends Spt_Form
{	public function init()
	{
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/ppp/pengkelasan/add');
		$this->setMethod('post');
		
		
		
		//  no reg
		$this->addElement('text', 'premise_registration_no', array(
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
		// nama hotel
		$this->addElement('textarea', 'premise_name', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
		
		
		// alamat hotel
		$this->addElement('textarea', 'premise_address', array(
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
		$this->addElement('select', 'premise_state_id', array(
            'decorators' => $this->_standardRadioElementDecorator,
            'required'   => true,
        	'validators' => array(
                new Zend_Validate_InArray(array_keys($stateOptions))
            ),
            'multioptions'   => $stateMultiOptions,
        ));
        // daerah		
        $this->addElement('text', 'premise_region_id', array(
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
		$this->addElement('ValidationTextBox', 'premise_postcode', array(
            'value'	=> '',
            'trim'  => true,
			'required'	=> true,
			'regExp'	=> '\d{12}',
			'invalidMessage' => 'Ruangan Diperlukan',
			'maxlength' => 12,
        ));	
		// telefon
		$this->addElement('text', 'premise_phone', array(
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
		$this->addElement('text', 'premise_fax', array(
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
		// nama_pemberi_maklumat
		$this->addElement('text', 'nama_pemberi_maklumat', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
		
		
		//jawatan
	
		$this->addElement('text', 'jawatan', array(
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
		
		//comment
	
		$this->addElement('text', 'comment', array(
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
		
		
		/*
		// alamat pengusaha
		$this->addElement('textarea', 'alamatpengusaha', array(
            'decorators' => $this->element2Decorators,
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
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
		
		*/
		
		
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