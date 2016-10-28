<?php

class Spt_Form_Btm_Akhbar_Edit extends Spt_Form_Btm_Akhbar_Add
{
   
    public function init()
    {
        $translate = Zend_Registry::get ( 'translate' );
		//courses
		$course = new Course();
        $courseOptions = $course->getCourseOptions();
        $courseMultiOptions = array('[--Choose Programme--]') + $courseOptions;
		
		//club
		$club = new Club();
        $clubOptions = $club->getClubOptions();
        $clubMultiOptions = array('[--Choose Department--]') + $clubOptions;
    	
    	parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/btm/paper/edit/id/'.$id);
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
					'readonly' => 'readonly'
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

		));		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
   
}