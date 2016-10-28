<?php

/**
* BreadCrumb View Helper
*@author Joey Adams
*
*/
class My_Breadcrumb {

public function breadCrumb() {
$module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
$l_m = strtolower($module);

$controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
$l_c = strtolower($controller);

$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
$l_a = strtolower($action);

// HomePage = No Breadcrumb
if($l_m == 'default' && $l_c == 'index' && $l_a == 'index'){
return;
}

// Get our url and create a home crumb
$url = SYSTEM_URL;
$homeLink = "<a href='{$url}/'>Home</a>";

// Start crumbs
$crumbs = $homeLink . " > ";

// If our module is default
if($l_m == 'default') {

if($l_a == 'index'){
$crumbs .= $controller;
} else {
$crumbs .= "<a href='{$url}/{$controller}/'>$controller</a> > $action";
}
} else {
// Non Default Module
if($l_c == 'index' && $l_a == 'index') {
$crumbs .= $module;
} else {
$crumbs .= "<a href='{$url}/{$module}/'>$module</a> > ";
if($l_a == 'index') {
$crumbs .= $controller;
} else {
$crumbs .= "<a href='{$url}/{$module}/{$controller}/'>$controller</a> > $action";
}
}

}
return $crumbs;
}

}
