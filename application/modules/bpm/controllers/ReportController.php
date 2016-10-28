<?php 

class Bpm_ReportController extends Spt_Controller_Action
{
	public function monthAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		//$kump = $db->fetchPairs("SELECT usr_id,usr_fullname FROM sys_user WHERE role_id = '4' ORDER BY usr_fullname ASC");
		
		$kump = $arr_month = array ('1'=> 'JANUARI',
							'2'=>'FEBRUARI',
							'3'=>'MAC',
							'4'=>'APRIL',
							'5'=>'MEI',
							'6'=>'JUN',
							'7'=>'JULAI',
							'8'=>'OGOS',
							'9'=>'SEPTEMBER',
							'10'=>'OKTOBER',
							'11'=>'NOVEMBER',
							'12'=>'DISEMBER'
							);
		
		//$kump = $arr_month
		/*$kump = $db->fetchPairs("SELECT usr_id,usr_fullname FROM sys_user WHERE 
						usr_id IN (SELECT DISTINCT(insert_by) FROM xpencen_pesara)
						ORDER BY usr_fullname ASC");*/
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			//$str_type		= 	$_POST['rad_type'] == '0' ? 'insert_by' : 'update_by';
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
			
			//$str_kod = $this->view->kod = $_POST['rad_pencen'];
		
			 $strXML = "<graph caption='Statistik Aduan' subCaption='Mengikut Bulan' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix='' >";

			$strQuery = "SELECT 
						  *
						 FROM
						  sys_user ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE usr_id IN ".$str_jenis."";
			}
			//die($strQuery);
			//$this->view->result = $result = $db->fetchPairs($strQuery);
			$this->view->result = $result = $kump;

			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									ea_aduan  
								 WHERE MONTH(insert_date) = '".$id."'";
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					//echo  $kump2.' '.$ors['jumlah']."<br>";
					$strXML .= "<set name='" . $kump2 . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/bpm/report/monthdetail/id/".$id."'/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Column3D.swf", "", $strXML, "FactorySum", 900, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function monthdetailAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		$this->view->function = $function = new Spt_Includes_Function;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		$this->view->bulan = $param_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		$this->view->str_type = $str_type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
		
		if(isset($param_id))
		{
			$strXML = "<graph caption='Statistik Aduan' subCaption='Mengikut Unit BPM ' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix='' >";

			$strQuery = "SELECT 
						  aduan_bpm, COUNT(aduan_id) AS bil
						 FROM
						  ea_aduan
						  WHERE MONTH(insert_date) = '".$param_id."'
						  GROUP BY aduan_bpm
						  ";	

						  $this->view->result = $result = $db->fetchPairs($strQuery);
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									ea_aduan  
								 WHERE MONTH(insert_date) = '".$param_id."'
								  AND aduan_bpm = '".$id."' ";
					
					$ors = $db->fetchRow($strQuery);
					$strXML .= "<set name='" . $function->getUnitBpmById($id) . "' value='" . $ors->jumlah . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//graf kedua
			$strXML2 = "<graph caption='Statistik Aduan' subCaption='Mengikut Bahagian ' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix='' >";

			$strQuery2 = "SELECT 
						  jhev_dept, COUNT(aduan_id) AS bil
						 FROM
						  ea_aduan, sys_user_detail
						  WHERE ea_aduan.insert_by = sys_user_detail.usr_id
						  AND MONTH(insert_date) = '".$param_id."'
						  GROUP BY jhev_dept
						  ";	

						  $this->view->result2 = $result = $db->fetchPairs($strQuery2);
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery2 = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									ea_aduan, sys_user_detail
								  WHERE ea_aduan.insert_by = sys_user_detail.usr_id
								  AND MONTH(insert_date) = '".$param_id."'
								  AND jhev_dept = '".$id."' ";
					
					$ors2 = $db->fetchRow($strQuery2);
					$strXML2 .= "<set name='" . $function->getDeptJhevById($id) . "' value='" . $ors2->jumlah . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML2 .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Column3D.swf", "", $strXML, "FactorySum", 800, 600);
			$this->view->chart2 = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Column3D.swf", "", $strXML2, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function pusatAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		//$kump = $db->fetchPairs("SELECT usr_id,usr_fullname FROM sys_user WHERE role_id = '4' ORDER BY usr_fullname ASC");
		$kump = $db->fetchPairs("SELECT pusat_id,pusat_name FROM tbl_pusat WHERE 
						pusat_id IN (SELECT DISTINCT(xpencen_office_pusatpendaftaran) FROM xpencen_pesara)
						ORDER BY pusat_id ASC");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			//$str_type		= 	$_POST['rad_type'] == '0' ? 'insert_by' : 'update_by';
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
			
			//$str_kod = $this->view->kod = $_POST['rad_pencen'];
		
			 $strXML = "<graph caption='Laporan Maklumbalas' subCaption='Mengikut Pusat Pendaftaran' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Orang' >";

			$strQuery = "SELECT 
						  pusat_id, pusat_name
						 FROM
						  tbl_pusat ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE pusat_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									xpencen_pesara  
								 WHERE xpencen_office_pusatpendaftaran = '".$id."'";
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					//echo  $kump2.' '.$ors['jumlah']."<br>";
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pelarasan/report/userdetail/id/".$id."'/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Doughnut3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function pusat2Action()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		//$kump = $db->fetchPairs("SELECT usr_id,usr_fullname FROM sys_user WHERE role_id = '4' ORDER BY usr_fullname ASC");
		$kump = $db->fetchPairs("SELECT pusat_id,pusat_name FROM tbl_pusat WHERE 
						pusat_id IN (SELECT DISTINCT(xpencen_office_pusatpendaftaran) FROM xpencen_pesara)
						ORDER BY pusat_id ASC");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			//$str_type		= 	$_POST['rad_type'] == '0' ? 'insert_by' : 'update_by';
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
			
			//$str_kod = $this->view->kod = $_POST['rad_pencen'];
		
			 $strXML = "<graph caption='Laporan Permohonan ' subCaption='Mengikut Pusat Pendaftaran' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Orang' >";

			$strQuery = "SELECT 
						  pusat_id, pusat_name
						 FROM
						  tbl_pusat ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE pusat_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				
				$strXML .= "<categories>";
				
				foreach($result as $id => $kump) {
					$strXML .= "<category label='".$kump."' />";
				}
				
				$strXML .= "</categories>";
				
				//Begin DataSet Lulus
				$strXML .= "<dataset seriesName='Lulus'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									xpencen_pesara  
								 WHERE xpencen_office_pusatpendaftaran = '".$id."'
								 AND xpencen_office_kelulusan = '1'";
					
					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pesara/report/pusat2detail/id/".$id."'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Lulus
				
				//Begin DataSet Tidak Lulus
				$strXML .= "<dataset seriesName='Tidak Lulus'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									xpencen_pesara  
								 WHERE xpencen_office_pusatpendaftaran = '".$id."'
								 AND xpencen_office_kelulusan = '2'";
					
					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pelarasan/report/userdetail/id/".$id."'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Tidak Lulus
				
				
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/MSColumn3D.swf", "", $strXML, "FactorySum", 1200, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function pusat2detailAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		$this->view->penyedia = $param_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		$this->view->str_type = $str_type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
		
		if(isset($param_id))
		{
			$str_date		= 	$str_type == 'insert_by' ? 'insert_date' : 'update_date';
			
			 $strXML = "<graph caption='Statistik Pusat Pendaftaran ' subCaption='Mengikut Tarikh' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix='' >";

			$strQuery = "SELECT 
						  DATE_FORMAT(insert_date,'%d-%m-%Y') AS tarikh, COUNT(xpencen_pesara_id) AS bil
						 FROM
						  xpencen_pesara 
						  WHERE xpencen_office_pusatpendaftaran = '".$param_id."'
						  GROUP BY DAY(insert_date)
						  ORDER BY DATE_FORMAT(".$str_date.",'%Y-%m-%d') ASC
						  ";	

						  $this->view->result = $result = $db->fetchPairs($strQuery);
			
			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $kump2) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									xpencen_pesara  
								 WHERE xpencen_office_pusatpendaftaran = '".$param_id."'
								  AND DATE_FORMAT(".$str_date.",'%d-%m-%Y') = '".$id."' ";
					//echo $strQuery."<br>";
					$ors = $db->fetchRow($strQuery);
					//echo  $kump2.' '.$ors['jumlah']."<br>";
					$strXML .= "<set name='" . $id . "' value='" . $ors['jumlah'] . "' link=''/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Column3D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function pusat3Action()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		//$kump = $db->fetchPairs("SELECT usr_id,usr_fullname FROM sys_user WHERE role_id = '4' ORDER BY usr_fullname ASC");
		$kump = $db->fetchPairs("SELECT pusat_id,pusat_name FROM tbl_pusat 
						ORDER BY pusat_id ASC");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			//$str_type		= 	$_POST['rad_type'] == '0' ? 'insert_by' : 'update_by';
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
			
			//$str_kod = $this->view->kod = $_POST['rad_pencen'];
		
			 $strXML = "<graph caption='Laporan Permohonan ' subCaption='Mengikut Pusat Pendaftaran' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix='' >";

			$strQuery = "SELECT 
						  pusat_id, pusat_name
						 FROM
						  tbl_pusat ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE pusat_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				
				$strXML .= "<categories>";
				
				foreach($result as $id => $kump) {
					$strXML .= "<category label='".$kump."' />";
				}
				
				$strXML .= "</categories>";
				
				//Begin DataSet Lulus
				$strXML .= "<dataset seriesName='Lulus'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									SUM(box_lulusbil) AS jumlah
								 FROM 
									xpencen_box  
								 WHERE box_pusat = '".$id."'";
					
					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pelarasan/report/userdetail/id/".$id."'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Lulus
				
				//Begin DataSet Tidak Lulus
				$strXML .= "<dataset seriesName='Tidak Lulus'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									SUM(box_xlulusbil) AS jumlah
								 FROM 
									xpencen_box  
								 WHERE box_pusat = '".$id."'";
					
					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pelarasan/report/userdetail/id/".$id."'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Tidak Lulus
				
				//Begin DataSet Perlu Semakan
				$strXML .= "<dataset seriesName='Semakan'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									SUM(box_semakbil) AS jumlah
								 FROM 
									xpencen_box  
								 WHERE box_pusat = '".$id."'";
					
					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pelarasan/report/userdetail/id/".$id."'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Perlu Semakan
				
				
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/MSColumn3D.swf", "", $strXML, "FactorySum", 1200, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
	public function baluAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		//$kump = $db->fetchPairs("SELECT usr_id,usr_fullname FROM sys_user WHERE role_id = '4' ORDER BY usr_fullname ASC");
		$kump = $db->fetchPairs("SELECT pusat_id,pusat_name FROM tbl_pusat WHERE 
						pusat_id IN (SELECT DISTINCT(xpencen_office_pusatpendaftaran) FROM xpencen_pesara)
						ORDER BY pusat_id ASC");
		
		$this->view->kump = $kump;
		
		//get value
		$jenis_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_id');
		$jenis_desc = Zend_Controller_Front::getInstance()->getRequest()->getParam('jenis_desc');
		$kodpencen = Zend_Controller_Front::getInstance()->getRequest()->getParam('kodpencen');
		
		if(isset($_POST['select_jenis']))
		{
			$arr_jenis		= 	$_POST['select_jenis'];
			//$str_type		= 	$_POST['rad_type'] == '0' ? 'insert_by' : 'update_by';
			$count_jenis 	= 	count($arr_jenis);
			$str_jenis 		= 	"('".$arr_jenis[0]."'";
			for($a=1;$a<$count_jenis;$a++)
				$str_jenis .= ",'".$arr_jenis[$a]."'";
			$str_jenis .= ")";
			
			//$str_kod = $this->view->kod = $_POST['rad_pencen'];
		
			 $strXML = "<graph caption='Statistik SVTB1M - Balu ' subCaption='Mengikut Pusat Pendaftaran' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix='' >";

			$strQuery = "SELECT 
						  pusat_id, pusat_name
						 FROM
						  tbl_pusat ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE pusat_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$this->view->result = $result = $db->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				
				$strXML .= "<categories>";
				
				foreach($result as $id => $kump) {
					$strXML .= "<category label='".$kump."' />";
				}
				
				$strXML .= "</categories>";
				
				//Begin DataSet Lulus
				$strXML .= "<dataset seriesName='Lulus'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									xpencen_pesara AS a, xpencen_balu AS b 
								 WHERE a.xpencen_pesara_id = b.pesara_id
								 AND a.xpencen_office_pusatpendaftaran = '".$id."'
								 AND a.xpencen_office_kelulusan = '1'";
					
					/* "SELECT c.pusat_name, a.xpencen_office_kelulusan, COUNT( * )
						FROM xpencen_pesara AS a, xpencen_balu AS b, tbl_pusat AS c
						WHERE a.xpencen_pesara_id = b.pesara_id
						AND a.xpencen_office_pusatpendaftaran = c.pusat_id
						GROUP BY pusat_name, xpencen_office_kelulusan" */

					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Lulus
				
				//Begin DataSet Tidak Lulus
				$strXML .= "<dataset seriesName='Tidak Lulus'>";
				
				foreach($result as $id => $kump) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									xpencen_pesara AS a, xpencen_balu AS b 
								 WHERE a.xpencen_pesara_id = b.pesara_id
								 AND a.xpencen_office_pusatpendaftaran = '".$id."'
								 AND xpencen_office_kelulusan = '2'";
					
					$ors = $db->fetchRow($strQuery);
					
					$strXML .= "<set name='" . $kump . "' value='" . $ors['jumlah'] . "' link='". Zend_Controller_Front::getInstance()->getBaseUrl()."/pelarasan/report/userdetail/id/".$id."'/>";
				}
				$strXML .= "</dataset>";
				//End DataSet Tidak Lulus
				
				
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";
			
			//Create the chart - Pie 3D Chart with data from strXML
			$this->view->chart = $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/MSColumn3D.swf", "", $strXML, "FactorySum", 1200, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		
		
    }
	
}