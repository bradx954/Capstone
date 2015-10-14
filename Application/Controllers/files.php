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
		return $this->M_Files->newFile($_POST['filename'], $this->UserID, $_POST['directory']);
	}
	function newFolder()
	{
		return $this->M_Folders->newFolder($_POST['filename'], $this->UserID, $_POST['directory']);
	}
	function deleteFolder()
	{
		$ID = $_POST['ID'];
		if($this->UserID == $this->M_Folders->getFolderOwner($ID))
		{
			$DeleteArray = $this->M_Folders->deleteDirectory($ID);
			$this->M_Files->deleteDirectoryFiles($DeleteArray);
			return "Folder deleted.";
		}
		else
		{
			return "Access denied.";
		}
	}
	function deleteFile()
	{
		$ID = $_POST['ID'];
		if($this->UserID == $this->M_Files->getFileOwner($ID))
		{
			return $this->M_Files->deleteFile($ID);
		}
		else
		{
			return "Access denied.";
		}
	}
	function getFolderPath()
	{
		return $this->M_Folders->getFolderPath($_POST['ID']);
	}
	function getDirectoryContents()
	{
		$USERID = $_POST['UserID'];
		$DIRECTORY = $_POST['Directory'];
		if($this->UserID == $USERID){return json_encode(array_merge($this->M_Folders->getFolders($USERID, $DIRECTORY),$this->M_Files->getFiles($USERID, $DIRECTORY)));}
		else {return "Access Denied.";}
	}
	function getDirectoryFolders()
	{
		$USERID = $_POST['UserID'];
		$DIRECTORY = $_POST['Directory'];
		if($this->UserID == $USERID){return json_encode($this->M_Folders->getFolders($USERID, $DIRECTORY));}
		else {return "Access Denied.";}
	}
	function getFolderParent()
	{
		return $this->M_Folders->getFolderParent($_POST['ID']);
	}
	function getFile()
	{
		$ID = $_POST['ID'];
		if($this->UserID == $this->M_Files->getFileOwner($ID))
		{
			return $this->M_Files->getFileContents($ID);
		}
		else
		{
			return "Access denied.";
		}
	}
	function updateFile()
	{
		$ID = $_POST['ID'];
		$Contents = $_POST['Contents'];
		
		if(strlen($Contents) > ($this->M_Users->getUserQuota($this->UserID) - $this->M_Files->getUserUsedSpace($this->UserID)))
		{
			return "Insufficient storage space.";
		}
		
		if($this->UserID == $this->M_Files->getFileOwner($ID))
		{
			return $this->M_Files->updateFileContents($ID, $Contents);
		}
		else
		{
			return "Access denied.";
		}
	}
	function renameFile()
	{
		$ID = $_POST['ID'];
		$Contents = $_POST['Contents'];
		
		if($this->UserID == $this->M_Files->getFileOwner($ID))
		{
			return $this->M_Files->updateFileName($ID, $Contents);
		}
		else
		{
			return "Access denied.";
		}
	}
	function renameFolder()
	{
		$ID = $_POST['ID'];
		$Contents = $_POST['Contents'];
		
		if($this->UserID == $this->M_Folders->getFolderOwner($ID))
		{
			return $this->M_Folders->updateFolderName($ID, $Contents);
		}
		else
		{
			return "Access denied.";
		}
	}
}
?>
