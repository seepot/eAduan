<?php
class Spt_Form_TG_New_Dokumen extends Zend_Dojo_Form
{
	public function init()
    {
		 parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		//$this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=dokumen');
		$this->setAction(SYSTEM_URL.'/tg/new/applynew/id/'.$id.'/currtab/dokumen');
		$this->setMethod('post');

		$translate = Zend_Registry::get ( 'translate' );

        ////section: dokumen sokongan//////
       //Salinan kad pengenalan
        $this->addElement(
                'file',
                'url_kp',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

       //Salinan Resit keahlian Persatuan Pemandu Pelancong
        $this->addElement(
                'file',
                'url_resit_keahlian',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan Surat Akuan Kesihatan
        $this->addElement(
                'file',
                'url_surat_kesihatan',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Jenis Lesen Pemandu Pelancong
        $this->addElement(
                'RadioButton',
                'tg_type_id',
                array(
                    'multiOptions'  => array(
                        '11' => $translate->_('City Guide'),
                        '12' => $translate->_('Nature Guide'),
                    ),
					'required'	=> true,
					'attribs' => array(
						'onClick' => 'func_pernah(this.value, 2)'
					)
                )
            );
		
		////city guide////
		
		//Salinan surat kelulusan dan Sijil Kursus Latihan Asas Pemandu Pelancong
        $this->addElement(
                'file',
                'url_cg_sijil',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan Sijil Kemahiran Malaysia atau Borang JPK/P2(T/1003)
        $this->addElement(
                'file',
                'url_cg_skm',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan sijil-sijil kelayakan akademik
        $this->addElement(
                'file',
                'url_kelayakan_akademik_cg',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan Sijil Program Mesra Malaysia
        $this->addElement(
                'file',
                'url_cg_sijil_pmm',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan surat tawaran dari majikan Syarikat Pengendalian Pelancong
        $this->addElement(
                'file',
                'url_cg_surat_tawaran',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );
		
		////nature guide////
		
		//Salinan Sijil Kursus Alam Semulajadi Setempat
        $this->addElement(
                'file',
                'url_ng_sijil',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan sijil-sijil kelayakan akademik/kemahiran
        $this->addElement(
                'file',
                'url_kelayakan_akademik_ng',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );

		//Salinan Sijil Kursus Eco Host
        $this->addElement(
                'file',
                'url_ng_sijil_eco_host',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 1024000),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );
			
			
			
			
			

		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
    
	}

}
?>