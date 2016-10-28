<?php 

class Spt_Form_Admin_Unit_Add extends Zend_Dojo_Form
{
	public function init()
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/unit/add');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'txt_unit_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		//Bahagian
		$this->addElement(
                'FilteringSelect',
                'sel_bahagian',
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
						'style' => 'width:300px'
					),
				)
            );
		//Penyelia
		$this->addElement(
                'FilteringSelect',
                'sel_penyelia',
				array(
					'required' => true,
					'storeId'     => 'userStore',
					'storeType'   => 'dojo.data.ItemFileReadStore',
					'storeParams' => array(
						'url' => SYSTEM_URL.'/admin/unit/staff',
					),
					'dijitParams' => array(
						'searchAttr' => 'usr_fullname',
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