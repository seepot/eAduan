<?php 

class Spt_Form_Admin_Auditrail_Edit extends Spt_Form_Admin_Auditrail_Add
{
    public function init()
    {	/*
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/admin/auditrail/edit');
        $this->setMethod('post');
		
		//audit id
		$this->addElement(
                'Hidden',
                'audit_id',
                array(
                    
                )
            );
		
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
		*/
		
		//get translate
		$translate = Zend_Registry::get ( 'translate' );
		
		//setting environment
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/auditrail/edit/id/'.$id);
		$this->setMethod('post');
		
		parent::init();
		
		//audit id
		$this->addElement(
                'Hidden',
                'audit_id',
                array(
                    
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