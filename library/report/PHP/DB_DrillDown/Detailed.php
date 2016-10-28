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
    $jenis_id = $_GET['jenis_id'];
	$desc = $_GET['jenis_desc'];

    //Generate the graph element string
    $strXML = "<graph caption='Jenis Pita (". $desc. ")' subcaption='(In Unit)' xAxisName='Year' formatNumberScale='0' decimalPrecision='0'>";

    // Connet to the DB
    $link = connectToDB();

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
    $result = mysql_query($strQuery) or die(mysql_error());
   // die ($strQuery);
    //Iterate through each factory
    if ($result) {
        while($ors = mysql_fetch_array($result)) {
            //Here, we convert date into a more readable form for set name.
			//$strXML .= "<set name='" . $ors['jenis_desc'] . "' value='" . $ors2['jumlah'] . "' link='" . urlencode($sys_config['system_url']."?mod=report&opt=pita_thn&jenis_id=" . $ors['jenis_id'] . "&desc=" . $ors['jenis_id']) . "'/>";
			//
            $strXML .= "<set name='" . $ors['year'] . "' value='" . $ors['jumlah'] . "' color='" . getFCColor() . "' link='" . urlencode($sys_config['system_url']."?mod=report&opt=pita_bln&jenis_id=".$jenis_id."&year=" . $ors['year']) . "'/>";
        }
    }
    mysql_close($link);

    //Close <graph> element
    $strXML .= "</graph>";
	
    //Create the chart - Column 2D Chart with data from strXML
	echo renderChart($sys_config['includes_path']."pita/FusionCharts/FCF_Column3D.swf", "", $strXML, "FactoryDetailed", 1000, 600);
	//echo renderChart("../../FusionCharts/FCF_Column3D.swf", "", $strXML, "FactoryDetailed", 1000, 500);
?>
<BR>
<input type="button" name="cmd_back" value="Kembali" onClick="history.back()">
</CENTER>
</BODY>
</HTML>