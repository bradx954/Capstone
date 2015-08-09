<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Files extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
	}
	function index()
	{
		$this->view->render('files',$TPL);
	}
}
?>
