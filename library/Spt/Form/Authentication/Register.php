<?php 

class Spt_Form_Authentication_Register extends Zend_Dojo_Form
{

	public function init()
    {
        //setting environment
		 $front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->setAction(SYSTEM_URL.'/authentication/register');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		
		$group = new AclRole();
        $groupOptions = $group->getRoleNameOptions();
        $groupMultiOptions = array($translate->_('[--Sila Pilih Kumpulan Pengguna--]')) + $groupOptions;
		
		//state
		$state = new State();
        $stateOptions = $state->getStateOptions();
        $stateMultiOptions = array('[--Pilih--]') + $stateOptions;
		
		//ID Pengguna
		$this->addElement(
                'ValidationTextBox',
                'user_id',
                array(
					'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'regExp'         => '[\w]+',
					'invalidMessage' => 'Diperlukan',
                )
            );
		
			//user ic
		$this->addElement(
                'ValidationTextBox',
                'user_identno',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					//'regExp'         => '\d{12}',
					'invalidMessage' => 'No Kad Pengenalan Tidak Sah',
					'maxlength' => 12,
                )
            );	
			
		//user real name
		$this->addElement(
                'ValidationTextBox',
                'user_name',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		//no jabatan
		$this->addElement(
                'ValidationTextBox',
                'user_nojabatan',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
		//kumpulan pengguna
			$this->addElement(
                'FilteringSelect',
                'group_id',
                array(
                    'autocomplete' => true,
					'validators' => array(
						new Zend_Validate_InArray(array_keys($groupOptions))
					),
                    'multiOptions' => $groupMultiOptions,
                )
            );
		
		
		$this->addElement(
                'PasswordTextBox',
                'user_password1',
                array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'regExp'         => '^[a-z0-9]{6,}$',
				'invalidMessage' => 'Invalid password; ' .
									'must be at least 6 alphanumeric characters',
			)
                
            );
			
			
		$this->addElement(
                'PasswordTextBox',
                'user_password2',
                array(
				'required'       => true,
				'trim'           => true,
				'lowercase'      => true,
				'regExp'         => '^[a-z0-9]{6,}$',
				'invalidMessage' => 'Invalid password; ' .
									'must be at least 6 alphanumeric characters',
			)
                
            );
			
		
	
		
		$this->addElement(
                'ValidationTextBox',
                'user_email',
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
			
	
		
			
			$this->addElement(
                'RadioButton',
                'user_sex',
                array(
                    'multiOptions'  => array(
						'2' => $translate->_('Perempuan'),
                        '1' => $translate->_('Lelaki')
                        
                    ),
					'required'       => true,
					'separator' => '<blockquote>'
					
                )
            );
			
		
		
	 	$this->addElement(
                'ValidationTextBox',
                'office_no',
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
		
	
	

	
		
		$this->addElement(
                'ValidationTextBox',
                'mobile_no',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
		$this->addElement(
                'ValidationTextBox',
                'primary_add',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
		$this->addElement(
                'ValidationTextBox',
                'poskod_add',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			
		/*$this->addElement(
                'ValidationTextBox',
                'town_add',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
			*/
		//Negeri
		/*$this->addElement(
                'FilteringSelect',
                'state_add',
                array(
                    'autocomplete' => true,
                    'multiOptions' => $stateMultiOptions,
                )
            );*/
		$this->addElement(
                'FilteringSelect',
                'state_add',
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
						'onChange' => "dijit.byId('district_add').query.sta_id = this.value || ' ';",
						'style' => 'width:300px'
					),
				)
            );
		//Bandar / Daerah
		$this->addElement(
                'FilteringSelect',
                'district_add',
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
		// Add a captcha
       /* $this->addElement('captcha', 'captcha', array(
			//'required'   => true,
            'captcha'    => array(
                'captcha' => 'Image',
				'font' => 'C:/Windows/Fonts/arial.ttf',
				'fontSize' => '30',
                'wordLen' => 3,
				'height' => '50',
				'width' => '150',
				'imgDir' => IMAGES_PATH2.'/captcha',
				'imgUrl' => IMAGES_PATH.'/captcha',
                'timeout' => 300
            )
        ));
		$this->getElement('captcha')->removeDecorator("viewhelper");*/
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
    }
}

?>