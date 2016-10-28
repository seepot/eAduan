<?php

class Spt_Form_TG_New_Pengalaman extends Zend_Dojo_Form
{
    public function init()
    {
        parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		//$this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=pengalaman');
        $this->setAction(SYSTEM_URL.'/tg/new/applynew/id/'.$id.'/currtab/pengalaman');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: pengalaman///////
        //
        //Pernah Bekerja Sebagai Pemandu Pelancong
        $this->addElement(
                'RadioButton',
                'appl_pernah',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Ya'),
                        '2' => $translate->_('Tidak')
                    ),
					'required'       => true,
					'attribs' => array(
						'onClick' => 'func_pernah(this.value, 1)'
					)
							
                )
            );
			
		 //No Lesen
        $this->addElement(
                'ValidationTextBox',
                'appl_no_lesen',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					//'required'       => true,
                )
            ); 
			
        //Tarikh Lesen Dikeluarkan
		$this->addElement(
                'DateTextBox',
                'appl_tkh_lesen_keluar',
                array(
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
					//'required'       => true,
                )
            );
			
        //Tarikh Tamat Lesen
		$this->addElement(
                'DateTextBox',
                'appl_tkh_lesen_tamat',
                array(
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
					//'required'       => true,
                )
            );
			
		//Anggaran bilangan kerja memandu pelancong yg dilakukan tahun lalu
		$this->addElement(
                'ValidationTextBox',
                'appl_kerja_memandu',
                array(
                    'value'      => '',
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'regExp'         => '\d{1}',
					'invalidMessage' => 'Nilai Tidak Sah',
					'maxlength' => 5,
					//'required'       => true,
                )
            );
		//taraf pekerjaan
		$this->addElement(
                'RadioButton',
                'taraf_pekerjaan_id',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Sepenuh Masa'),
                        '2' => $translate->_('Sambilan'),
                        '3' => $translate->_('Bebas')
                    ),
					//'required'       => true,
                )
            );

        $this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
    }
}
?>