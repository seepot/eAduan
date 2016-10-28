<?php

class Spt_Controller_Action extends Zend_Controller_Action
{
	public $title = '';
	public $translate;
	
	function getUrl()
	{
		return Zend_Controller_Front::getInstance()->getBaseUrl();
	}
	
	function grid()
    {
		$export = $this->getRequest ()->getParam ( 'export' );
        
        $db = Zend_Registry::get ( 'db' );
        
        switch ($export)
        {
            case 'odt' :
                $grid = "Bvb_Grid_Deploy_Odt";
                break;
            case 'ods' :
                $grid = "Bvb_Grid_Deploy_Ods";
                break;
            case 'xml' :
                $grid = "Bvb_Grid_Deploy_Xml";
                break;
            case 'csv' :
                $grid = "Bvb_Grid_Deploy_Csv";
                break;
            case 'excel' :
                $grid = "Bvb_Grid_Deploy_Excel";
                break;
            case 'word' :
                $grid = "Bvb_Grid_Deploy_Word";
                break;
            case 'wordx' :
                $grid = "Bvb_Grid_Deploy_Wordx";
                break;
            case 'pdf' :
                $grid = "Bvb_Grid_Deploy_Pdf";
                break;
            case 'print' :
                $grid = "Bvb_Grid_Deploy_Print";
                break;
            default :
                $grid = "Bvb_Grid_Deploy_Table";
                break;
        }
        
        $grid = new $grid ( $db, $this->title, 'media/temp', array ('download' ) );
        $grid->escapeOutput ( false );
        $grid->addTemplateDir ( 'My/Template/Table', 'My_Template_Table', 'table' );
        $grid->addElementDir ( 'My/Validate', 'My_Validate', 'validator' );
        $grid->addElementDir ( 'My/Filter', 'My_Filter', 'filter' );
        $grid->addFormatterDir ( 'My/Formatter', 'My_Formatter' );
        $grid->imagesUrl = $this->getRequest ()->getBaseUrl () . '/public/images/icon/';
        $grid->cache = array ('use' => 0, 'instance' => Zend_Registry::get ( 'cache' ), 'tag' => 'grid' );
        
        return $grid;
    }
	
	function translate()
	{
		$translate = Zend_Registry::get ( 'translate' );
		return $translate;
	}
}
?>