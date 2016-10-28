<?php 

class Spt_Form_Admin_Bahagian_Add extends Zend_Dojo_Form
{
	public function init()
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/bahagian/add');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		//Nama Penuh
		$this->addElement(
                'ValidationTextBox',
                'txt_dept_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
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