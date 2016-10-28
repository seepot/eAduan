<?php 

class Bpm_DataController extends Spt_Controller_Action
{
	/*public function lookupAction() 
	{ 
		$filterName = $this->_request->getParam('filterName'); 
		$filterValue = $this->_request->getParam('filterValue'); 

		// Again we're using a generic lookup table class 
		$_model = new Problem(); 
		$data = $_model->getLookup($filterName, $filterValue); 
		//die('xx');
		if (null !== $data) { 
		$items = array(); 
		foreach ($data as $row) { 
		$items[] = array('label' => $row->km_desc, 'name' => $row->km_desc, 'key' => $row->km_id); 
		} 

		$final = array( 
		'identifier' => 'key', 
		'items' => $items, 
		); 
		//echo Zend_Json_Encoder::encode($final); 
		
		$data = new Zend_Dojo_Data('groomServicesID',$final);
		echo $data->toJson();
	} */
	
	public function lookupAction() 
	{ 
		$db = Zend_Registry::get ( 'db' );
		
		$query = "SELECT km_id, km_desc FROM ea_kategoriMasalah"
		$result = $db->fetchArray($query);
		$data = new Zend_Dojo_Data('km_id',$result);
		echo $data->toJson();
	} 
	
	public function preDispatch() 
	{     
		// Disable for entire controller.  Otherwise, put these calls into your action function 
		$this->_helper->layout()->disableLayout(); 
		$this->_helper->viewRenderer->setNoRender(true); 
	}   
	
}

?>