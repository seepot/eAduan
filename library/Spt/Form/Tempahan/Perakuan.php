<?php

class Spt_Form_Tempahan_Perakuan extends Zend_Dojo_Form
{
    protected $_id;
	
	public function init($id = '')
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/tempahan/new/perakuan/id/'.$id);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

		$this->addElement(
			'Checkbox',
			'chk_perakuan',
			array(
				'checkedValue'   => '1',
				'uncheckedValue' => '0',
				'checked'        => false,
				'attribs' => array(
							'onClick' => 'func_submit();' 
						),
			)
		); 
		//samb. tel
		$this->addElement(
                'ValidationTextBox',
                'no_samb_tel',
                array(
                    'trim'       => true,
					'required'       => true,
					'regExp'	=>	'\d+',
					'invalidMessage' => 'Diperlukan',
                )
            );
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		

    }
	
}
?>