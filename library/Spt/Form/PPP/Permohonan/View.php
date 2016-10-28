<?php

class Spt_Form_PPP_Permohonan_View extends Spt_Form_PPP_Permohonan_Add
{
   
    public function init()
    {
        $translate = Zend_Registry::get ( 'translate' );
		
		$category = new Category();
        $categoryOptions = $category->getCategoryOptions();
			
		$subcategory = new Subcategory();
        $subcategoryOptions = $subcategory->getSubCategoryOptions();
		
		$items = new Items();
        $itemsOptions = $items->getProductOptions();
		
    	parent::init();
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
       	$this->setMethod('get');
    }
   
}