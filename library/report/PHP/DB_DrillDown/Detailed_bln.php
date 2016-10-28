<?php
//We've included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
//include("../Includes/FusionCharts.php");
//include("../Includes/DBConn.php");
////We've also included ../Includes/FC_Colors.asp, having a list of colors
////to apply different colors to the chart's columns. We provide a function for it - getFCColor()
//include("../Includes/FC_Colors.php");
include($sys_config['includes_path']."pita/PHP/Includes/FusionCharts.php");
include($sys_config['includes_path']."pita/PHP/Includes/DBConn.php");
include($sys_config['includes_path']."pita/PHP/Includes/FC_Colors.php");
?>
<HTML>
<HEAD>
	<TITLE>
	Unijaya FusionCharts - Performance
	</TITLE>
	<?php
	//You need to include the following JS file, if you intend to embed the chart using JavaScript.
	//Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	//When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	?>	
	<SCRIPT LANGUAGE="Javascript" SRC="<?= $sys_config['includes_path']."pita/FusionCharts/FusionCharts.js"; ?>"></SCRIPT>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</HEAD>
<BODY>

<CENTER>

<?php
    //This page is invoked from Default.php. When the user clicks on a pie
    //slice in Default.php, the factory Id is passed to this page. We need
    //to get that factory id, get information from database and then show
    //a detailed chart.

    //Request the factory Id from Querystring
    $year = $_GET['year'];
	$jenis_id = $_GET['jenis_id'];

    //Generate the graph element string
    $strXML = "<graph caption='Tahun " . $year. " ' subcaption='(In Unit)' xAxisName='Date' formatNumberScale='0' decimalPrecision='0'>";

    // Connet to the DB
    $link = connectToDB();

    //Now, we get the data for that factory
    /*
	$strQuery = "SELECT 
					DATE_FORMAT(ktpn_byr_trkh, '%m') AS month,  SUM(ktpn_jum_byr) AS jumlah, DATE_FORMAT(ktpn_byr_trkh, '%m-%Y') AS bln_thn
				 FROM 
					tbl_ktpn_byr_rst 
				 WHERE 
					DATE_FORMAT(ktpn_byr_trkh, '%Y')=" . $year ." 
				 GROUP BY 
					month";
	*/
	
	$strQuery = "SELECT DATE_FORMAT(flm_tape_tkh, '%m') AS month,  COUNT(flm_tape_id) AS jumlah, DATE_FORMAT(flm_tape_tkh, '%m-%Y') AS bln_thn
				 FROM tbl_flm_tape
				 WHERE (flm_tape ='PITA' or flm_tape='pita') AND jenis_id=" . $jenis_id ." AND DATE_FORMAT(flm_tape_tkh, '%Y')=" . $year ."
				 AND syk_id NOT IN (
					SELECT syk_id
					FROM tbl_syk
					WHERE stesyen_tv =1
				 )
				 GROUP BY month";
	//die($strQuery);
    $result = mysql_query($strQuery) or die(mysql_error());
	
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
//	switch ($ors['month']) {
//        case "01": $bulan= 'Januari';
//        case "02": $bulan= 'Februari';
//        case "03": $bulan= 'Mac';
//        case "04": $bulan= 'April';
//		case "05": $bulan= 'May';
//        case "06": $bulan= 'Jun';
//		case "07": $bulan= 'Julai';
//        case "08": $bulan= 'Ogos';
//		case "09": $bulan= 'September';
//        case "10": $bulan= 'Oktober';
//		case "11": $bulan= 'November';
//        case "12": $bulan= 'Disember';
//        }
	
	//Iterate through each factory
    if ($result) {
        while($ors = mysql_fetch_array($result)) {
            //Here, we convert date into a more readable form for set name.
			//$sys_config['system_url']."?mod=report&opt=pita_bln&year=" . $ors['year']) . "'/>";
			 //$strXML .= "<set name='" . $ors['year'] . "' value='" . $ors['jumlah'] . "' color='" . getFCColor() . "' link='" . urlencode($sys_config['system_url']."?mod=report&opt=pita_bln&year=" . $ors['year']) . "'/>";
			 
			 
			   $strXML .= "<set name='" . $arr_month[$ors['month']] . "' value='" . $ors['jumlah'] . "' color='" . getFCColor() . "' link='" . urlencode($sys_config['system_url']."?mod=report&opt=pita_day&jenis_id=".$jenis_id."&bln_thn=" . $ors['bln_thn']) . "'/>";
        }
    }
    mysql_close($link);

    //Close <graph> element
    $strXML .= "</graph>";
	
    //Create the chart - Column 2D Chart with data from strXML
	echo renderChart($sys_config['includes_path']."pita/FusionCharts/FCF_Column3D.swf", "", $strXML, "FactoryDetailed", 800, 600);
	//echo renderChart("../../FusionCharts/FCF_Column3D.swf", "", $strXML, "FactoryDetailed", 800, 600);
?>
<BR>
 <input type="button" name="cmd_back" value="Kembali" onClick="history.back()">
</CENTER>
</BODY>
</HTML>