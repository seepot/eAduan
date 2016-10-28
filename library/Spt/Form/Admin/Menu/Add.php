<?php 

class Spt_Form_Admin_Menu_Add extends Zend_Dojo_Form
{
	public function init()
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/menu/add');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'txt_menu_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		$menuType = new MenuType();
        $menuTypeOptions = $menuType->getMenuTypeOptions();
        $menuTypeMultiOptions = array('[--Sila Pilih Jenis Pengguna--]') + $menuTypeOptions;
		
		$this->addElement(
                'FilteringSelect',
                'sel_menu_type',
                array(
                    'autocomplete'=>'true',
					'validators' => array(
						new Zend_Validate_InArray(array_keys($menuTypeOptions))
					),
                    'multiOptions' => $menuTypeMultiOptions,
                )
            );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
			
    }
}

?>