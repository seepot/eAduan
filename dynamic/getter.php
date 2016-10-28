<?php

	include (conn.php);
	
	$dbhandle = mysql_connect($dbhost, $dbuser, $dbpass) or die("Unable to connect to MySQL");
	$selected = mysql_select_db($dbname, $dbhandle) or die("Could not select examples");
	$choice = mysql_real_escape_string($_GET['choice']);
	
	$query = "SELECT * FROM ea_kategoriMasalah WHERE km_bpm='$choice'";
	
        //echo ($query);
	$result = mysql_query($query);
		
	while ($row = mysql_fetch_array($result)) {
   		echo "<option>" . $row{'km_desc'} . "</option>";
	}
?>