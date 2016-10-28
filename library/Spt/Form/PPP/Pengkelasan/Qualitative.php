<?php

class Spt_Form_PPP_Pengkelasan_Qualitative extends Zend_Dojo_Form
{
    public $rowquality;
    public $categoryTypeId = 1;
	
	public function quality()
	{
		return $this->rowquality;	
	}
	
	public function setCategoryTypeId($n = 1)
	{
		
		$this->categoryTypeId = $n;	
		echo $this->categoryTypeId;
	}
	
	public function getCategoryTypeId()
	{
		return $this->categoryTypeId;
	}
	
	public function init()
    {
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=qualitative');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
	

	} }

?>