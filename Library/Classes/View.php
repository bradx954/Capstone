<?php
class View 
{
	function __construct() 
	{
		
	}
	function render ($templateFile,$vars) {
		$TPL = $vars;
		require_once(ROOT . '/Application/Views/_header'.'.php'); 
		require_once(ROOT . '/Application/Views/'. strtolower($templateFile) . '.php');
		require_once(ROOT . '/Application/Views/_footer'.'.php');
	}
}
?>
