<?php
/**
 * @author Bruno Martin <brunoocto@gmail.com>
 */

//error_reporting(0); //Disable error message to avoid it to be sent to the client side
session_start();
$path = dirname(__FILE__);
require_once $path.'/config/Autoload.php';
require_once $path.'/brunoaw.php';
require_once $path.'/config/Error.php';

$brunoaw = \Brunoaw::getInstance();
$brunoaw->loadBundles(array('web'));
$brunoaw->launch();
