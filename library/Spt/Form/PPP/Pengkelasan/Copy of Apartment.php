<?php

class Spt_Form_PPP_Pengkelasan_Apartment extends Zend_Dojo_Form
{

	 public $rowapartment;
   // public $categoryTypeId = 2;
	
	public function apartment()
	{
		return $this->rowapartment;	
	}
	
	public function setCategoryTypeId($n = 2)
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
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=apartment');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
	/* 	//$this->categoryTypeId = 1;
		$categorytypeid=$this->getCategoryTypeId();
		$criteriatypeid='Qualitative & Aesthetic Requirements';
		$db5 = Zend_Registry::get ( 'db' );
		$db5->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->rowquality = $db5->fetchAssoc("select criteria_id,criteria_name,criteria_green from tbl_ppp_criteria where category_id= 
									(select category_id from tbl_ppp_category where category_type_id=".$categorytypeid." and category_name like '".$criteriatypeid."')	");
		
		
		
		foreach($this->rowquality as $criteriaid => $criterianame)		
		{
					$label =$criterianame['criteria_id'];	
					$this->addElement(
							'NumberSpinner',
							"$label",
							array(
								'smallDelta'        => 1,
								'largeDelta'        => 10,
								'defaultTimeout'    => 1000,
								'timeoutChangeRate' => 100,
								'min'               => 0,
								'max'               => 100,
								'places'            => 0,
								'maxlength'         => 2,
								'value' => 0,
					
								)
									);
		}	
	

		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));	
	*/

	} }

?>