<?php
     //set IE read from page only not read from cache
	 
     header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
     header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
     header ("Cache-Control: no-cache, must-revalidate");
     header ("Pragma: no-cache");
     
     header("content-type: application/x-javascript; charset=tis-620");
	
	 //set database
	include('conn.php');

    $data=$_GET['data'];
    $val=$_GET['val'];
     
	mysql_pconnect($dbhost,$dbuser,$dbpass) or die ("Unable to connect to MySQL server");  
     
     if ($data=='state') {  // first dropdown
          echo "<select name='negeri' onChange=\"dochange('district', this.value)\">\n";
          echo "<option value='0'>[--Sila Pilih Negeri--]</option>\n";
          $result=mysql_db_query($dbname,"SELECT `sta_id`, `sta_name` from sys_state");
          while(list($id, $name)=mysql_fetch_array($result)){
               echo "<option value=\"$id\" >$name</option> \n" ;
          }
     } else if ($data=='district') { // second dropdown
          echo "<select name='daerah'>\n";
          echo "<option value='0'>[--Sila Pilih Daerah--]</option>\n";                           
          $result=mysql_db_query($dbname,"SELECT `district_id`, `district_name` FROM sys_district  WHERE `sta_id` = '$val'");
          while(list($id, $name)=mysql_fetch_array($result)){       
               echo "<option value=\"$id\" >$name</option> \n" ;
          }
     }if ($data=='state2') {  // first dropdown
          echo "<select name='negeri2' onChange=\"dochange('district2', this.value)\">\n";
          echo "<option value='0'>[--Sila Pilih Negeri--]</option>\n";
          $result=mysql_db_query($dbname,"SELECT `sta_id`, `sta_name` from sys_state");
          while(list($id, $name)=mysql_fetch_array($result)){
               echo "<option value=\"$id\" >$name</option> \n" ;
          }
     } else if ($data=='district2') { // second dropdown
          echo "<select name='daerah2'>\n";
          echo "<option value='0'>[--Sila Pilih Daerah--]</option>\n";                           
          $result=mysql_db_query($dbname,"SELECT `district_id`, `district_name` FROM sys_district  WHERE `sta_id` = '$val'");
          while(list($id, $name)=mysql_fetch_array($result)){       
               echo "<option value=\"$id\" >$name</option> \n" ;
          }
     }
     echo "</select>\n";  
?>