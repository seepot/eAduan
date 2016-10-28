<?php

class Spt_Form_Admin_Group_Edit extends Spt_Form_Admin_Group_Add
{
    public function init()
    {
    	parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $this->setAction(SYSTEM_URL.'/admin/group/edit/id/'.$id);
       	$this->setMethod('post');
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
}