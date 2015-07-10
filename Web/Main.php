<?php
//error reporting
ini_set('error_reporting',E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
//makes the URL neat and small
$_SERVER["PHP_SELF"]  = basename($_SERVER["PHP_SELF"]);

//Paths to inportant system files
define('ROOT', dirname(dirname(__FILE__)));
define('ERRORHANDLER_VIEW',ROOT.'/Library/Error/errorHandler.view.php');
define('DATABASEERROR_VIEW',ROOT.'/Library/Error/dataBaseError.view.php');
//define('PHONEBOOK_SQL',ROOT.'/public/phonebook.sql.txt');
define('LOGFILE',ROOT.'/Log/logfile.txt');

//default values
define ('DEFAULT_CONTROLLER','home');
define ('DEFAULT_METHOD','index');

//Eager load all configuration files
 foreach (glob(ROOT.'/Config/*.php') as $filename) {
     require_once $filename;
 }

//General and program errors reported here....
set_error_handler('errorHandler',E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
function errorHandler($errno, $errstr, $errfile, $errline)
  {
	$TPL = array(	'errorNumber' 		=> $errno,
				 	'errorMessage' 		=> $errstr,
					'errorLineNumber' 	=> $errline,
					'errorFileName' 	=> $errfile,
					'time' 				=> date("F j, Y, g:i a"));
				 	
	include ERRORHANDLER_VIEW;   
  	exit;
  }

//Lazy load classes/controllers as needed using __autoload function
function __autoload_disabled ($className) {
	
	// your code goes here....... 	 
 }
 
 
/* 
 	Delete  all the includes below  and have the classes load on demand with 
		the __autoload function above. 
	 Error messages must be generated to the error_handler 
	 if any of the following conditions arise:
	1.  "Controller file  ClassFileName  could not be lazy loaded"  - happens if the 
		controller requested  doesn't exist in directory. 
	2.  "Controller Class is ClassFileName not named correctly in file "  - happens if
		the class name "Example" doesn't exist in the file named "example.php".
			(note case of 1st letter in file name and class name)
*/

require_once  ROOT . '/Library/Classes/' . 'Controller' . '.php';
require_once  ROOT . '/Library/Classes/' . 'Database' . '.php';
require_once  ROOT . '/Library/Classes/' . 'Model' . '.php';
require_once  ROOT . '/Library/Classes/' . 'View' . '.php';
//require_once  ROOT . '/application/controllers/' . 'example' . '.php';
require_once  ROOT . '/Application/Controllers/' . 'home' . '.php';
require_once  ROOT . '/Application/Controllers/' . 'admin' . '.php';
//require_once  ROOT . '/application/controllers/' . 'register' . '.php';
//require_once  ROOT . '///application/controllers/' . 'login' . '.php';
//require_once  ROOT . '/application/controllers/' . 'admin' . '.php';
//require_once  ROOT . '/application/controllers/' . 'helpdesk' . '.php';
//require_once  ROOT . '/application/controllers/' . 'staff' . '.php';
//require_once  ROOT . '/application/controllers/' . 'supervisors' . '.php';
//require_once  ROOT . '/application/models/' . 'example_m' . '.php';
//require_once  ROOT . '/application/models/' . 'userauth' . '.php'; 
require_once  ROOT . '/Application/Models/' . 'Users' . '.php';
require_once  ROOT . '/Application/Models/' . 'userauth' . '.php';
//require_once  ROOT . '/application/models/' . 'phonebook' . '.php'; 
 
 
//default conditions
$controllerName = (isset($_REQUEST["c"]) and empty($_REQUEST["c"]) == false )
					?  $_REQUEST["c"] : DEFAULT_CONTROLLER;
$methodName 	= (isset($_REQUEST["m"]) and empty($_REQUEST["m"]) == false )
					?  $_REQUEST["m"] : DEFAULT_METHOD;
 
//Class name is firstletter in capitol letters
$controllerName = ucfirst($controllerName);
 
session_start();

//Instantiate controller class. Shouldn't fail, since we checked in auto_load
try
{
    $controllerObj = new $controllerName;
}
catch(NotFoundException $e)
{
    $controllerObj = new Home;
}

//call controller and method 
if ((int)method_exists($controllerObj, $methodName)):
	 echo call_user_func(array($controllerObj,$methodName));
else:
	 trigger_error("Non-existent  method has been called: $controllerName, $methodName");
endif;
?>
