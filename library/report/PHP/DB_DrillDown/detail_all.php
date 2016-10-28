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
	
<script language="JavaScript">

function pop()
{
  NewWindow=window.open('show-popup.php','newWin','width=400,height=300,left=0,top=0,toolbar=No,location=No,scrollbars=No,status=No,resizable=Yes,fullscreen=No');
  NewWindow.focus();
}
function ShowPopUpDialog(url)
{
   window.open(url,'MyPopUpWindow','height = 300px, width = 300px', true);  
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
		
}</script>

<style type="text/css">

#hintbox{ /*CSS for pop up hint box */
position:absolute;
top: 0;
background-color: lightyellow;
width: 150px; /*Default width of hint.*/ 
padding: 3px;
border:1px solid black;
font:normal 11px Verdana;
line-height:18px;
z-index:100;
border-right: 3px solid black;
border-bottom: 3px solid black;
visibility: hidden;
}

.hintanchor{ /*CSS for link that shows hint onmouseover*/
font-weight: bold;
color: navy;
margin: 3px 8px;
}

</style>

<script type="text/javascript">

/***********************************************
* Show Hint script- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/
		
var horizontal_offset="9px" //horizontal offset of hint box from anchor link

/////No further editting needed

var vertical_offset="0" //horizontal offset of hint box from anchor link. No need to change.
var ie=document.all
var ns6=document.getElementById&&!document.all

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
if (whichedge=="rightedge"){
var windowedge=ie && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-30 : window.pageXOffset+window.innerWidth-40
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure+obj.offsetWidth+parseInt(horizontal_offset)
}
else{
var windowedge=ie && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetHeight
}
return edgeoffset
}

function showhint(menucontents, obj, e, tipwidth){
if ((ie||ns6) && document.getElementById("hintbox")){
dropmenuobj=document.getElementById("hintbox")
dropmenuobj.innerHTML=menucontents
dropmenuobj.style.left=dropmenuobj.style.top=-500
if (tipwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=tipwidth
}
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+obj.offsetWidth+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+"px"
dropmenuobj.style.visibility="visible"
obj.onmouseout=hidetip
}
}

function hidetip(e){
dropmenuobj.style.visibility="hidden"
dropmenuobj.style.left="-500px"
}

function createhintbox(){
var divblock=document.createElement("div")
divblock.setAttribute("id", "hintbox")
document.body.appendChild(divblock)
}

if (window.addEventListener)
window.addEventListener("load", createhintbox, false)
else if (window.attachEvent)
window.attachEvent("onload", createhintbox)
else if (document.getElementById)
window.onload=createhintbox

</script>	
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
    $bln_thn = $_GET['bln_thn'];
	//$year = $_GET['year'];

    //Generate the graph element string
    $strXML = "<graph caption='Hari " . $bln_thn. "  ' subcaption='(In RM)' xAxisName='Date' formatNumberScale='0' decimalPrecision='0'>";

    // Connet to the DB
    $link = connectToDB();

    //Now, we get the data for that factory
	
	$strQuery = "SELECT ktpn_byr_trkh, ktpn_jum_byr 
				FROM 
				tbl_ktpn_byr_rst 
				WHERE 
				DATE_FORMAT(ktpn_byr_trkh, '%m-%Y')='" . $bln_thn ."'
				GROUP BY
					ktpn_byr_trkh";
	
    //$strQuery = "SELECT 
//				 ktpn_jum_byr
//				 FROM 
//				tbl_ktpn_byr_rst 
//				 WHERE 
//				 DATE_FORMAT(ktpn_byr_trkh, '%m-%Y')=" . $bln_thn ." 
//;";
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
	$str_url = "http://www.google.com";
	?>
	<!--<a onclick="Javascript:func_addForm('http://www.google.com')">aaa</a>-->
	<?
	//Iterate through each factory
    if ($result) {
        while($ors = mysql_fetch_array($result)) {
            //Here, we convert date into a more readable form for set name.
            $strXML .= "<set name='" . datePart("d",$ors['ktpn_byr_trkh']) . "/" . datePart("m",$ors['ktpn_byr_trkh']) . "' value='" . $ors['ktpn_jum_byr'] . "' color='" . getFCColor() . "' link='JavaScript:ShowPopUpDialog(window.open)' class='hintbox' />";
        }
    }
    mysql_close($link);

    //Close <graph> element
    $strXML .= "</graph>";
	
    //Create the chart - Column 2D Chart with data from strXML
	echo renderChart($sys_config['includes_path']."pita/FusionCharts/FCF_Line.swf", "", $strXML, "FactoryDetailed", 1000, 600);
	//echo renderChart("../../FusionCharts/FCF_Column3D.swf", "", $strXML, "FactoryDetailed", 1000, 600);
?>
<BR>
<input type="button" name="cmd_back" value="Kembali" onClick="history.back()">
</CENTER>
</BODY>
</HTML>