<?php

class Premise extends Zend_Db_Table
{

    protected $_name = 'tbl_ppp_premise_type';
	
	public function getPremiseOptions() 
	{
	    $select = $this->select();
		$select->from($this, array('premise_type_id', 'premise_type_name'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	

}