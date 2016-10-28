<?php

class Spt_Form_TG_New_Kursus extends Zend_Dojo_Form
{
    public function init()
    {
		parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		//$this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=kursus');
        $this->setAction(SYSTEM_URL.'/tg/new/applynew/id/'.$id.'/currtab/kursus');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: kursus///////
        //
        //
		//Nama Kursus
		$this->addElement(
                'ValidationTextBox',
                'appl_kursus_name',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
        //Tarikh Kursus
		$this->addElement(
                'DateTextBox',
                'appl_kursus_tkh',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		$this->addElement(
                'DateTextBox',
                'appl_kursus_tkh_tamat',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidak Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );
		
		//Penganjur Kursus
		$penganjur = new Penganjur();
        $penganjurOptions = $penganjur->getPenganjurOptions();
        $penganjurMultiOptions = array($translate->_('[--Sila Pilih Penganjur--]')) + $penganjurOptions;

        $this->addElement(
                'FilteringSelect',
                'penganjur_id',
                array(
					'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($penganjurOptions))
                    ),
                    'multioptions'   => $penganjurMultiOptions,
                )
            );
        //Keputusan yang telah Diperolehi
        $this->addElement(
                'RadioButton',
                'appl_kursus_keputusan',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Lulus'),
                        '2' => $translate->_('Gagal')
                    ),
					'required'       => true,
                )
            );


		///
        $this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		
		
    }
}
?>