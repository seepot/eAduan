<?php

class Spt_Form_PPP_Pengkelasan_Staff extends Zend_Dojo_Form
{
    public $rowstaff;
	public $rowstaffB;
    public $categoryTypeId = 1;
	
	public function staff()
	{
		return $this->rowstaff;	
	}
		public function staffB()
	{
		return $this->rowstaffB;	
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
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=staff');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
	

	} }

?>