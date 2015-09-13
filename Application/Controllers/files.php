<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Files extends Controller 
{
	private $M_Users;
	private $M_Files;
	private $M_Folders;
	private $UserID;
	
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
		$this->M_Files = new M_Files();
		$this->M_Folders = new M_Folders();
		$this->UserID = $this->M_Users->getUserID($_SESSION['auth']['email']);
	}
	function index()
	{
		$this->view->render('files',$TPL);
	}
	function newFile()
	{
		return $this->M_Files->newFile($_POST['filename'], $this->UserID);
	}
	function newFolder()
	{
		return $this->M_Folders->newFolder($_POST['filename'], $this->UserID);
	}
}
?>
