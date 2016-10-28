<?php

class Spt_Form_Btm_Akhbar_Add extends Zend_Dojo_Form
{	public function init()
	{
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/btm/paper/add');
		$this->setMethod('post');
		
		//Tajuk
        $this->addElement(
                'ValidationTextBox',
                'txt_tajuk',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
					'style' => 'width:350px;',
                )
            );
			
		//Surat Khabar
		$group = new Gpaper();
        $groupOptions = $group->getGpaperOptions();
        $groupMultiOptions = array($translate->_('[--Sila Pilih--]')) + $groupOptions;

        $this->addElement(
                'FilteringSelect',
                'sel_paper',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($groupOptions))
                    ),
                    'multioptions'   => $groupMultiOptions,
                )
            ); 
		
								
		//Keterangan
		$this->addElement(
                'Textarea',
                'txt_keterangan',
                array(
                    
                )
            );
		
		//Kolum
        $this->addElement(
                'TextBox',
                'txt_kolum',
                array(
                    'trim'       => true,
					'style' => 'width:150px;',
                )
            );
		
		//Muka Surat
        $this->addElement(
                'TextBox',
                'txt_mukasurat',
                array(
                    'trim'       => true,
					'style' => 'width:50px;',
                )
            );
			
		//Gambar Keratan Akhbar
        /* $this->addElement(
                'file',
                'fail_gambar',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 102400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );
			 */
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		
		
	}	
		
		
	


	
}
	
?>