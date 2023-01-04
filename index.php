<?php
header('Access-Control-Allow-Origin: *');

header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
date_default_timezone_set('America/Sao_Paulo');
ob_start();
include('vendor/autoload.php');
include('src/Rest/Routes.php');
include('src/Rest/BaseUrl.php');

$base = base_url();

error_reporting(0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//$GLOBALS['base_project']="/src/0-Presentation/";
$GLOBALS['base_project'] = "src/";
$GLOBALS['base_dir'] = $base . $GLOBALS['base_project'];
$GLOBALS['base_site'] = $base;
$GLOBALS['base_view'] = "Views/";

$nome_url = explode('/', $_SERVER['REQUEST_URI']);

$controller = $nome_url[count($nome_url) - 2];


session_cache_expire(60);

if (!isset($routes[$controller])) {

	header("Location: " . $GLOBALS['base_site'] . "" . $routes['default'] . "/");
} else {
	include($GLOBALS['base_project'] . "Controllers/" . $routes[$controller]);
}
