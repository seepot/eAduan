<?php 

class Bkp_KajianController extends Spt_Controller_Action
{

	public function borangAction()
	{
	
		$form = new Spt_Form_Bkp_Kajian_Borang;
		//$date = new Spt_Includes_Date;
		$this->view->translate = $this->translate();
		//$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		//$this->view->front = $front;
		
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->soalan = $soalan = $db->fetchAssoc("SELECT soalan_id, soalan_desc FROM tbl_soalan where soalan_status = '1'");
									
			foreach($soalan as $id => $q)		
				{
					$label = 'q'.$q['soalan_id'];	
					$form->addElement(
							'NumberSpinner',
							"$label",
							array(
								'smallDelta'        => 1,
								'largeDelta'        => 5,
								'defaultTimeout'    => 1000,
								'timeoutChangeRate' => 100,
								'min'               => 1,
								'max'               => 5,
								'places'            => 0,
								'maxlength'         => 2,
								'style'    			=> 'width: 50px;',
								'value' => 5,
					
								)
									);
				}	
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
        
        $values = $form->getValues();
		
		/* echo "<pre>";
		print_r($values);
		echo "</pre>"; */
		
		$umumdata = array(
			'umum_kumpjawatan'	=> $values['rad_kumpulanjawatan'], 
			'umum_bahagian_id'		=> $values['sel_bahagian'], 
			'umum_jantina'		=> $values['rad_jantina'], 
			'umum_umur'		=> $values['sel_umur'], 
			'umum_tahun'		=> $values['sel_tahun'], 
			'umum_komen'		=> $values['txt_komen'], 
			'record_datetime'				=> date('Y-m-d H:i:s')
			);
		
		//die();
		$db->insert('tbl_umum', $umumdata);
		
		$umum_id = $db->lastInsertId();
		
		//echo $umum_id;
		
		foreach($soalan as $id => $q)		
		{
			$n = 'q'.$q['soalan_id'];
			
			$ratingdata = array(
				'soalan_id'	=> $q['soalan_id'], 
				'umum_id'		=> $umum_id,
				'skala'				=> $values[$n]
				);
			/* echo "<pre>";
			print_r($ratingdata);
			echo "</pre>"; */
			$db->insert('tbl_jawapan', $ratingdata);
		}
		//die();
		$this->view->entrySaved = true;
		/* echo '<script language="Javascript">';
		echo 'location.href="'.SYSTEM_URL.'/bkp/kajian/borang';
		echo '</script>'; */
		
	}
	
}

?>