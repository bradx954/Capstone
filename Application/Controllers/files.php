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
		foreach($this->M_Users->getUsers() as $User)
		{
			if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($User['id'])][$_SESSION['auth']['accesslevel']] || $this->UserID == $User['id'])
			{
				$TPL['Users'] .= "<option value='".$User['id']."'>".$User['email']."</option>";
			}
		}
		$this->view->render('files',$TPL);
	}
	function getUserStorage()
	{
		$USERID = $_POST['UserID'];
		if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($USERID)][$_SESSION['auth']['accesslevel']] || $this->UserID == $USERID)
		{
			return json_encode(array("used" => $this->M_Files->getUserUsedSpace($USERID),"total" => $this->M_Users->getUserQuota($USERID)));
		}
		else
		{
			return "Access denied";
		}
	}
	function newFile()
	{
		$USERID = $_POST['UserID'];
		if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($USERID)][$_SESSION['auth']['accesslevel']] || $this->UserID == $USERID)
		{
			$result = $this->M_Files->newFile($_POST['filename'], $USERID, $_POST['directory']);
			if($result > 0){return 'File Created.';}
			else{return $result;}
		}
		else
		{
			return "Access denied";
		}
	}
	function uploadFile()
	{
		$USERID = $_POST['UserID'];
		if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($USERID)][$_SESSION['auth']['accesslevel']] || $this->UserID == $USERID)
		{
			$Contents = trim($_POST['content']);
			$offset = strpos($Contents, ',');
			$Contents = substr($Contents, $offset);
			$ID = $this->M_Files->newFile($_POST['filename'], $USERID, $_POST['directory']);
			if($ID > 0)
			{
				if(strlen($Contents) > ($this->M_Users->getUserQuota($USERID) - $this->M_Files->getUserUsedSpace($USERID)))
				{
					return "Insufficient storage space.";
				}

				$result = $this->M_Files->updateFileContents($ID, $Contents);
				if($result == 'File Updated.')
				{
					return 'File Uploaded.';
				}
				else
				{
					return $result.$ID.$Contents;
				}
			}
			else
			{
				return $ID;
			}
		}
		else
		{
			return "Access denied";
		}
	}
	function newFolder()
	{
		$USERID = $_POST['UserID'];
		if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($USERID)][$_SESSION['auth']['accesslevel']] || $this->UserID == $USERID)
		{
			$result = $this->M_Folders->newFolder($_POST['filename'], $USERID, $_POST['directory']);
			if($result > 0){return 'Folder Created.';}
			else{return $result;}
		}
		else
		{
			return "Access denied";
		}
	}
	function deleteFolder()
	{
		$ID = $_POST['ID'];
		$Owner = $this->M_Folders->getFolderOwner($ID);
		if($this->UserID == $this->M_Folders->getFolderOwner($ID) || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
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
		$Owner = $this->M_Files->getFileOwner($ID);
		if($this->UserID == $Owner || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
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
		if($_POST['ID'] == 0)
		{
			return "/";
		}
		$Owner = $this->M_Folders->getFolderOwner($_POST['ID']);
		if($this->UserID == $this->M_Folders->getFolderOwner($_POST['ID']) || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return $this->M_Folders->getFolderPath($_POST['ID']);
		}
		else
		{
			return "Access denied.";
		}
	}
	function getDirectoryContents()
	{
		$USERID = $_POST['UserID'];
		$DIRECTORY = $_POST['Directory'];
		if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($USERID)][$_SESSION['auth']['accesslevel']] || $this->UserID == $USERID){return json_encode(array_merge($this->M_Folders->getFolders($USERID, $DIRECTORY),$this->M_Files->getFiles($USERID, $DIRECTORY)));}
		else {return "Access Denied.";}
	}
	function getDirectoryFolders()
	{
		$USERID = $_POST['UserID'];
		$DIRECTORY = $_POST['Directory'];
		if($GLOBALS['config']['ufel'][$this->M_Users->getUserRank($USERID)][$_SESSION['auth']['accesslevel']] || $this->UserID == $USERID){return json_encode($this->M_Folders->getFolders($USERID, $DIRECTORY));}
		else {return "Access Denied.";}
	}
	function getFolderParent()
	{
		if($_POST['ID'] == 0)
		{
			return 0;
		}
		$Owner = $this->M_Folders->getFolderOwner($_POST['ID']);
		if($this->UserID == $this->M_Folders->getFolderOwner($_POST['ID']) || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return $this->M_Folders->getFolderParent($_POST['ID']);
		}
		else
		{
			return "Access denied.";
		}
	}
	function getFile()
	{
		$ID = $_POST['ID'];
		$Owner = $this->M_Files->getFileOwner($ID);
		if($this->UserID == $Owner || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return base64_decode($this->M_Files->getFileContents($ID));
		}
		else
		{
			return "Access denied.";
		}
	}
	function getFolderDownload()
	{
		$ID = $_POST['ID'];
		$Owner = $this->M_Folders->getFolderOwner($ID);
		if($this->UserID == $this->M_Folders->getFolderOwner($ID) || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			$name = $this->M_Folders->getFolderName($ID);
			$zip = new ZipArchive();
			if ($zip->open(ROOT.'/Files/'.$name.'.zip', ZIPARCHIVE::CREATE)!==TRUE) 
			{
				exit("cannot compress file\n");
			}
			$this->zipFolder($zip, $ID, $this->UserID);
			$zip->close();
			$name = $name.'.zip';
			$length = filesize(ROOT.'/Files/'.$name);
			header('Content-Description: File Transfer');
			header('Content-Type: text/plain');//<<<<
			header('Content-Disposition: attachment; filename='.$name);
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . $length);
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Expires: 0');
			header('Pragma: public');
			readfile(ROOT.'/Files/'.$name);
			unlink(ROOT.'/Files/'.$name);
			exit;
		}
		else
		{
			return "Access denied.";
		}
	}
	function getFileDownload()
	{
		$ID = $_POST['ID'];
		$COMPRESS = $_POST['COMPRESS'];
		$Owner = $this->M_Files->getFileOwner($ID);
		if($this->UserID == $Owner || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			$content = base64_decode($this->M_Files->getFileContents($ID));
			$name = $this->M_Files->getFileName($ID);
			$length = strlen($content);
			if($COMPRESS == 'true')
			{
				$zip = new ZipArchive();
				if ($zip->open(ROOT.'/Files/'.$name.'.zip', ZIPARCHIVE::CREATE)!==TRUE) 
				{
					exit("cannot compress file\n");
				}
				$zip->addFromString($name, $content);
				$zip->close();
				$name = $name.'.zip';
				$length = filesize(ROOT.'/Files/'.$name);
			}
			header('Content-Description: File Transfer');
			header('Content-Type: text/plain');//<<<<
			header('Content-Disposition: attachment; filename='.$name);
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . $length);
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Expires: 0');
			header('Pragma: public');

			if($COMPRESS == 'true'){readfile(ROOT.'/Files/'.$name);unlink(ROOT.'/Files/'.$name);}
			else{echo $content;}
			exit;
		}
		else
		{
			return "Access denied.";
		}
	}
	function updateFile()
	{
		$ID = $_POST['ID'];
		$Contents = base64_encode($_POST['Contents']);
		$Owner = $this->M_Files->getFileOwner($ID);
		if($this->UserID == $Owner || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			if(strlen($Contents) > ($this->M_Users->getUserQuota($Owner) - $this->M_Files->getUserUsedSpace($Owner)))
			{
				return "Insufficient storage space.";
			}
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
		$Owner = $this->M_Files->getFileOwner($ID);
		if($this->UserID == $Owner || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
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
		
		$Owner = $this->M_Folders->getFolderOwner($ID);
		if($this->UserID == $this->M_Folders->getFolderOwner($ID) || $GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return $this->M_Folders->updateFolderName($ID, $Contents);
		}
		else
		{
			return "Access denied.";
		}
	}
	function moveFile()
	{
		$Owner = $this->M_Files->getFileOwner($_POST['ID']);
		if($this->UserID != $Owner && !$GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return "Access denied.";
		}
		$result = $this->M_Files->updateParentID($_POST['ID'], $_POST['Destination']);
		if($result == "File parent updated.")
		{
			return "File Move completed.";
		}
		else
		{
			return $result;
		}
	}
	function moveFolder()
	{
		$Owner = $this->M_Folders->getFolderOwner($_POST['ID']);
		if($this->UserID != $this->M_Folders->getFolderOwner($ID) && !$GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return "Access denied.";
		}
		$result = $this->M_Folders->updateParentID($_POST['ID'], $_POST['Destination']);
		if($result == "Folder parent updated.")
		{
			return "Folder Move completed.";
		}
		else
		{
			return $result;
		}
	}
	function copyFile()
	{
		$Owner = $this->M_Files->getFileOwner($_POST['ID']);
		if($this->UserID != $Owner && !$GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return "Access denied.";
		}
		if($_POST['ID'] == $_POST['Destination'])
		{
			return "Cant copy folder into same folder.";
		}
		$Filecontents = $this->M_Files->getFileContents($_POST['ID']);
		if(strlen($Filecontents) > ($this->M_Users->getUserQuota($_POST['UserID']) - $this->M_Files->getUserUsedSpace($_POST['UserID'])))
		{
			return "Insufficient storage space.";
		}
		return $this->M_Files->copyFile($_POST['ID'],$_POST['UserID'],$_POST['Destination']);
	}
	function copyFolder()
	{
		$Owner = $this->M_Folders->getFolderOwner($_POST['ID']);
		if($this->UserID != $this->M_Folders->getFolderOwner($ID) && !$GLOBALS['config']['ufel'][$this->M_Users->getUserRank($Owner)][$_SESSION['auth']['accesslevel']])
		{
			return "Access denied.";
		}
		$result = $this->copyDirectory($_POST['ID'],$_POST['UserID'],$_POST['Destination']);
		if($result == "Directory Copied."){return "Folder Copy completed.";}
		else{return $result;}
	}
	private function copyDirectory($DirectoryID, $UserID, $Destination)
	{
		$NewFolderID = $this->M_Folders->newFolder($this->M_Folders->getFolderName($DirectoryID), $UserID, $Destination);
		
		$Folders = $this->M_Folders->getFolders($UserID, $DirectoryID);
		$Files = $this->M_Files->getFiles($UserID, $DirectoryID);
		
		foreach($Folders as $Folder)
		{
			$result = $this->copyDirectory($Folder['id'],$UserID,$NewFolderID);
			if($result != "Directory Copied."){return $result;}
		}
		foreach($Files as $File)
		{
			$Filecontents = $this->M_Files->getFileContents($File['id']);
			if(strlen($Filecontents) > ($this->M_Users->getUserQuota($UserID) - $this->M_Files->getUserUsedSpace($UserID)))
			{
				return "Insufficient storage space.";
			}
			$this->M_Files->copyFile($File['id'],$UserID,$NewFolderID);
		}
		
		return "Directory Copied.";
	}
	private function zipFolder($ZIPFILE, $DirectoryID, $UserID, $URL='')
	{
		$Folders = $this->M_Folders->getFolders($UserID, $DirectoryID);
		$Files = $this->M_Files->getFiles($UserID, $DirectoryID);
		foreach($Folders as $Folder)
		{
			$ZIPFILE->addEmptyDir($URL.$Folder['name'].'/');
			$this->zipFolder($ZIPFILE, $Folder['id'], $UserID, $URL.$Folder['name'].'/');
		}
		foreach($Files as $File)
		{
			$ZIPFILE->addFromString($URL.$File['name'], $this->M_Files->getFileContents($File['id']));
		}
	}
}
?>
