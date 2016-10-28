<?
	/*** page protection ***/
	// this protect the user direct access to the page,
	// this should be included in every page, except /index.php (system entry)
	if (!defined("_VALID_ACCESS_KHEDN"))
	{	// denied direct access to the page
		header("HTTP/1.0 404 Not Found");
		exit();	// process terminated
	}	/*** end of page protection ***/

	require_once($sys_config['includes_path']."func_sorting_button.php");
	require_once($sys_config['includes_path']."func_aved_button.php");
	
	if(isset($_POST['tarikh']))
		$tarikh	=	$_POST['tarikh'];
	elseif(isset($_GET['tarikh']))
		$tarikh	=	$_GET['tarikh'];
	else
		$tarikh	=	'';
	
	
	func_header("Laporan Pita",
		$sys_config['includes_path']."css_calendar.css", // css	
		$sys_config['includes_path']."js_calendar.js,".		// external calendar js class
		$sys_config['includes_path']."js_calendar_may.js,". // calendar language
		$sys_config['includes_path']."js_calendar_setup.js,".	// external calendar setup
		$sys_config['includes_path']."js_trim.js", // javascript
		true, // menu
		false, // portlet
		false, // header
		false, // frame
		'', // str url frame top
		'', // str url frame left
		'', // str url frame content
		false // int top for [enter]
		);
		
		//func_window_open2("");

	$sql_criteria	=	" FROM `tbl_flm_tape` 
						WHERE DATE_FORMAT(flm_tape_tkh, '%Y%m%d' ) = '".$tarikh."'
						AND (
						flm_tape = 'PITA'
						OR flm_tape = 'pita'
						)
						AND jenis_id =1
						AND syk_id NOT 
						IN (

						SELECT syk_id
						FROM tbl_syk
						WHERE stesyen_tv =1
						)
						GROUP BY syk_id";
	
	$strQuery = "SELECT (SELECT syk_name FROM tbl_syk WHERE tbl_syk.syk_id = tbl_flm_tape.syk_id) AS nama_syarikat, COUNT( syk_id ) AS jumlah";
	$strQuery .= $sql_criteria;

	$res_select			=	$db->sql_query($strQuery,END_TRANSACTION) or die($strQuery);

?>

<? 

//require($mod_config['document_root']."report_header.php"); 
?>
<script language="JavaScript">

function func_sort(int_which_col)
	{
		int_col		=	document.getElementById("col").value;
		str_sort	=	document.getElementById("sort").value;
		if (int_which_col == int_col)
			document.getElementById("sort").value = ((str_sort == "asc") ? "desc" : "asc");
		else
			document.getElementById("sort").value = "asc";
		document.getElementById("col").value	=	int_which_col;
		document.getElementById("search").value = document.getElementById("previous_search").value;
		document.getElementById("form_name").submit();
	}
<!--
var gAutoPrint = true; // Flag for whether or not to automatically call the print function

function printSpecial()
{
	if (document.getElementById != null)
	{
		var html = '<HTML>\n<HEAD>\n';

		if (document.getElementsByTagName != null)
		{
			var headTags = document.getElementsByTagName("head");
			if (headTags.length > 0)
				html += headTags[0].innerHTML;
		}
		
		html += '\n</HE' + 'AD>\n<BODY>\n';
		
		var printReadyElem = document.getElementById("printReady");
		
		if (printReadyElem != null)
		{
				html += printReadyElem.innerHTML;
		}
		else
		{
			alert("Could not find the printReady section in the HTML");
			return;
		}
		html += '\n</BO' + 'DY>\n</HT' + 'ML>';
		
		var printWin = window.open("","printSpecial");
		printWin.document.open();
		printWin.document.write(html);
		printWin.document.close();
		if (gAutoPrint)
			printWin.print();
	}
	else
	{
		alert("Sorry, the print ready feature is only available in modern browsers.");
	}
}
//-->
</script>

<?php
	$sql_tarikh	=	"SELECT DATE_FORMAT(flm_tape_tkh, '%d-%m-%Y') AS tarikh";
	$sql_tarikh .= 	$sql_criteria;
	$res_tarikh	=	$db -> sql_query($sql_tarikh) or die($sql_tarikh);
	$row_tarikh =	$db -> sql_fetchrow($res_tarikh);

	$int_page_offset=0;
?>
<div id="printReady">
<?php 
	echo "<strong>Tarikh </strong>:".$row_tarikh['tarikh'];
	echo "<br /><br />"; 
?>

<table class="contents" width="100%" border="0" cellspacing="1" cellpadding="5">
	<tr class="label"> 
		<td width="7%" align="center">Bil</td>
		<td width="73%" align="center"><nobr>Nama Syarikat</nobr></td>
		<td width="20%" align="center"><nobr>Jumlah Pita</nobr></td>
	</tr>
	<?php
		$count = 0;
		if($db->sql_numrows($res_select) > 0)
		{
			while($row_select = $db->sql_fetchrow($res_select))
			{
				$int_page_offset++;
				
	?>
	<tr class="contents" onMouseOver="javascript: this.className='contents_mouseover';" onMouseOut="javascript: this.className='contents_mouseout';">
		<td align="center"><?php echo $int_page_offset ?></td>
		<td align="center"><?php echo html_entity_decode($row_select['nama_syarikat'], ENT_QUOTES); ?></td>
		<td align="center"><?php echo $row_select['jumlah']; ?></td>
	</tr>
	<?php 
				$count	+= 	$row_select['jumlah'];
			}
		
	?>
	<tr class="contents" onMouseOver="javascript: this.className='contents_mouseover';" onMouseOut="javascript: this.className='contents_mouseout';">
		<td align="right" colspan="2">Jumlah</td>
		<td align="center"><?php echo $count; ?></td>
	</tr>
	<?php
		}
		else
		{
	?>
	<tr class="contents">
		<td align="center" colspan="3"><br><? echo "Tiada Rekod" ?><br>&nbsp;</td>
	</tr>
	<?php
		}
	?>
</table>
</div>
<br />
<table class="contents" width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr class="contents">
    <td align="center"><input type="button" name="cmd_print" value="   Cetak   " onclick="javascript: printSpecial();" /></td></tr>
</table>
<?
	func_window_close2(); 
	func_footer(false,
				false
				);
?>

