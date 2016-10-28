<?php
	//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
	//functions to help us easily embed the charts and connect to a database.
	//include("../Includes/FusionCharts.php");
	//include("../Includes/DBConn.php");
	include(system_path."/library/report/PHP/Includes/FusionCharts.php");
	include(system_path."/library/report/PHP/Includes/DBConn.php");

?>

	<script language="Javascript" src="<?= system_path."/library/report/FusionCharts/FusionCharts.js"; ?>"></script>


<center>


<?php
    //In this example, we show how to connect FusionCharts to a database.
    //For the sake of ease, we've used an MySQL databases containing two
    //tables.
	$db2 = Zend_Registry::get ( 'db2' );
    // Connect to the DB
    $link = connectToDB();

    //$strXML will be used to store the entire XML document generated
    //Generate the graph element
    $strXML = "<graph caption='Laporan Pita' subCaption='Mengikut Jenis' pieSliceDepth='30' showBorder='1' showNames='1' formatNumberScale='0' numberSuffix=' Unit' >";

    // Fetch all factory records
    $strQuery = "SELECT 
				  *
				 FROM
				  tbl_flm_tape_jenis ";	
	if(isset($_POST['select_jenis']))
	{
		$strQuery .=	"WHERE jenis_id IN ".$str_jenis."";
	}
	//die($strQuery);
    $result = mysql_query($strQuery) or die(mysql_error());
	//print_r($db2);
    //Iterate through each factory
    if ($result) {
        while($ors = mysql_fetch_array($result)) {
            //Now create a second query to get details for this factory
			
            $strQuery = "SELECT 
							COUNT(*) AS jumlah 
						 FROM 
							tbl_flm_tape 
						 WHERE (flm_tape ='PITA' or flm_tape='pita')
						 AND jenis_id = ".$ors['jenis_id'];
			
			//die($strQuery);
            $result2 = mysql_query($strQuery) or die(mysql_error()); 
            $ors2 = mysql_fetch_array($result2);
            //$ors2 = $db2->fetchRow($strQuery);
			//print_r($ors2);
            //Note that we're setting link as Detailed.php?FactoryId=<<FactoryId>>
            $strXML .= "<set name='" . $ors['jenis_desc'] . "' value='" . $ors2['jumlah'] . "' link='" . urlencode(system_url."/report/test/report1/jenis_id/" . $ors['jenis_id'] . "/jenis_desc/" . $ors['jenis_desc']) . "'/>";
            //free the resultset
			//$strXML .= "<set name='" . $ors['cara_byr_desc'] . "' value='" . $ors2['jumlah'] . "' link='" . urlencode($sys_config['system_url']
 // ."?mod=report&opt=ktpn_hasil&cara_byr_id=" . $ors['cara_byr_id'] . "&cara_byr_desc=" . $ors['cara_byr_desc']) . "'/>";
			//
            //mysql_free_result($result2);
        }
    }
    //mysql_close($link);


    //Finally, close <graph> element
    $strXML .= "</graph>";

    //Create the chart - Pie 3D Chart with data from strXML
	echo renderChartHTML(system_url."/library/report/FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
    //echo renderChart("../../FusionCharts/FCF_Pie3D.swf", "", $strXML, "FactorySum", 800, 600);
?>
<br><br>

</center>
