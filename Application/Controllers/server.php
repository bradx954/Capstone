<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Server extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
	}
	function index()
	{
        $TPL['users'] = $this->M_Users->getUserCount();
        $TPL['avatars'] = 0;
        $TPL['files'] = 0;
        $TPL['folders'] = 0;
		$this->view->render('server',$TPL);
	}
    function resetUsers()
    {
        return $this->M_Users->resetUsers();
    }
    function resetAvatars()
    {
        return "Not implemented.";
    }
    function resetFiles()
    {
        return "Not implemented.";
    }
    function resetFolders()
    {
        return "Not implemented.";
    }
}
?>
