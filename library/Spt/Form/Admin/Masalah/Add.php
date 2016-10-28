<?php 

class Spt_Form_Admin_Masalah_Add extends Zend_Dojo_Form
{
	public function init()
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/masalah/add');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'txt_masalah_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		//Pegawai BPM
		$this->addElement(
                'FilteringSelect',
                'sel_bpm',
				array(
					'required' => true,
					'storeId'     => 'bpmStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/admin/masalah/bpm',
					),
					'dijitParams' => array(
						'searchAttr' => 'bpm_name',
					),
					'attribs'	=> array(
						'style' => 'width:300px'
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