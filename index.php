<?php
session_start();
ob_start();
require_once 'config.php';
// Library import
require_once './model/phpmailer/PHPMailer.php';
require_once './model/phpmailer/SMTP.php';
require_once './model/phpmailer/Exception.php';

require_once './model/connect.php';
require_once './model/database.php';
require_once './model/functions.php';
require_once './model/session.php';


$module = _MODULE_DEFAULT;
$action = _ACTION_DEFAULT;

if (!empty($_GET['module'])) {
    $module = $_GET['module'];
}

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

// Thiet lap Path
$path = 'client/' . $module . '/' . $action . '.php';
if (file_exists($path)) {
    require_once $path;
} else {
    require_once 'error/404.php';
}
