<?php
try {
include_once('../includes/constants.php');
include_once(SITEDIR.'/Connections/connMain.php');
include_once(SITEDIR.'/includes/functions.php');
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
$page_prefix = 'App_';
$page = $defaultPage;

if (!empty($_GET['p'])) {
  $page = $_GET['p'];
  if (!file_exists(SITEDIR.'/api/MkGalaxy/App/'.$page.'.class.php')) {
    $page = $defaultPage;
  }
  $page = implode('_', explode('/', $page));
}

$pagePath = $page_prefix.$page;
$object = new $pagePath();
$object->execute();
$return = array('success' => 1, 'msg' => '', 'data' => $object->return, 'pagePath' => $pagePath);
} catch (Exception $e) {
$return = array('success' => 0, 'msg' => $e->getMessage(), 'data' => array(), 'pagePath' => $pagePath);
}
//echo json_encode($return);
$content = json_encode($return);
if (!empty($_GET['jsoncallback'])) {
	echo $_GET["jsoncallback"]."(".$content.")";
} else {
	echo $content;
}
exit;