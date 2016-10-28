<?php

class Spt_Form_PPP_Pengkelasan_Bedroom extends Zend_Dojo_Form
{
    public $rowbedroom;
	public $rowbedroomB;
    public $categoryTypeId;
	
	public function bedroom()
	{
		return $this->rowbedroom;	
	}
	
	public function bedroomB()
	{
		return $this->rowbedroomB;	
	}
	public function setCategoryTypeId($n = 1)
	{
		
		$this->categoryTypeId = $n;	
		echo $this->categoryTypeId;
	}
	public function setCategoryTypeId2($n = 2)
	{
		
		$this->categoryTypeId = $n;	
		echo $this->categoryTypeId;
	}
	
	public function getCategoryTypeId()
	{
		return $this->categoryTypeId;
	}
	public function getCategoryTypeId2()
	{
		return $this->categoryTypeId;
	}
	public function init()
    {
	
		$this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=bedroom');
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