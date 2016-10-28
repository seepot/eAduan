<?php 

class Bkp_ReportController extends Spt_Controller_Action
{
	public function jawatanAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchPairs("SELECT kumpjawatan_id,kumpjawatan_name FROM tbl_kumpjawatan");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('year');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Kumpulan Jawatan' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$strQuery = "SELECT 
						  *
						 FROM
						  tbl_kumpjawatan ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE kumpjawatan_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									tbl_umum 
								 WHERE umum_kumpjawatan = ".$id;
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $kump2 . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function bahagianAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchPairs("SELECT bahagian_id,bahagian_nama FROM tbl_bahagian");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('year');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Bahagian' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$strQuery = "SELECT 
						  *
						 FROM
						  tbl_bahagian ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE bahagian_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									tbl_umum 
								 WHERE umum_bahagian_id = ".$id;
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $kump2 . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
    }
	
	public function jantinaAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchPairs("SELECT jantina_id,jantina_name FROM tbl_jantina");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('year');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Kumpulan Jantina' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$strQuery = "SELECT 
						  *
						 FROM
						  tbl_jantina ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE jantina_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									tbl_umum 
								 WHERE umum_jantina = ".$id;
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $kump2 . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
    }
	
	public function umurAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchAll("SELECT DISTINCT(umum_umur) FROM tbl_umum");
		
		$this->view->kump = $kump;
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
	
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Umur' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$strQuery = "SELECT DISTINCT(umum_umur) FROM tbl_umum WHERE umum_tahun='2009' AND umum_umur IN ".$str_jenis."";	
			/* if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE jantina_id IN ".$str_jenis."";
			} */
			//die($strQuery);
			$this->view->result = $result = $db->fetchAll($strQuery);
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									tbl_umum 
								 WHERE umum_umur = ".$kump2['umum_umur'];
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $kump2['umum_umur'] . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
    }
	
	public function perkhidmatanAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchPairs("SELECT soalan_id,soalan_desc FROM tbl_soalan WHERE soalan_status = '1'");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('year');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
		
			$arr_skala = array();
			$xml = "<chart caption='Maklumbalas Mengikut Perkhidmatan' xAxisName='Perkhidmatan' yAxisName='Bil' showValues='1'>";
			
			$strQuery = "SELECT 
						  *
						 FROM
						  tbl_soalan ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE soalan_id IN ".$str_jenis."";
			}
			$this->view->result = $result = $db->fetchPairs($strQuery);
			
			$xml .= "<categories>";
			
			if ($result) {
				foreach($result as $id => $kump2) {

					$xml .= "<category label='".$kump2."' />";
					
					for($i=1;$i<=5;$i++){
						$strQuery2 = "SELECT 
										COUNT(*) AS jumlah 
									 FROM 
										tbl_jawapan 
									 WHERE skala = '".$i."'
									 AND soalan_id = '".$id."'";
					
						$ors2 = $db->fetchRow($strQuery2);
						$arr_skala[$i][$id] = $ors2['jumlah'];
					}
				}
			}
			
			$xml .= "</categories>";
			
			/* echo "<pre>";
			print_r($arr_skala);
			echo "</pre>"; */
			
			for($i=1;$i<=5;$i++){
				
				$xml .= "<dataset seriesName='".$i."'>";
				
				for($j=1;$j<=6;$j++){
				
					$xml .= "<set value='".$arr_skala[$i][$j]."' />";
				
				}
				
				$xml .= "</dataset>";
			}
			$xml .= "<trendlines>
					  <line startValue='26000' color='91C728' displayValue='Target' showOnTop='1'/>
				   </trendlines>

				   <styles>

					  <definition>
						 <style name='CanvasAnim' type='animation' param='_xScale' start='0' duration='1' />
					  </definition>

					  <application>
						 <apply toObject='Canvas' styles='CanvasAnim' />
					  </application>   

				   </styles>
				</chart>";
			
		
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/MSColumn3D.swf", "", $xml, "FactorySum", 600, 400);
		}
		
    }
	
	public function cadanganAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchAll("SELECT umum_komen FROM tbl_umum WHERE umum_tahun='2009'");
		
		$this->view->kump = $kump;
		
    }
}