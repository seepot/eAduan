<?php 

class Spt_Form_Admin_Acl_ResourceEdit extends Spt_Form_Admin_Acl_ResourceAdd
{
	public function init()
    {
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        //$this->setAction(SYSTEM_URL.'/admin/group/edit/id/'.$id);
		$this->setAction(SYSTEM_URL.'/admin/acl/resource_edit/id/'.$id);
		$this->setMethod('post');
		
		parent::init();
		
		//Module
		$this->addElement(
                'TextBox',
                'resources',
                array(
					'required'	=> false,
					'readonly' => 'readonly',
                )
            );
		
        
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
		
        
        
    }
	
}

?>