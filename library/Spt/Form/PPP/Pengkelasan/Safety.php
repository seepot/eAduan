<?php

class Spt_Form_PPP_Pengkelasan_Safety extends Zend_Dojo_Form
{
    public $rowsafety;
	public $rowsafetyB;
    public $categoryTypeId = 1;
	
	public function safety()
	{
		return $this->rowsafety;	
	}
	public function safetyB()
	{
		return $this->rowsafetyB;	
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
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=safety');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
	

	} }

?>