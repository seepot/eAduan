<?php

class Spt_Form_PPP_Pengkelasan_Summary extends Zend_Dojo_Form
{
	public function init()
    {
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $cls = Zend_Controller_Front::getInstance()->getRequest()->getParam('cls');
		$this->setAction(SYSTEM_URL.'/ppp/classification/summary/id/'.$id.'/cls/'.$cls);
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		 //comment
	$this->addElement(
                'Textarea',
                'overall_comment',
                array(
					'required' => true,
					'style'    => 'width: 400px;',
	
                )
            );
		 //check
	   $this->addElement(
                'CheckBox',
                'check',
                array(
						'checkedValue'   => 1,
						'uncheckedValue' => 0,
						'checked'        => 0,
						'attribs' => array(
							'onClick' => 'func_submit();' 
						),
                )
            );
			 
		//date	
		$this->addElement(
			'DateTextBox',
			'checking_date2',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
		$this->addElement(
			'DateTextBox',
			'checking_date',
			array(
				'value' => date('Y-m-d'),
				'invalidMessage' => 'Tarikh Tidak Sah',
				'datePattern'   => 'dd-MM-yyyy',
				'formatLength'   => 'short',
				
			)
		);
			
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
	
	
	
	}
}

?>