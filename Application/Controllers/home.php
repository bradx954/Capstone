<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Home extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new Users();
	}
	function index()
	{
		$TPL['Users'] = $this->M_Users->getUserCount();
		$this->view->render('home',$TPL);
	}
	function registerNewUser()
	{
		return $this->M_Users->createUser($_POST['fName'],$_POST['lName'],$_POST['email'],$_POST['password'],$_POST['question'],$_POST['answer']);
	}
}
?>
