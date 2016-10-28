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
     
     if ($data=='states') {  // first dropdown
          echo "<select name='module' onChange=\"dochange('cities', this.value)\" dojoType='dijit.form.FilteringSelect'>\n";
          echo "<option value='0'>[--Pilih--]</option>\n";
          $result=mysql_db_query($dbname,"select `acl_module_id`, `acl_module_name` from acl_module order by `acl_module_name`");
          while(list($id, $name)=mysql_fetch_array($result)){
               echo "<option value=\"$id\" >$name</option> \n" ;
          }
     } else if ($data=='cities') { // second dropdown
          echo "<select name='resource' dojoType='dijit.form.FilteringSelect'>\n";
          echo "<option value='0'>[--Pilih--]</option>\n";                           
          $result=mysql_db_query($dbname,"SELECT `acl_resource_id`, `acl_resource_name` FROM acl_resource WHERE `acl_module_id` = '$val' ORDER BY `acl_resource_name` ");
          while(list($id, $name)=mysql_fetch_array($result)){       
               echo "<option value=\"$id\" >$name</option> \n" ;
          }
     } 
     echo "</select>\n";  
?>