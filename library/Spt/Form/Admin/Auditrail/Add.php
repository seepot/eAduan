<?php 

class Spt_Form_Admin_Auditrail_Add extends Zend_Dojo_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
		//$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction(SYSTEM_URL.'/admin/auditrail/add');
        $this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddAuditrailForm',
        ));
		
		
		//pengguna multioptions
		$user = new SysUser();
        $userOptions = $user->getInternalUserOptions();
        $userMultiOptions = array($translate->_('[--Sila Pilih Pengguna--]')) + $userOptions;
		
		//module multioptions
		$type = new SysType();
        $typeOptions = $type->getTypeNameOptions();
        $typeMultiOptions = array($translate->_('[--Sila Pilih Modul--]')) + $typeOptions;
		
	
		//Nama Pengguna
		$this->addElement(
                'FilteringSelect',
                'username',
                array(
                    'autocomplete' => true,
					'validators' => array(
						new Zend_Validate_InArray(array_keys($userOptions))
					),
                    'multiOptions' => $userMultiOptions,
                )
            );
		
		//Nama Modul
		$this->addElement(
                'FilteringSelect',
                'typename',
                array(
                    'autocomplete' => true,
					'validators' => array(
						new Zend_Validate_InArray(array_keys($typeOptions))
					),
                    'multiOptions' => $typeMultiOptions,
                )
            );
		
		//Tugasan
		$this->addElement(
                'Textarea',
                'tugasan',
                array(
                    'required'	=>	true
					//'style'    => 'width: 200px;',
                )
            );
			
		//Tarikh
		$this->addElement(
                'DateTextBox',
                'date_audit',
                array(
					'required'       => true,
					'invalidMessage' => 'Invalid date specified.',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
			
		//IP address
		$this->addElement(
                'Hidden',
                'ipaddress',
                array(
                    
                )
            );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
		$this->setDecorators(array(
				'FormElements',                       
				array(array('data'=>'HtmlTag'),
				array('tag'=>'table','cellspacing'=>'4')),
				'DijitForm'
		));
    }
	
}

?>