<?php
session_start();

include_once('includes/constants.php');

$http = $_SERVER['HTTP_HOST'];
$file = SITEDIR.'/configs/config.'.$http.'.php';
if (file_exists($file)) {
  include_once($file);
}
include_once(SITEDIR.'/configs/config.php');

include_once(SITEDIR.'/Connections/connMain.php');
include_once('includes/functions.php');


set_include_path(get_include_path(). PATH_SEPARATOR. BASE_DIR.'/library');

//my autoloader
function myautoload($class_name) {
    $classPath = SITEDIR.'/api/MkGalaxy/'.implode('/', explode('_', $class_name));
   if (file_exists($classPath.'.class.php')) {
    include_once $classPath . '.class.php';
   }
}
spl_autoload_register('myautoload', true);

//zend autoloadar
require_once('Zend/Loader/Autoloader.php');
if (class_exists('Zend_Loader_Autoloader', false))
{
  Zend_Loader_Autoloader::getInstance();
}



$defaultPage = 'home';
$page = $defaultPage;
if (!empty($_GET['p'])) {
  $page = $_GET['p'];
}
$page .= '.php';
$pageTitle = 'Home page';
$subPageTitle = 'subpage heading';

ob_start();
if (file_exists($page)) {
  include($page);
} else {
  include($defaultPage.'.php');
}

$contentForTemplate = ob_get_clean();
if (empty($layoutFile)) {
  //$layoutFile = 'layouts/templateSelf';
  $layoutFile = 'layouts/home/index';
}
$layoutFile = $layoutFile.'.php';
include($layoutFile);

?>