<?php
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
	
<script language="JavaScript">
function pop()
{
  NewWindow=window.open('show-popup.php','newWin','width=400,height=300,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
  NewWindow.focus();
}

function ShowPopUpDialog(url)
{
   window.open(url,'MyPopUpWindow','height = 600px, width = 400px', true);  
}

function func_addForm(url)
{
	x = 100;
	y = 100;
	statusWindow = "resizable=no,toolbar=no,statusbar=yes,scrollbars=yes,directories=no,menubar=no,width=600,height=350,top="+y+",left="+x;
	mywindow = window.open(url,"NewMessage",statusWindow);
	mywindow.moveTo(80,80);
}

function dialoguser(url)
{
	URLpage3 = url;
	
	x = 100;
	y = 0;
	statusWindow = "resizable=no,toolbar=no,scrollbars=yes,directories=no,menubar=no,width=700,height=450,top="+y+",left="+x;
	mywindow = window.open(URLpage3,"NewMessage",statusWindow);
	mywindow.moveTo(310,0);
		
}

function enable_iframe(values)
{
	//alert(values);
	document.getElementById('day').value = values;
	<?php //$day = "values"; ?>
	//alert(document.getElementById('day').value);
	//document.getElementById('iframe_detail').style.display = 'block';
	document.getElementById('display').value =	'block';
	document.frm_name.submit();
}
</script>
</head>
<body>

<center>
<form name="frm_name" id="frm_name" action="<?php $mod_config['self'] ?>" method="post">
	
<?php
    //This page is invoked from Default.php. When the user clicks on a pie
    //slice in Default.php, the factory Id is passed to this page. We need
    //to get that factory id, get information from database and then show
    //a detailed chart.

	if(isset($_POST['day']))
		$day	=	$_POST['day'];
	elseif(isset($_GET['day']))
		$day	=	$_GET['day'];
	else
		$day	=	'';
		
	if(isset($_POST['display']))
		$display	=	$_POST['display'];
	elseif(isset($_GET['display']))
		$display	=	$_GET['display'];
	else
		$display	=	'none';
	
	//echo "Day: ".$day."<br />";

	echo "<input type='hidden' name='day' id='day' value='".$day."' />";
	echo "<input type='hidden' name='display' id='display' value='".$display."' />";
	
    //Request the factory Id from Querystring
    if(isset($_POST['bln_thn']))
		$bln_thn	=	$_POST['bln_thn'];
	elseif(isset($_GET['bln_thn']))
		$bln_thn	=	$_GET['bln_thn'];
	else
		$bln_thn	=	0;
	
	if(isset($_POST['jenis_id']))
		$jenis_id	=	$_POST['jenis_id'];
	elseif(isset($_GET['jenis_id']))
		$jenis_id	=	$_GET['jenis_id'];
	else
		$jenis_id	=	0;
		
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
	
	$bulan	=	explode("-",$bln_thn);
		
    //Generate the graph element string
    $strXML = "<graph caption='Bulan " . $arr_month[$bulan[0]]. "  ' subcaption='(In Unit)' xAxisName='Date' formatNumberScale='0' decimalPrecision='0'>";

    // Connet to the DB
    $link = connectToDB();

    //Now, we get the data for that factory
	$strQuery =	"SELECT DATE_FORMAT(flm_tape_tkh, '%Y-%m-%d') AS day, DATE_FORMAT(flm_tape_tkh, '%Y%m%d') AS day1,  COUNT(flm_tape_id) AS jumlah
				 FROM tbl_flm_tape
				 WHERE (flm_tape ='PITA' or flm_tape='pita') 
				 AND jenis_id=" . $jenis_id ." 
				 AND DATE_FORMAT(flm_tape_tkh, '%m-%Y')='" . $bln_thn ."'
				 AND syk_id NOT IN (
					SELECT syk_id
					FROM tbl_syk
					WHERE stesyen_tv =1
				 )
				 GROUP BY day";
	
	//die($strQuery);
    $result = mysql_query($strQuery) or die(mysql_error());
	
  

    if ($result) {
        while($ors = mysql_fetch_array($result)) 
		{
			///echo $ors['day1']."<br />";
            //Here, we convert date into a more readable form for set name.
            $strXML .= "<set name='" . datePart("d",$ors['day']) . "/" . datePart("m",$ors['day']) . "' value='" . $ors['jumlah'] . "' color='" . getFCColor() . "' link='javascript:enable_iframe(".$ors['day1'].") '/>";
        }
    }
		
    mysql_close($link);

    //Close <graph> element
    $strXML .= "</graph>";
	
    //Create the chart - Column 2D Chart with data from strXML
	echo renderChart($sys_config['includes_path']."pita/FusionCharts/FCF_Line.swf", "", $strXML, "FactoryDetailed", 1000, 600);
	
?>

<?php 
echo 
"
<div id=iframe_detail style=display:".$display.">
<iframe src =".$sys_config['system_url']."?mod=report&opt=pita_all&tarikh=".$day." height = 400px width = 650px frameborder = 1 scrolling = yes>
</iframe>
</div>
";
?>
<br />
</form>
<input type="button" name="cmd_back" value="Kembali" onClick="history.back()">
</center>
</body>
</html>