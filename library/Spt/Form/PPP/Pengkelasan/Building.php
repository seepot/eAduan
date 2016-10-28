<?php

class Spt_Form_PPP_Pengkelasan_Building extends Zend_Dojo_Form
{
    public $rowbuilding;	
	  public function building()
	{
		return $this->rowbuilding;
	}  
	
		public function setCategoryTypeId($n = 3)
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
        $this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=building');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
		
		//category A
	/* 	$categorytypeid=3;
		$criteriatypename='Cleanliness & Hygiene Standard';
		$criteriatypeid=2;
		$dbC = Zend_Registry::get ( 'db' );
		$dbC->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->rowclean = $dbC->fetchAssoc("select criteria_id,criteria_name,criteria_green from tbl_ppp_criteria where category_id= 
									(select category_id from tbl_ppp_category where category_type_id=".$categorytypeid." and category_name like '".$criteriatypename."')
									and criteria_type_id=".$criteriatypeid." ");
									
									foreach($this->rowclean as $criteriaid => $criterianame)		
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

		));	 */
	
	}
}

?>