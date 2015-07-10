<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Home extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new Users();
        $this->Allowed=true;
	}
	function index()
	{
		$TPL['Users'] = $this->M_Users->getUserCount();
		$TPL['Login_Page'] = $this->MUserAuth->login_page;
		$this->view->render('home',$TPL);
	}
	function registerNewUser()
	{
		return $this->M_Users->createUser($_POST['fName'],$_POST['lName'],$_POST['email'],$_POST['password'],$_POST['question'],$_POST['answer']);
	}
	function login()
	{
		return $this->MUserAuth->login($_POST['email'],$_POST['password']);
	}
	function logout()
	{
		$this->MUserAuth->logout();
		$this->index();
	}
}
?>
