<?php

class Spt_Form_Tempahan_Bilik extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tempahan/new/bilik/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		//Bilik
		$bilik = new Bilik();
        $bilikOptions = $bilik->getBilikOptions(1);
        $dewanOptions = $bilik->getBilikOptions(2);
        //$bilikMultiOptions = array($translate->_('[--Sila Pilih Negeri--]')) + $bilikOptions;
	   
	   foreach($bilikOptions as $id=>$value){
			$this->addElement(
                'Checkbox',
                'chk_bilik_'.$id,
                array(
                    'checkedValue'   => '1',
					'uncheckedValue' => '0',
					'checked'        => false,
                )
            ); 
		}
        foreach($dewanOptions as $id=>$value){
			$this->addElement(
                'Checkbox',
                'chk_dewan_'.$id,
                array(
                    'checkedValue'   => '1',
					'uncheckedValue' => '0',
					'checked'        => false,
                )
            ); 
		}
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