<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Admin extends Controller 
{
	private $M_Users;
	private $M_UserAuth;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new Users();
		$this->MUserAuth = new UserAuth();
        if($this->MUserAuth->loggedin() == false)
        {
            throw new NotFoundException();
        }
	}
	function index()
	{
		$this->view->render('admin',$TPL);
	}
}
?>
