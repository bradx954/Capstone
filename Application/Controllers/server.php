<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Server extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
        $this->M_Avatars = new M_Avatars();
        $this->M_Files = new M_Files();
        $this->M_Folders = new M_Folders();
	}
	function index()
	{
        $TPL['users'] = $this->M_Users->getCount();
        $TPL['avatars'] = $this->M_Avatars->getCount();
        $TPL['files'] = $this->M_Files->getCount();
        $TPL['folders'] = $this->M_Folders->getCount();
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
