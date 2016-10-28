<?php 

class Spt_Form_Admin_Page_Add extends Zend_Dojo_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
		
		//setting environment
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		$this->setAction(SYSTEM_URL.'/admin/information/add'.$id);
		$this->setMethod('post');
			
		//Nama
		$this->addElement(
                'ValidationTextBox',
                'page_name',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		//Keterangan
		$this->addElement(
                'ValidationTextBox',
                'page_desc',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
		
		//Kandungan
		/* $this->addElement(
                'Textarea',
                'page_content',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
		$this->addElement('textarea', 'groupdesc', array(
            'label' => 'Keterangan',
        	'class' => 'input-text required-entry',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'validators' => array(
                array('StringLength', false, array(3,40))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        )); */
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
		$this->setDecorators(array(
				'FormElements',                       
				array(array('data'=>'HtmlTag'),
				array('tag'=>'table','cellspacing'=>'4')),
				'DijitForm'
		));
    }
	
}

?>