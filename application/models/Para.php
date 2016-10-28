<?php 

class Para extends Zend_Db_Table_Abstract {
 
	protected $_name = 'tbl_para_berhenti';
 
	public function getParaOptions() 
	{
 
	    $x = ' ';
		$select2 = 'SELECT para_id, CONCAT(para_peraturan,para_sebab) AS sebab FROM tbl_para_berhenti ORDER BY para_peraturan';
		$select = $this->select();
		$select->from($this, array('para_id', 'para_sebab'))
			->where('para_status <> 0');
	    $result = $this->getAdapter()->fetchPairs($select2);
	 
	    return $result;
  	}
}

?>