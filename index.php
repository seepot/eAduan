<?php

// Update after deployment for location of non-public files
$root = dirname(__FILE__);

//echo $root;



// We’re assuming the Zend Framework is already on the include_path
set_include_path(
    //$root . '/application' . PATH_SEPARATOR
     $root . '/library' . PATH_SEPARATOR
    . $root . '/application/models' . PATH_SEPARATOR
    . get_include_path()
);

require_once 'application/Bootstrap.php';

try {
		Bootstrap::run();
	} catch (Exception $e) {
		echo '<html><body><center>'
        . "<img src=\"".Zend_Controller_Front::getInstance()->getBaseUrl()."/public/images/error404.gif\" alt=\"Page not found\">"
        . "<a href=\"Javascript:history.back();\">Back</a><br><br>"
		. 'An exception occured while bootstrapping the application.';
    
       echo '<br /><br />' . $e->getMessage() . '<br />'
           . '<div align="left">Stack Trace:' 
           . '<pre>' . $e->getTraceAsString() . '</pre></div>';
   		
        
	    echo '</center></body></html>';
	    exit(1);

	
	
	}