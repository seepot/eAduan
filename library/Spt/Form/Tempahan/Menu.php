<?php

class Spt_Form_Tempahan_Menu extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tempahan/new/menu/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		//Bilik
		$menu = new Menu();
        $pagiOptions = $menu->getMenuOptions(1);
		$petangOptions = $menu->getMenuOptions(2);
        $tengahariOptions = $menu->getMenuOptions(3);
	   
		$this->addElement(
			'RadioButton',
			'rad_pagi',
			array(
				'multiOptions'  => array(
					1 => 'Ya',
					0 => 'Tidak',
				),
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
				'attribs'	=>	array(
					'onClick'	=>	'func_display("pagi");' 
				),
			)						
		); 
		foreach($pagiOptions as $id=>$value){
			$this->addElement(
                'Checkbox',
                'chk_pagi_'.$id,
                array(
                    'checkedValue'   => '1',
					'uncheckedValue' => '0',
					'checked'        => false,
                )
            ); 
		}
		$this->addElement(
			'RadioButton',
			'rad_petang',
			array(
				'multiOptions'  => array(
					1 => 'Ya',
					0 => 'Tidak',
				),
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
				'attribs'	=>	array(
					'onClick'	=>	'func_display("petang");' 
				),
			)						
		); 
        foreach($petangOptions as $id=>$value){
			$this->addElement(
                'Checkbox',
                'chk_petang_'.$id,
                array(
                    'checkedValue'   => '1',
					'uncheckedValue' => '0',
					'checked'        => false,
                )
            ); 
		}
		$this->addElement(
			'Checkbox',
			'chk_tengahari',
			array(
				'checkedValue'   => '1',
				'uncheckedValue' => '0',
				'checked'        => false,
			)
		); 
		$this->addElement(
			'RadioButton',
			'rad_tengahari',
			array(
				'multiOptions'  => array(
					1 => 'Ya',
					0 => 'Tidak',
				),
				//'value' => 0,
				'required' => true,
				'separator' => '&nbsp;&nbsp;',
			)						
		); 
		//Lain-lain
		$this->addElement(
                'Textarea',
                'txt_lain',
                array(
					'style'	=>	'width: 400px;'
                )
            );	
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		

    }
	
}
?>