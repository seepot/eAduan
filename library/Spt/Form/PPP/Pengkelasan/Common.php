<?php

class Spt_Form_PPP_Pengkelasan_Common extends Zend_Dojo_Form
{
    public $rowcommon;
	public $rowcommonB;
    public $categoryTypeId;
	
	public function common()
	{
		return $this->rowcommon;	
	}
		public function commonB()
	{
		return $this->rowcommonB;	
	}
	
	public function setCategoryTypeId($n = 1)
	{
		
		$this->categoryTypeId = $n;	
		echo $this->categoryTypeId;
	}
	
	/* public function setCategoryTypeId2($n = 1)
	{
		
		$this->categoryTypeId2 = $n;	
		echo $this->categoryTypeId;
	} */
	public function getCategoryTypeId()
	{
		return $this->categoryTypeId;
	}
	
	public function init()
    {
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=common');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
	

	} }

?>