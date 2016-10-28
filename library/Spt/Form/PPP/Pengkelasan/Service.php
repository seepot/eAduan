<?php

class Spt_Form_PPP_Pengkelasan_Service extends Zend_Dojo_Form
{
    public $rowservice;
    public $categoryTypeId = 1;
	
	public function service()
	{
		return $this->rowservice;	
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
        $this->setAction(SYSTEM_URL.'/ppp/classification/applynew?currtab=service');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );  
		
		
		//category A
		$categorytypeid=1;
		$criteriatypename='Services';
		$criteriatypeid=1;
		$dbA = Zend_Registry::get ( 'db' );
		$dbA->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->rowservice = $dbA->fetchAssoc("select criteria_id,criteria_name,criteria_green from tbl_ppp_criteria where category_id= 
									(select category_id from tbl_ppp_category where category_type_id=".$categorytypeid." and category_name like '".$criteriatypename."')
									and criteria_type_id=".$criteriatypeid." ");
									
									foreach($this->rowservice as $criteriaid => $criterianame)		
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
	
	}
}

?>