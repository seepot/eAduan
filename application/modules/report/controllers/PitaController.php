<?php 
/* PitaController.php
Version 	: 2.13
Year 		: 2014
Created by 	: FusionCharts
Review by 	: BPM JHEV
System 		: eAduan

This controller is a function to produce Graphical Graf by using FusionCharts Libray.
*/


class Report_PitaController extends Spt_Controller_Action
{
	public function jenisAction()
	{
		//echo system_path;
		$db2 = Zend_Registry::get ( 'db2' );
		
		//includes chart
		$chart = new Spt_Includes_FusionCharts;
		$color = new Spt_Includes_FCColors;
		
		$pita = $db2->fetchPairs("SELECT jenis_id,jenis_desc FROM tbl_flm_tape_jenis");
		
		$this->view->pita = $pita;
		
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
		
			 $strXML = "<graph caption='Laporan Pita' subCaption='Mengikut Jenis' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

			$strQuery = "SELECT 
						  *
						 FROM
						  tbl_flm_tape_jenis ";	
			if(isset($_POST['select_jenis']))
			{
				$strQuery .=	"WHERE jenis_id IN ".$str_jenis."";
			}
			//die($strQuery);
			$result = $db2->fetchPairs($strQuery);

			//Iterate through each factory
			if ($result) {
				foreach($result as $id => $pita) {
				//while($ors = mysql_fetch_array($result)) {
					//Now create a second query to get details for this factory
					
					$strQuery = "SELECT 
									COUNT(*) AS jumlah 
								 FROM 
									tbl_flm_tape 
								 WHERE (flm_tape ='PITA' or flm_tape='pita')
								 AND jenis_id = ".$id;
					//echo $strQuery."<br>";
					$ors = $db2->fetchRow($strQuery);
					//die(print_r($ors));
					$strXML .= "<set name='" . $pita . "' value='" . $ors['jumlah'] . "' link='" . urlencode(SYSTEM_URL."/report/pita/jenis/jenis_id/" . $id . "/jenis_desc/" . $pita) . "'/>";
				}
			}

			//Finally, close <graph> element
			$strXML .= "</graph>";

			//Create the chart - Pie 3D Chart with data from strXML
			echo $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Pie2D.swf", "", $strXML, "FactorySum", 800, 600);
			//echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
		}
		
		if(isset($jenis_id) && isset($jenis_desc))
		{
			$strXML = "<graph caption='Jenis Pita (". $jenis_desc. ")' subcaption='(In Unit)' xAxisName='Tahun' yAxisName='Unit' formatNumberScale='0' decimalPrecision='0'>";
			//$strXML = "<chart caption='Jenis Pita (". $jenis_desc. ")' subcaption='(In Unit)' numdivlines='9' showValues='0' showAlternateVGridColor='1' numVisiblePlot='30'>";

			//Now, we get the data for that factory
			$strQuery = "SELECT DATE_FORMAT(flm_tape_tkh, '%Y') AS year,  COUNT(flm_tape_id) AS jumlah
						 FROM tbl_flm_tape
						 WHERE (flm_tape ='PITA' or flm_tape='pita') AND jenis_id=" . $jenis_id ."
						 AND syk_id NOT IN (
							SELECT syk_id
							FROM tbl_syk
							WHERE stesyen_tv =1
						 )
						 GROUP BY year";
			//$result = mysql_query($strQuery) or die(mysql_error());
			$result = $db2->fetchAll($strQuery);
			//die (print_r($result));
			//Iterate through each factory
			if ($result) {
				//while($ors = mysql_fetch_array($result)) {
				foreach($result as $ors){
					//Here, we convert date into a more readable form for set name.
					//$strXML .= "<set name='" . $ors['jenis_desc'] . "' value='" . $ors2['jumlah'] . "' link='" . urlencode($sys_config['system_url']."?mod=report&opt=pita_thn&jenis_id=" . $ors['jenis_id'] . "&desc=" . $ors['jenis_id']) . "'/>";
					//
					$strXML .= "<set name='" . $ors['year'] . "' value='" . $ors['jumlah'] . "' color='" . $color->getFCColor() . "' link='" . urlencode(SYSTEM_URL."/report/pita/jenis/jenis_id/" . $jenis_id . "/year/" . $ors['year']) . "'/>";
				}
			}

			//Close <graph> element
			//$strXML .= "</chart>";
			$strXML .= "</graph>";
			
			//Create the chart - Column 2D Chart with data from strXML
			echo $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Bar2D.swf", "", $strXML, "FactoryDetailed", 800, 600);
		}
		
		elseif(isset($jenis_id) && isset($tahun))
		{
			$strXML = "<graph caption='Tahun " . $tahun. " ' subcaption='(In Unit)' xAxisName='Bulan' yAxisName='Unit' formatNumberScale='0' decimalPrecision='0'>";
			
			$arr_month = array(
				'01' => 'Januari',
				'02' => 'Februari',
				'03' => 'Mac',
				'04' => 'April',
				'05' => 'Mei',
				'06' => 'Jun',
				'07' => 'Julai',
				'08' => 'Ogos',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'November',
				'12' => 'Disember'
			);

			$strQuery = "SELECT DATE_FORMAT(flm_tape_tkh, '%m') AS month,  COUNT(flm_tape_id) AS jumlah, DATE_FORMAT(flm_tape_tkh, '%m-%Y') AS bln_thn
				 FROM tbl_flm_tape
				 WHERE (flm_tape ='PITA' or flm_tape='pita') AND jenis_id=" . $jenis_id ." AND DATE_FORMAT(flm_tape_tkh, '%Y')=" . $tahun ."
				 AND syk_id NOT IN (
					SELECT syk_id
					FROM tbl_syk
					WHERE stesyen_tv =1
				 )
				 GROUP BY month";
		
			$result = $db2->fetchAll($strQuery);
			
			if ($result) {
				foreach($result as $ors){
					$strXML .= "<set name='" . $arr_month[$ors['month']] . "' value='" . $ors['jumlah'] . "' color='" . $color->getFCColor() . "' link='" . urlencode(SYSTEM_URL."/report/pita/jenis/jenis_id/" . $jenis_id . "/blnthn/" . $ors['bln_thn']) . "'/>";
				}
			}

			$strXML .= "</graph>";
	
			echo $chart->renderChartHTML(SYSTEM_URL."/library/report/FusionCharts/Column2D.swf", "", $strXML, "FactoryDetailed", 800, 600);
			
		}
		
    }
}