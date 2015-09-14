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
		$TPL['UserID'] = $this->UserID;
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
	function getDirectoryContents()
	{
		$USERID = $_POST['UserID'];
		$DIRECTORY = $_POST['Directory'];
		if($this->UserID == $USERID){return json_encode(array_merge($this->M_Folders->getFolders($USERID, $DIRECTORY),$this->M_Files->getFiles($USERID, $DIRECTORY)));}
		else {return "Access Denied.";}
	}
}
?>
