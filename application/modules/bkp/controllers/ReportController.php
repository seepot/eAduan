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
			
			$str_tahun = $this->view->tahun = $_POST['select_tahun'];
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Kumpulan Jawatan Tahun $str_tahun' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Orang' >";

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
								 WHERE umum_kumpjawatan = ".$id."
								  AND umum_tahun = '".$str_tahun."' ";
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
			
			$str_tahun = $this->view->tahun = $_POST['select_tahun'];
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Bahagian Tahun $str_tahun' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Orang' >";

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
								 WHERE umum_bahagian_id = ".$id."
								  AND umum_tahun = '".$str_tahun."' ";
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
			
			$str_tahun = $this->view->tahun = $_POST['select_tahun'];
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Kumpulan Jantina Tahun $str_tahun' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Orang' >";

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
								 WHERE umum_jantina = ".$id."
								  AND umum_tahun = '".$str_tahun."' ";
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
			
			$str_tahun = $this->view->tahun = $_POST['select_tahun'];
	
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Umur Tahun $str_tahun' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Orang' >";

			$strQuery = "SELECT * FROM tbl_tahun WHERE tahun_id IN ".$str_jenis."";	
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
								 WHERE umum_umur BETWEEN ".$kump2['tahun_min']." AND ".$kump2['tahun_max']."
								  AND umum_tahun = '".$str_tahun."' ";
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $kump2['tahun_name'] . "' value='" . $ors['jumlah'] . "' link=''/>";
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
		/* $jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('year'); */
		$soalan = Zend_Controller_Front::getInstance()->getRequest()->getParam('soalan');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('tahun');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
			
			$str_tahun = $this->view->tahun = $_POST['select_tahun'];
		
			$arr_skala = array();
			$xml = "<chart caption='Maklumbalas Mengikut Skala Mutu Perkhidmatan Tahun $str_tahun' xAxisName='Skala Mutu Perkhidmatan' yAxisName='Bil' showValues='1'>";
			
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
									 FROM tbl_jawapan 
									 LEFT OUTER JOIN tbl_umum 
									 ON tbl_jawapan.umum_id = tbl_umum.umum_id
									 WHERE skala = '".$i."'
									 AND soalan_id = '".$id."'
									 AND umum_tahun = '".$str_tahun."'";
					
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
				
				$xml .= "<dataset seriesName='".$i."' >";
				
				for($j=1;$j<=6;$j++){
				
					$xml .= "<set value='".$arr_skala[$i][$j]."' link='P-detailsPopUp,width=900,height=650,toolbar=no, scrollbars=no,resizable=no-".SYSTEM_URL."/bkp/report/perkhidmatan1/soalan/" . $j . "/tahun/".$str_tahun."'/>";
					//$xml .= "<set value='".$arr_skala[$i][$j]."' link='" . urlencode(SYSTEM_URL."/bkp/report/perkhidmatan/soalan/" . $j . "/tahun/".$str_tahun) . "'/>";
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
			
		
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/MSColumn3D.swf", "", $xml, "FactorySum", 900, 600);
		}
		if(isset($soalan) && isset($tahun))
		{
			$strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Soalan $soalan Perkhidmatan Tahun $tahun' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$this->view->result = $result = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $skala) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM tbl_jawapan 
								 LEFT OUTER JOIN tbl_umum 
									 ON tbl_jawapan.umum_id = tbl_umum.umum_id
								 WHERE skala = ".$id."
								 AND soalan_id = '".$soalan."'
								 AND umum_tahun = '".$tahun."' ";
			
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $skala . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			echo $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
    }
	
	public function perkhidmatan1Action()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$kump = $db->fetchPairs("SELECT jantina_id,jantina_name FROM tbl_jantina");
		
		$this->view->kump = $kump;
		
		//get value
		$soalan = Zend_Controller_Front::getInstance()->getRequest()->getParam('soalan');
		$tahun = Zend_Controller_Front::getInstance()->getRequest()->getParam('tahun');
		
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Soalan $soalan Perkhidmatan Tahun $tahun' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$this->view->result = $result = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5');
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $skala) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM tbl_jawapan 
								  LEFT OUTER JOIN tbl_umum 
									 ON tbl_jawapan.umum_id = tbl_umum.umum_id
								 WHERE skala = ".$id."
								 AND soalan_id = '".$soalan."'
								 AND umum_tahun = '".$tahun."' ";
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $skala . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			echo $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		
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