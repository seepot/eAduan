<?php 

class Spt_Form_Admin_Acl_ModuleEdit extends Spt_Form_Admin_Acl_ModuleAdd
{
	public function init()
    {
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        //$this->setAction(SYSTEM_URL.'/admin/group/edit/id/'.$id);
		$this->setAction(SYSTEM_URL.'/admin/acl/module_edit/id/'.$id);
		$this->setMethod('post');
		
		parent::init();
		
		//Module
		$this->addElement(
                'TextBox',
                'module',
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