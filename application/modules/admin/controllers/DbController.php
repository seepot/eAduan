<?php

class Admin_DbController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/db/list');
	}
	
	public function listAction()
    {
		//setting
		$dbhost = '192.168.110.184';
		$dbuser = 'jhevonline';
		$dbpass = 'P@ssjh3vBPM';
		$dbname = 'jhev_eaduan';
		
		$this->view->translate = $this->translate();
		
		if (!isset($_GET['del'])) $_GET['del']=FALSE;
		
		if ($_GET['del']) {
			$out=$this->PMBP_delete_backup_files($_GET['del']);
			if($out)
				echo $out;
			else
				echo "<div class=\"success\">".$this->translate()->_("Fail berjaya dihapuskan.")."</div>\n";
		}

		$all_files=$this->PMBP_get_backup_files();
		//echo strftime('%d/%m/%Y','1398329646');
		echo "<table id=\"unijaya\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\" width=\"100%\">\n";
		echo "<tr><th width='8%'>Bil</th><th>Nama Fail</th><th>Tarikh Backup</th><th>Saiz</th><th>Aktiviti</th></tr>";
		// list all backup files
		if (is_array($all_files)) {
			$int_page_offset = 0;
			$last_backup=0;
			$size_sum=0;

			// print html table
			foreach($all_files as $filename) {
				$int_page_offset++;
				$file=DB_PATH.$filename;
				$time=$this->PMBP_file_info("time",$file);
				//echo $file."<br>";
				echo "<tr ".$this->PMBP_change_color("#FFFFFF","#000000").">\n";
				echo "<td>".$int_page_offset."</td>\n";
				echo "<td>\n".$filename."</td>\n";
				echo "<td>".strftime('%d/%m/%Y',$time)."</td>\n";
				//echo "<td>".strftime('%d/%m/%Y',$time=$this->PMBP_file_info("time",$file))."</td>\n";
				if ($time>$last_backup) $last_backup=$time;
				$size_sum+=$size=$this->PMBP_file_info("size",$file);
				$size=$this->PMBP_size_type($size);
				echo "<td>".$size['value']." ".$size['type']."</td>\n";
				echo "<td>";
				echo $this->PMBP_pop_up(SYSTEM_URL."/admin/db/info?file=".$filename,"<img title='Info' src=\"".IMAGES_PATH."icon/info.gif\">","info")."\n";
				//echo "<td>".$this->PMBP_pop_up(SYSTEM_URL."/admin/db/view?file=".$filename,B_INFO,"info")."\n";
				echo $this->PMBP_pop_up(SYSTEM_URL."/admin/db/view?file=".$filename,"<img title='Papar' src=\"".IMAGES_PATH."icon/view.png\">","view")."\n";
				echo $this->PMBP_pop_up(SYSTEM_URL."/admin/db/restore?file=".$filename,"<img title='Restore' src=\"".IMAGES_PATH."icon/restore.png\">","info")."\n";
				echo "<a href=\"".SYSTEM_URL."/admin/db/import?file=".$filename."\"><img title='Muat Turun' src=\"".IMAGES_PATH."icon/dload.gif\"></a>\n";
				//echo $this->PMBP_confirm("Pasti?","import.php?del=".$filename,"Hapus")."\n";
				echo "<a onclick=\"confirmSetLocation('Are you sure?', '".SYSTEM_URL."/admin/db/list?del=".$filename."')\"><img src=\"".IMAGES_PATH."icon/del.png\" title=\"Hapus\" style=\"cursor:pointer;\"></a>";
				echo "</td>\n";
				
			}
		} else {

			// if there are no backup files
			echo "<tr>\n<td colspan=\"5\"><div class=\"bold\" style=\"text-align:center;\">- Tiada Rekod -</div>\n</td>\n</tr>\n";
		}

		echo "</table>\n";
			
    }

	public function backupAction()
    {
		$form = new Spt_Form_Admin_Db_BackupAdd;
		
		$this->view->translate = $this->translate();
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
			
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		$backupfile=$this->PMBP_dump($values['tables'],$values['data'],$values['drop'],$values['zip'],$values['backupDesc']);
	
		// is there no db connection or a db missing?
		if ($backupfile && $backupfile!=="DB_ERROR") {
			// change mode to 0777                    
			@chmod($backupfile,0777);
			
			//save to dbase
			/* $table = new SysDbBackup;
			$data = array(
				'db_filename' => $backupfile,
				'db_desc' => Zend_Filter::get($values['backupDesc'], 'HtmlEntities'),
				'db_date_created' => date('Y-m-d H:i:s'),
				'db_user_created' => Zend_Auth::getInstance()->getIdentity()->usr_id
			);
			$table->insert($data); */
		}
        $this->view->entrySaved = true;
	}
	
	public function importAction()
    {
		Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx5'
            )
        );
		
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".basename($_GET['file']));
		readfile(DB_PATH.$_GET['file']);
		
		return;
		
		$this->_redirect('/admin/db/list');
	}
	
	public function viewAction()
    {
		Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx5'
            )
        );
		
		echo "<pre>";
		while($line=$this->PMBP_getln($_GET['file'])) echo htmlentities($line);
		$this->PMBP_getln($_GET['file'],true);
		echo "</pre>";
		
		return;
	}
	
	public function infoAction()
    {
		Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx5'
            )
        );
		
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"
		   \"http://www.w3.org/TR/html4/loose.dtd\">
		<html>
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html;charset=ISO-8859-1\">
		<link rel=\"stylesheet\" href=\"".CSS_PATH."standard.css\" type=\"text/css\">
		<title>Info - ".$_GET['file']."</title>
		</head>
		<body>
		<table border=\"0\" cellspacing=\"2\" cellpadding=\"0\" width=\"100%\">\n
		<tr><th colspan=\"2\" class=\"active\">\n";
		echo $this->PMBP_image_tag(IMAGES_PATH."spt/jata.png","phpMyBackupPro PMBP_WEBSITE","xx");
		echo "\n</th></tr>\n";

		// get and print the informations about the $_GET['file'] backup file
		if ($_GET['file']) {
			echo "<tr><td><div class=\"bold_left\"><br><br>".$this->translate()->_("Tarikh").":</div></td><td><br><br>".strftime('%d/%m%Y',$this->PMBP_file_info("time",DB_PATH.$_GET['file']))."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".$this->translate()->_("Pangkalan Data").":</div></td><td>".$this->PMBP_file_info("db",DB_PATH.$_GET['file'])."</td></tr>\n";
			$size=$this->PMBP_size_type($this->PMBP_file_info("size",DB_PATH.$_GET['file']));
			echo "<tr><td><div class=\"bold_left\">".$this->translate()->_("Saiz Backup").":</div></td><td>".$size['value']." ".$size['type']."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".$this->translate()->_("Is compressed").":</div></td><td>".$this->PMBP_file_info("comp",$_GET['file'])."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".$this->translate()->_("Contains 'drop table'").":</div></td><td>".$this->PMBP_file_info("drop",$_GET['file'])."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".$this->translate()->_("Contains tables").":</div></td><td>".$this->PMBP_file_info("tables",$_GET['file'])."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".$this->translate()->_("Contains data").":</div></td><td>".$this->PMBP_file_info("data",$_GET['file'])."</td></tr>\n";
			echo "<tr><td colspan=\"2\"><br><div class=\"bold_left\">".$this->translate()->_("Komen").":</div></td></tr>\n";
			echo "<tr><td colspan=\"2\">".$this->PMBP_file_info("comment",$_GET['file'])."</td></tr>\n";
		} else{

		// return error message if no file was selected
			echo "<tr><td><div class=\"bold\">".$this->translate()->_("Tiada Fail Dipilih")."!</div></td></tr>\n";
		}

		echo "</table>\n</body>\n</html>";
		
		return;
		
	}
		
	protected function PMBP_dump($tables,$data,$drop,$zip,$comment)
    {
		//setting
		$dbhost = '192.168.110.184';
		$dbuser = 'jhevonline';
		$dbpass = 'P@ssjh3vBPM';
		$dbname = 'jhev_eaduan';
		$error=FALSE;
		// set max string size before writing to file
		if (@ini_get("memory_limit")) $max_size=900000*ini_get("memory_limit");
			else $max_size=$PMBP_SYS_VAR['memory_limit'];
		
		// set backupfile name
		$time=time();
		$backupfile="iim_tempahan-".$time.".sql";
		
		if ($zip=="gzip") $backupfile=$dbname.".".$time.".sql.gz";
			else $backupfile=$dbname.".".$time.".sql";
		
		//$backupfile=DB_PATH.$backupfile;
		if ($con=@mysql_connect($dbhost,$dbuser,$dbpass)) {
			//echo $backupfile;
			//create comment
			$out="# MySQL dump of database '".$dbname."' on host '".$dbhost."'\n";
			$out.="# backup date and time: ".date('d-M-Y H:i:s')."\n";
			$out.="# Template Zend\n\n";
			
			// write users comment
			if ($comment) {
				$out.="# comment:\n";
				$comment=preg_replace("'\n'","\n# ","# ".$comment);
				foreach(explode("\n",$comment) as $line) $out.=$line."\n";
				$out.="\n";
			}
		
			// print "use database" if more than one databas is available
			$out.="CREATE DATABASE IF NOT EXISTS `".$dbname."`;\n\n";
            $out.="USE `".$dbname."`;\n";
			
			// select db
			@mysql_select_db($dbname);
			
			// get auto_increment values and names of all tables
			$res=mysql_query("show table status");
			$all_tables=array();
			while($row=mysql_fetch_array($res)) $all_tables[]=$row;
			
			// get table structures
			foreach ($all_tables as $table) {
				$res1=mysql_query("SHOW CREATE TABLE `".$table['Name']."`");
				$tmp=mysql_fetch_array($res1);
				$table_sql[$table['Name']]=$tmp["Create Table"];
			}
			
			// find foreign keys
			$fks=array();
			if (isset($table_sql)) {
				foreach($table_sql as $tablenme=>$table) {
					$tmp_table=$table;
					// save all tables, needed for creating this table in $fks
					while (($ref_pos=strpos($tmp_table," REFERENCES "))>0) {
						$tmp_table=substr($tmp_table,$ref_pos+12);
						$ref_pos=strpos($tmp_table,"(");
						$fks[$tablenme][]=substr($tmp_table,0,$ref_pos);
					}
				}
			}
			
			// order $all_tables and check for ring constraints
			$all_tables_copy = $all_tables;
			$all_tables=$this->PMBP_order_sql_tables($all_tables,$fks);
			$ring_contraints = false;
			
			// ring constraints found
			if ($all_tables===false) {
				$ring_contraints = true;
				$all_tables = $all_tables_copy;
				
				$out.="\n# ring constraints workaround\n";
				$out.="SET FOREIGN_KEY_CHECKS=0;\n"; 
				$out.="SET AUTOCOMMIT=0;\n";
				$out.="START TRANSACTION;\n"; 
			}
			unset($all_tables_copy);
			
			// as long as no error occurred
			if (!$error) {
				foreach ($all_tables as $row) {
					$tablename=$row['Name'];
					$auto_incr[$tablename]=$row['Auto_increment'];

					// don't backup tables in $PMBP_SYS_VAR['except_tables']
					//if (in_array($tablename,explode(",",$PMBP_SYS_VAR['except_tables'])))
					//	continue;

					$out.="\n\n";
					// export tables
					if ($tables) {
						$out.="### structure of table `".$tablename."` ###\n\n";
						if ($drop) $out.="DROP TABLE IF EXISTS `".$tablename."`;\n\n";
						$out.=$table_sql[$tablename];

						// add auto_increment value
						if ($auto_incr[$tablename]) {
							$out.=" AUTO_INCREMENT=".$auto_incr[$tablename];
						}
						$out.=";";
					}
					$out.="\n\n\n";

					// export data
					if ($data && !$error) {
						$out.="### data of table `".$tablename."` ###\n\n";

						// check if field types are NULL or NOT NULL
						$res3=mysql_query("show columns from `".$tablename."`");

						$res2=mysql_query("select * from `".$tablename."`");
						for ($j=0;$j<mysql_num_rows($res2);$j++){
							$out .= "insert into `".$tablename."` values (";
							$row2=mysql_fetch_row($res2);
							// run through each field
							for ($k=0;$k<$nf=mysql_num_fields($res2);$k++) {
								// identify null values and save them as null instead of ''
								if (is_null($row2[$k])) $out .="null"; else $out .="'".mysql_escape_string($row2[$k])."'";
								if ($k<($nf-1)) $out .=", ";
							}
							$out .=");\n";

							// if saving is successful, then empty $out, else set error flag
							if (strlen($out)>$max_size) {
								if ($out=$this->PMBP_save_to_file($backupfile,$zip,$out,"a")) $out=""; else $error=TRUE;
							}
						}

					// an error occurred! Try to delete file and return error status
					} elseif ($error) {
						@unlink(DB_PATH.$backupfile);
						return FALSE;
					}

					// if saving is successful, then empty $out, else set error flag
					if (strlen($out)>$max_size) {
						if ($out=$this->PMBP_save_to_file($backupfile,$zip,$out,"a")) $out=""; else $error=TRUE;
					}
				}
				
			// an error occurred! Try to delete file and return error status
			} else {
				@unlink("./".$backupfile);
				return FALSE;
			}
			
			// if db contained ring constraints        
			if ($ring_contraints) {
				$out.="\n\n# ring constraints workaround\n";
				$out .= "SET FOREIGN_KEY_CHECKS=1;\n"; 
				$out .= "COMMIT;\n"; 
			}
			
			// save to file
			if ($backupfile=$this->PMBP_save_to_file($backupfile,$zip,$out,"a")) {
				if ($zip!="zip") return basename($backupfile);
			} else {
				@unlink("./".$backupfile);
				return FALSE;
			}
			
			// create zip file in file system
			//include_once("pclzip.lib.php");
			//echo $backupfile;
			$pclzip = new PclZip(DB_PATH.$backupfile.".zip");
			$pclzip->create($backupfile,PCLZIP_OPT_REMOVE_PATH,DB_PATH);    	

			// remove temporary plain text backup file used for zip compression
			@unlink(substr($backupfile,0,strlen($backupfile)));
			 
			if ($pclzip->error_code==0) {
				return basename($backupfile).".zip";
			} else {
				// print pclzip error message
				echo "<div class=\"red\">pclzip: ".$pclzip->error_string."</div>";

				// remove temporary plain text backup file 
				@unlink(substr($backupfile,0,strlen($backupfile)-4));
				@unlink($backupfile);
				return FALSE;
			}
		}
	}
	
	// orders the tables in $tables according to the constraints in $fks
	// $fks musst be filled like this: $fks[tablename][0]=needed_table1; $fks[tablename][1]=needed_table2; ...
	protected function PMBP_order_sql_tables($tables,$fks) 
	{
		// do not order if no contraints exist
		if (!count($fks)) return $tables;

		// order
		$new_tables=array();
		$existing=array();
		$modified=TRUE;
		while(count($tables) && $modified==TRUE) {
			$modified=FALSE;
			foreach($tables as $key=>$row) {
				// delete from $tables and add to $new_tables
				if (isset($fks[$row['Name']])) {
					foreach($fks[$row['Name']] as $needed) {
						// go to next table if not all needed tables exist in $existing
						if(!in_array($needed,$existing)) continue 2;
					}
				}
				
				// delete from $tables and add to $new_tables
				$existing[]=$row['Name'];
				$new_tables[]=$row;
				prev($tables);
				unset($tables[$key]);
				$modified=TRUE;
			}
		}

		if (count($tables)) {
			// probably there are 'circles' in the constraints, because of that no proper backups can be created
			// This will be fixed sometime later through using 'alter table' commands to add the constraints after generating the tables.
			// Until now I just add the lasting tables to $new_tables, return them and print a warning
			foreach($tables as $row) $new_tables[]=$row;
			//echo "<div class=\"red_left\">THIS DATABASE SEEMS TO CONTAIN 'RING CONSTRAINTS'. pMBP DOES NOT SUPPORT THEM. PROBABLY THE FOLLOWING BACKUP IS BROKEN!</div>";
			return false;
		}
		return $new_tables;
	}
	
	// saves the string in $fileData to the file $backupfile as gz file or not ($zip)
	// returns backup file name if name has changed (zip), else TRUE. If saving failed, return value is FALSE
	protected function PMBP_save_to_file($backupfile,$zip,&$fileData,$mode) {
		//echo $backupfile." ".$zip;
		// save to a gzip file
		if ($zip=="gzip") {
			if ($zp=@gzopen(DB_PATH.$backupfile,$mode."9")) {
				@gzwrite($zp,$fileData);
				@gzclose($zp);            
				return $backupfile;
			} else {
				return FALSE;
			}

		// save to a plain text file (uncompressed)
		} else if ($zip=="zip") {
			if ($zp=@fopen($backupfile,$mode)) {
				@fwrite($zp,$fileData);
				@fclose($zp);
				return $backupfile;
			} else {
				return FALSE;
			}
		} else {
			if ($zp=@fopen(DB_PATH.$backupfile,$mode)) {
				@fwrite($zp,$fileData);
				@fclose($zp);
				return $backupfile;
			} else {
				return FALSE;
			}
		}
	}
	
	// returns the content of the [gziped] $path backup file line by line
	protected function PMBP_getln($path, $close=false, $org_path=false) 
	{
		if (!isset($GLOBALS['lnFile'])) $GLOBALS['lnFile']=null;
		if (!$org_path) $org_path=$path; else $org_path=DB_PATH.$org_path;
			
		// gz file
		if($this->PMBP_file_info("gzip",$org_path)=="gz") {            
			if (!$close) {
				if ($GLOBALS['lnFile']==null) {
					$GLOBALS['lnFile']=gzopen($path, "r");
				}

				if (!gzeof($GLOBALS['lnFile'])) {
				   return gzgets($GLOBALS['lnFile']);
				} else {
					$close=true;
				}
			}

			if ($close) {
				// remove the file handler
				@gzclose($GLOBALS['lnFile']);
				$GLOBALS['lnFile']=null;
				return null;
			}

		// zip file
		} elseif($this->PMBP_file_info("zip",$org_path)=="zip"){
			if (!$close) {
				if ($GLOBALS['lnFile']==null) {
					// try to guess the filename of the packed file
					// known problem: ZIP file xyz.sql.zip contains file abc.sql which already exists with different content! 
					if(!file_exists(substr($org_path,0,strlen($org_path)-4))) {
						// extract the file
						//include_once("pclzip.lib.php");
						$pclzip = new PclZip(DB_PATH.$path);
						$extracted_file=$pclzip->extract(DB_PATH,"");
						//echo substr($org_path,0,strlen($org_path)-4);
						//die();
						//echo $pclzip->error_code;
						if ($pclzip->error_code!=0) {
							// print pclzip error message
							echo "<div class=\"red\">pclzip: ".$pclzip->error_string."<br>!</div>";
							return false;
						} else {
							unset($pclzip);
						}
					}
				}

				// read the extracted file
				$line=$this->PMBP_getln(substr($org_path,0,strlen($org_path)-4));
				if ($line==null) $close=true;
					else return $line;
			}

			// remove the temporary file
			if ($close) {
				@fclose($GLOBALS['lnFile']);
				$GLOBALS['lnFile']=null;
				@unlink(substr($org_path,0,strlen($org_path)-4));
				return null;
			}
			
		// sql file
		} else {
			if (!$close) {
				if ($GLOBALS['lnFile']==null) {
					$GLOBALS['lnFile']=fopen(DB_PATH.$path, "r");
				}
				
				if (!feof($GLOBALS['lnFile'])) {
				   return fgets($GLOBALS['lnFile']);
				} else {
					$close=true;
				}
			}
			
			if ($close) {
				// remove the file handler
				@fclose($GLOBALS['lnFile']);
				$GLOBALS['lnFile']=null;
				return null;
			}
		}
	}
	
	// in dependency on $mode different modes can be selected (see below)
	protected function PMBP_file_info($mode,$path) 
	{
		//echo $path;
		$this->view->translate = $this->translate();
		$filename=str_replace('.',' ',$path);
		$parts=explode(" ",$filename);	
		//echo strftime('%d/%m/%Y','1398329646');
		//echo '<pre>';
		//print_r($parts);
		//echo '</pre>';
		switch($mode) {
		
			// returns the name of the database a $path backup file belongs to
			case "db":
				return $parts[0];

			// returns the creation timestamp $path backup file
			case "time":
				return intval($parts[1]);
			
			// returns "gz" if $path backup file is gziped
			case "gzip":
				if (isset($parts[3])) if ($parts[3]=="gz") return $parts[3];
			break;
			
			// returns "zip" if $path backup file is ziped
			case "zip":
				if (isset($parts[3])) if ($parts[3]=="zip") return $parts[3];
			break;
			
			// returns type of compression of $path backup file or no
			case "comp":
				if ($this->PMBP_file_info("gzip",$path)) return "gzip"; elseif ($this->PMBP_file_info("zip",$path)) return "zip"; else return $this->translate()->_("No");

			// returns the size of $path backup file
			case "size":
				return filesize($path);

			// returns yes if the backup file contains 'drop table if exists' or no if not
			case "drop":
				while ($line=$this->PMBP_getln($path)) {
					$line=trim($line);
					if (strtolower(substr($line,0,20))=="drop table if exists"){
						$this->PMBP_getln($path,true);
						return $this->translate()->_("Yes");
					} else {
						$drop=$this->translate()->_("No");
					} 
				}
				
				$this->PMBP_getln($path,true);
				return $drop;        
			
			// returns yes if the $path backup files contains tables or no if not
			case "tables":
				while ($line=$this->PMBP_getln($path)) {
					$line=trim($line);
					if (strtolower(substr($line,0,12))=="create table"){
						$this->PMBP_getln($path,true);
						return $this->translate()->_("Yes");
					} else {
						$table=$this->translate()->_("No");
					} 
				}
				$this->PMBP_getln($path,true);
				return $table;

			// returns yes if the $path backup files contains data or no if not
			case "data":
				while ($line=$this->PMBP_getln($path)) {
					$line=trim($line);
					if (strtolower(substr($line,0,6))=="insert") {
						$this->PMBP_getln($path,true);
						return $this->translate()->_("Yes");
					} else {
						$data=$this->translate()->_("No");
					}
				}
				$this->PMBP_getln($path,true);
				return $data;
			
			// returns the comment stored to the backup file
			case "comment":
				while ($line=$this->PMBP_getln($path)) {
					$line=trim($line);
					if (isset($comment) && substr($line,0,1)=="#") {
						$comment.=substr($line,2)."<br>";
					} elseif(isset($comment) && substr($line,0,1)!="#") {
						$this->PMBP_getln($path,true);
						return $comment;
					}
					if ($line=="# comment:") $comment=FALSE;
				}
				$this->PMBP_getln($path,true);
				if (isset($comment)) return $comment; else return FALSE;
		}
	}
	
	public function restoreAction()
	{
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = 'password';
		$dbname = 'kpl_spip';

		define('C_OPEN',"Can't open");
		define('C_WRITE',"Can't write to");
		define('F_NO',"no");
		define('F_SECONDS',"seconds");
		define('BI_IMPORTING_FILE',"Importing file");
		define('BI_INTO_DB',"Into database");
		define('BI_SESSION_NO',"Session number");
		define('BI_STARTING_LINE',"Starting at line");
		define('BI_STOPPING_LINE',"Stopping at line");
		define('BI_QUERY_NO',"Number of queries performed");
		define('BI_BYTE_NO',"Number of bytes processed yet");
		define('BI_DURATION',"Duration of last session");
		define('BI_THIS_LAST',"this session/total");
		define('BI_END',"End of file reached, import seems to be OK");
		define('BI_RESTART',"Restart import of file ");
		define('BI_SCRIPT_RUNNING',"This script is still running!<br>Please wait until the end of the file is reached");
		define('BI_CONTINUE',"Continue from the line");
		define('BI_ENABLE_JS',"Enable JavaScript to continue automatically");
		define('BI_BROKEN_ZIP',"The ZIP file seems to be broken");
		define('BI_WRONG_FILE',"Stopped at line %s.<br>The current query includes more than %s dump lines. That happens if your backup file was created
		by some tool which didn't place a semicolon followed by a linebreak at the end of each query, or if your backup file contains extended inserts.");

		Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx5'
            )
        );

		@session_start();
		echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"
		   \"http://www.w3.org/TR/html4/loose.dtd\">
		<html>
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html;charset=ISO-8859-1\">
		<link rel=\"stylesheet\" href=\"".CSS_PATH."standard.css\" type=\"text/css\">
		<title>Restore Database - Zend Template</title>
		</head>
		<body>
		<table border=\"0\" cellspacing=\"2\" cellpadding=\"0\" width=\"100%\">\n
		<tr><th colspan=\"2\" class=\"active\">\n";
		echo $this->PMBP_image_tag(IMAGES_PATH."spt/jata.png","phpMyBackupPro PMBP_WEBSITE","xx");
		echo "\n</th></tr>\n";
		@set_time_limit($CONF['timelimit']);
		
		// set parameters
		$linespersession=10000;  
		
		// set some basic values on start up
		$error=false;
		$_GET["fn"] = DB_PATH.$_GET['file'];
		if (!isset($_GET['sn'])) $_GET['sn']=0; else $_GET['sn']++;
		if (!isset($_GET['totalqueries'])) $_GET['totalqueries']=0;
		if (!isset($_GET['dbn'])) $_GET['dbn']=$dbname;
		if (!isset($_GET['delete'])) $_GET['delete']=false;
		if (!isset($_GET['start']) || !isset($_GET['foffset'])) {
			$_GET['start']=$_GET['foffset']=0;
			$firstSession=TRUE;
			$linenumber=0;
			$foffset=0;
			$totalqueries=0;    
		}

		// connect to the database
		if (!isset($firstSession)) {
			$con=@mysql_connect($dbhost,$dbuser,$dbpass); 
			if (!$con) $error=C_WRONG_SQL;
			if (!$error) $db=@mysql_select_db($_GET['dbn']);
			if (!$db) $error=C_WRONG_DB." (".$_GET['dbn'].")";
		}

		// open the file
		if (!$error && !isset($firstSession)) {
		// gzopen can be used for plain text too!
			
			// extract zip file
			if ($this->PMBP_file_info("comp",$_GET["fn"])=="zip") {
				//include_once("pclzip.lib.php");
				$pclzip = new PclZip($_GET["fn"]);
				$extracted_file=$pclzip->extractByIndex(0,DB_PATH,"");
				if ($pclzip->error_code!=0) $error="plczip: ".$pclzip->error_string."<br>".BI_BROKEN_ZIP."!";
				$_GET["fn"]=substr($_GET["fn"],0,strlen($_GET["fn"])-4);
				unset($pclzip);	
			}

			if(!$error && !$file=@gzopen($_GET["fn"],"r")) $error=C_OPEN." ".$_GET["fn"];    
		}

		if (!$error) {
			// get start time to calculate duration
			if (function_exists("microtime")) {
				$microtime=explode(" ",microtime());
				$starttime=($microtime[0]+$microtime[1]);
			} else {
				$starttime=time();
			}    

			if (file_exists($_GET["fn"].".zip")) echo "<tr><td><div class=\"bold_left\">".BI_IMPORTING_FILE.":</div></td><td>".basename($_GET["fn"]).".zip</td></tr>\n";
				else echo "<tr><td><div class=\"bold_left\">".BI_IMPORTING_FILE.":</div></td><td>".basename($_GET["fn"])."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".BI_INTO_DB.":</div></td><td>".$_GET["dbn"]."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".BI_SESSION_NO.":</div></td><td>".$_GET["sn"]."</td></tr>\n";
			echo "<tr><td><div class=\"bold_left\">".BI_STARTING_LINE.":</div></td><td>".$_GET["start"]."</td></tr>\n";

			// start or continue the import process
			if (!isset($firstSession)) {
				if (gzseek($file, $_GET["foffset"])!=0) $error="UNEXPECTED ERROR: Can't set gzip file pointer to offset: ".$_GET["foffset"];

				// execute sql queries
				if (!$error) {
					extract($this->PMBP_exec_sql($file,$con,$linespersession ),EXTR_OVERWRITE);
				}

				// get the current file position
				if (!$error) {
					$foffset=gztell($file);
					if ($foffset===false) $error="UNEXPECTED ERROR: Can't read the file pointer offset";
				}
			}

			// clean up
			if (!isset($firstSession)) {
				if ($con) @mysql_close();
				@gzclose($file);
			}
			
			if (!$error || isset($firstSession)) {
				// calculate execution duration of this session
				if (function_exists("microtime")) {
					$microtime=explode(" ",microtime());
					$endtime=($microtime[0]+$microtime[1]);
				} else {
					$endtime=time();
				}

				if (!isset($firstSession)) {
					// print information table
					echo "<tr><td><div class=\"bold_left\">".BI_STOPPING_LINE.":</div></td><td>".($linenumber-1)."</td></tr>\n";
					echo "<tr><td><div class=\"bold_left\">".BI_QUERY_NO."<br>(".BI_THIS_LAST."):</div></td><td>".$queries."/".$totalqueries."</td></tr>\n";
					echo "<tr><td><div class=\"bold_left\">".BI_BYTE_NO.":</div></td><td>".round($foffset/1024)." KB</td></tr>\n";        
					echo "<tr><td><div class=\"bold_left\">".BI_DURATION.":</div></td><td>".number_format($endtime-$starttime,3)." ".F_SECONDS."</td></tr>\n";
				}
				
				if ($linenumber<$_GET["start"]+$linespersession && !isset($firstSession)) {
					// delete extracted zip file
					if (file_exists($_GET["fn"].".zip")) @unlink($_GET["fn"]);
					// all sql queries executed
					echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
					echo "<tr><td colspan=\"2\" class=\"active\"><div class=\"green_left\">".BI_END.".\n";
					// delete the temporary created file
					if (!$_GET['delete']) {
						if (file_exists($_GET["fn"].".zip")) echo "<br>(<a href=\"".SYSTEM_URL."?/admin/db/restore?file=".$_GET["file"].".zip&dbn=".$_GET['dbn']."\">".BI_RESTART."".basename($_GET['fn']).".zip</a>)</td></tr>\n";
							else echo "<br>(<a href=\"".SYSTEM_URL."/admin/db/restore?file=".$_GET["file"]."&dbn=".$_GET['dbn']."\">".BI_RESTART."".basename($_GET['fn'])."</a>)</td></tr>\n";
					}
					echo "</table>\n";
				} else {
					// restart script to execute next queries
					echo "<tr><td colspan=\"2\">&nbsp;</td></tr>\n";
					echo "<tr><td colspan=\"2\" class=\"active\"><div class=\"red_left\">".BI_SCRIPT_RUNNING.".</div></td></tr>\n";
					echo "</table>\n";
					echo "<script language=\"JavaScript\" type=\"text/javascript\">window.setTimeout('location.href=\"".SYSTEM_URL."/admin/db/restore?file=".$_GET['file']."&fn=".$_GET["fn"];
					echo "&dbn=".$_GET['dbn']."&delete=".$_GET['delete']."&start=".$linenumber."&foffset=".$foffset."&totalqueries=".$totalqueries."&sn=".$_GET['sn']."\";',500);</script>\n";
					echo "<noscript>\n";
					echo "<div class=\"red_left\"><a href=\"".SYSTEM_URL."/admin/db/restore?file=".$_GET['file']."&delete=".$_GET['delete']."&start=".$linenumber."&fn=".$_GET["fn"]."&foffset=".$foffset."&dbn=".$_GET['dbn'];
					echo "&totalqueries=".$totalqueries."&sn=".$_GET['sn']."\">".BI_CONTINUE." ".$linenumber."</a> (".BI_ENABLE_JS."!)</div>\n";
					echo "</noscript>\n";
				}
			}    
		}

		if ($error) echo "<tr><td colspan=\"2\"><div class=\"red_left\">".$error."</td></tr>";
		echo "</table></body>\n</html>";
		return;
	}
	
	// function to execute the sql queries provided by the file handler $file
	// $file can be a gzopen() or open() handler, $con is the database connection
	// $linespersession says how many lines should be executed; if false, all lines will be executed
	protected function PMBP_exec_sql($file,$con,$linespersession=false,$noFile=false) 
	{
		$query="";
		$queries=0;
		$error="";
		if (isset($_GET["totalqueries"])) $totalqueries=$_GET["totalqueries"]; else $totalqueries=0;
		if (isset($_GET["start"])) $linenumber=$_GET["start"]; else $linenumber=$_GET['start']=0;
		if (!$linespersession) $_GET['start']=1;
		$inparents=false;
		$querylines=0;

		// $tableQueries and $insertQueries only count this session
		$tableQueries=0;
		$insertQueries=0;

		// stop if a query is longer than 300 lines long
		$max_query_lines=300;

		// lines starting with these strings are comments and will be ignored
		$comment[0]="#";
		$comment[1]="-- ";

		while (($linenumber<$_GET["start"]+$linespersession || $query!="") && ($dumpline=gzgets($file,65536)))               
		{
			// increment $_GET['start'] when $linespersession was not set
			// so all lines of $file will be exeuted at once
			if (!$linespersession) $_GET['start']++;
			  
			// handle DOS and Mac encoded linebreaks
			$dumpline=ereg_replace("\r\n$","\n",$dumpline);
			$dumpline=ereg_replace("\r$","\n",$dumpline);

			// skip comments and blank lines only if NOT in parents    
			if (!$inparents) {
				$skipline=false;
				foreach ($comment as $comment_value) {
					if (!$inparents && (trim($dumpline)=="" || strpos ($dumpline,$comment_value)===0)) {
						$skipline=true;
						break;
					}
				}
				if ($skipline) {
					$linenumber++;
					continue;
				}
			}

			// remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)  
			$dumpline_deslashed=str_replace("\\\\","",$dumpline);

			// count ' and \' in the dumpline to avoid query break within a text field ending by ;
			// please don't use double quotes ('"')to surround strings, it wont work
			$parents=substr_count($dumpline_deslashed,"'")-substr_count($dumpline_deslashed,"\\'");
			if ($parents%2!=0) $inparents=!$inparents;

			// add the line to query
			$query.=$dumpline;

			// don't count the line if in parents (text fields may include unlimited linebreaks)  
			if (!$inparents) $querylines++;
			  
			// stop if query contains more lines as defined by $max_query_lines    
			if ($querylines>$max_query_lines) {
				$error=sprintf(BI_WRONG_FILE."\n",$linenumber,$max_query_lines);
				break;
			}

			// execute query if end of query detected (; as last character) AND NOT in parents
			if (ereg(";$",trim($dumpline)) && !$inparents) {
				if (!mysql_query(trim($query),$con)) {
					$error=SQ_ERROR." ".($linenumber+1)."<br>".nl2br(htmlentities(trim($query)))."\n<br>".htmlentities(mysql_error());
					break;
				}
				
				if (strtolower(substr(trim($query),0,6))=="insert") $tableQueries++;
					elseif (strtolower(substr(trim($query),0,12))=="create table") $insertQueries++; 
				$totalqueries++;
				$queries++;
				$query="";
				$querylines=0;
			}            
			$linenumber++;
		}
		return array("queries"=>$queries,"totalqueries"=>$totalqueries,"linenumber"=>$linenumber,"error"=>$error,"tableQueries"=>$tableQueries,"insertQueries"=>$insertQueries);
	}
	
	// returns present local backup files after deleting backups files 
	function PMBP_get_backup_files() 
	{
		global $CONF;
		$CONF['del_time'] = 77;
		$CONF['del_number'] = 75;
		//print_r($CONF['del_time']);
		$delete_files=FALSE;
		$all_files=FALSE;
		$result_files=FALSE;
		$handle=@opendir(DB_PATH);
		$remove_time=time()-($CONF['del_time']*86400);
		while ($file=@readdir($handle)) {
			if ($file!="." && $file!=".." && preg_match("'\.sql|\.sql\.gz|\.sql\.zip'",$file)) {
				
				// don't delete if del_time is not set
				if ($CONF['del_time']) {
					if ($this->PMBP_file_info("time",$file)<$remove_time) $delete_files[]=$file; else $all_files[]=$file;
				} else {
					$all_files[]=$file;
				}
			}
		}
		// sort descending
		if (is_array($all_files)) rsort($all_files);

		// delete oldest backup files if there are to many for one db
		if (is_array($all_files)) {
			foreach($all_files as $file) {
				if (!isset($counter[$db=$this->PMBP_file_info("db",DB_PATH.$file)])) $counter[$db]=1; else $counter[$db]++;
				if ($counter[$db]>$CONF['del_number']) $delete_files[]=$file; else $result_files[]=$file;
			}
		}

		// now delete the files
		//if ($delete_files) $this->PMBP_delete_backup_files($delete_files);

		// sort ascending
		if (is_array($result_files)) sort($result_files);
		return $result_files;
	}
	
	// delete the file(s) in mixed $files from local export dir and remote ftp server
	protected function PMBP_delete_backup_files($files) 
	{
		$out="";
		if(!is_array($files)) $files=array($files);
		foreach($files as $file) if (!@unlink(DB_PATH.$file))
			$out.="<div class=\"red\">".sprintf(F_DEL_FAILED,$file)."</div>";

		return $out;
	}
	
	// generates event hanlders to change the border color in a td.list list
	protected function PMBP_change_color($color1,$color2)
	{
		return "onmouseout=\"changeColor(this, '".$color1."');\" onmouseover=\"changeColor(this, '".$color2."');\"";
	}
	
	// determines the best size type for filesize $size and returns array('value'=xxx,'type'=yyy)
	protected function PMBP_size_type($size) 
	{
		$types=array("B","KB","MB","GB");
		for ($i=0; $size>1000; $i++,$size/=1024);
		$result['value']=round($size,2);
		$result['type']=$types[$i];
		return $result;
	}
	
	// generates javascript PMBP_pop_up link
	protected function PMBP_pop_up($path,$link,$type,$title_attr="")
	{
		return "<a href='javascript:popUp(\"".$path."\",\"".$type."\",false,\"\")' title=\"".$title_attr."\">".$link."</a>";
	}
	
	// generates javascript confirm dialog
	// if $popupType is "view" or something else, a pop up like in PMBP_pop_up will be opened after the confirmation
	protected function PMBP_confirm($text,$path,$link,$popupType=false)
	{
		global $CONF;
		switch ($CONF['confirm']) {
			case 0:
				if ($popupType) return "<a href='javascript:popUp(\"".$path."\",\"".$popupType."\",true,\"".$text."\")'>".$link."</a>";
					else return "<a href='javascript:confirmClick(\"".$text."\",\"".$path."\")'>".$link."</a>";
			case 1:
				if ($popupType) {
					if (strstr($path,"all") || strstr($path,"ALL")) return "<a href='javascript:popUp(\"".$path."\",\"".$popupType."\",true,\"".$text."\")'>".$link."</a>";
						else return "<a href='javascript:popUp(\"".$path."\",\"".$popupType."\",false,\"\")'>".$link."</a>";
				} else {
					if (strstr($path,"all") || strstr($path,"ALL")) return "<a href='javascript:confirmClick(\"".$text."\",\"".$path."\")'>".$link."</a>";
						else return "<a href=\"".$path."\">".$link."</a>";            
				}
			case 2:
				if ($popupType) {
					if (strstr($path,"ALL")) return "<a href='javascript:popUp(\"".$path."\",\"".$popupType."\",true,\"".$text."\")'>".$link."</a>";
						else return "<a href='javascript:popUp(\"".$path."\",\"".$popupType."\",false,\"\")'>".$link."</a>";
				} else {
					if (strstr($path,"ALL")) return "<a href='javascript:confirmClick(\"".$text."\",\"".$path."\")'>".$link."</a>";
						else return "<a href=\"".$path."\">".$link."</a>";            
				}
			case 3:
				if ($popupType) {
					return "<a href='javascript:popUp(\"".$path."\",\"".$popupType."\",false,\"\")'>".$link."</a>";
				} else {
					return "<a href=\"".$path."\">".$link."</a>";
				}
		}
	}
	
	// generates image tag
	function PMBP_image_tag($image,$alt="",$title="",$link="")
	{
		if ($link)
			return "<a href=\"".$link."\"><img src=\"".$image."\" alt=\"".$alt."\" title=\"".$title."\"></a>";
		else
			return "<img src=\"".$image."\" alt=\"".$alt."\" title=\"".$title."\">";
	}
} 