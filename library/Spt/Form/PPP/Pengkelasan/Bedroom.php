<?php

class Spt_Form_PPP_Pengkelasan_Bedroom extends Zend_Dojo_Form
{
    public $rowbedroom;
	public $rowbedroomB;
    public $categoryTypeId = 1;
	
	public function quality()
	{
		return $this->rowbedroom;	
	}
	
		public function qualityB()
	{
		return $this->rowbedroomB;	
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
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=bedroom');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
	

	} }

?>