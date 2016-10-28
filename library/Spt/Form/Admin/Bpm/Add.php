<?php 

class Spt_Form_Admin_Bpm_Add extends Zend_Dojo_Form
{
	public function init()
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/unitbpm/add');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'txt_bpm_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		//Pegawai BPM
		$this->addElement(
                'FilteringSelect',
                'sel_pegawai',
				array(
					'required' => true,
					'storeId'     => 'userStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/admin/unitbpm/staff',
					),
					'dijitParams' => array(
						'searchAttr' => 'usr_fullname',
					),
					'attribs'	=> array(
						'style' => 'width:300px'
					),
				)
			);
            
		//Unit JHEV
		$this->addElement(
                'FilteringSelect',
                'sel_unit',
				array(
					'required' => true,
					'storeId'     => 'unitStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/admin/unitbpm/unit',
					),
					'dijitParams' => array(
						'searchAttr' => 'unit_desc',
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