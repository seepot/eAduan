<?php

class Spt_Form_TG_New_Semakan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/tg/new/semakan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		//Nama Kursus
		$form->addElement(
			'CheckBox',
			'foo',
			array(
				'checkedValue'   => 'foo',
				'uncheckedValue' => 'bar',
				'checked'        => false,
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