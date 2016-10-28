<?php 

class Spt_Includes_Flow
{
	function func_getFlowLength($flow_id = 0)	{
	
		$db = Zend_Registry::get ( 'db' );
		$flow = $db->fetchRow('SELECT flow_length FROM doc_flow WHERE flow_id="'.$flow_id.'"');
		
		return $flow['flow_length'];
	}
	
	function func_getStepLength($flow_id = 0)	{
	
		$totalDays = 0;
		$db = Zend_Registry::get ( 'db' );
		$step = $db->fetchAll('SELECT step_length FROM doc_step WHERE flow_id="'.$flow_id.'"');
		
		foreach ($step as $s){
			$totalDays = $totalDays + $s['step_length'];
		}
		
		return $totalDays;
	}
	
}

?>