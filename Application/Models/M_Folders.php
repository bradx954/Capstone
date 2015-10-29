<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class M_Folders extends Model {
	private   $DBO;
	private   $DBH;

	public function __construct(  )
	{ 
	     parent::__construct();

	     $this->DBO = Database::getInstance();
	     $this->DBH = $this->DBO->getPDOConnection();
	}
    function getCount()
    {
        $sql = "SELECT COUNT(*) FROM CS_Folders";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->query($sql);
		}
		catch (PDOException $e){
			//$this->DBO->showErrorPage($sql,$e );
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
	function newFolder($FolderName, $UserID, $ParentID=0)
	{
		if($FolderName == ""){return "Folder name blank.";}
		$sql = "SELECT COUNT(*) FROM CS_Folders WHERE userid = :userid AND name = :name AND folderid = :folderid;";
		try {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':userid' => $UserID, ':name' => $FolderName, ':folderid' => $ParentID));
		}
		catch (PDOException $e){
			return "Failed to create folder.";
		}
		$array = $rs->fetchAll();
		if($array[0][0] > 0)
		{
			return "Folder already exists.";
		}
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("insert into CS_Folders(name,userid,folderid) values(:foldername,:userid,:parentid);");
			$rs->execute(array(':foldername' => $FolderName, ':userid' => $UserID, ':parentid' => $ParentID));
		}
		catch (PDOException $e)
		{
			return "Error creating folder: ".$e." please contact brad.baago@linux.com.";							
		} 
		return 'Folder Created.';
	}
	function getFolders($UserID, $FolderID=0)
	{
		$sql = "SELECT * from CS_Folders WHERE userid = :userid AND folderid = :folderid;";
		try {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':userid' => $UserID, ':folderid' => $FolderID));
			foreach ($rs->fetchAll() as $row): 
					$arr[]  =  $row;  
			endforeach;
		}
		catch (PDOException $e){
			return "Failed to retrieve folders.";
		} 
		if(is_array($arr)){return $arr;}
		else{return array();}
	}
	function getFolderOwner($ID)
	{
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("SELECT userid FROM CS_Folders WHERE id = :id;");
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			//$this->DBO->showErrorPage($sql,$e );
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
	}
	//Deletes specified folder and subfolders
	//Takes folder ID to delete.
	//Returns folders deleted array.
	function deleteDirectory($ID)
	{
		$IDS = array($ID);
		$newIDS = $IDS;
		while(count($newIDS) > 0)
		{
			try 
			{
				$rs = NULL;
				$rs = $this->DBH->prepare("SELECT ID FROM CS_Folders WHERE FIND_IN_SET(folderid, :ids);");
				$rs->execute(array(':ids' => implode(',', $newIDS)));
				$newIDS = array();
				foreach ($rs->fetchAll() as $row): 
					array_push($newIDS,$row[0]);
				endforeach;
				$IDS = array_merge($IDS, $newIDS);
			}
			catch (PDOException $e)
			{
				return "Error selecting sub folders: ".$e." please contact brad.baago@linux.com.";							
			}
		}
		$this->deleteFolders($IDS);
		return $IDS;
	}
	function deleteFolder($ID)
	{
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("DELETE FROM CS_Folders WHERE id = :id;");
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e)
		{
			return "Error deleting folder: ".$e." please contact brad.baago@linux.com.";							
		}
		return "Folder deleted.";
	}
	function deleteFolders($IDS)
	{
		foreach($IDS as $ID)
		{
			try
			{
				$this->deleteFolder($ID);
			}
			catch(PDOException $e)
			{
				return "Error deleting folders.";
			}
		}
		return "Folders ".implode(',',$IDS)." deleted.";
	}
	function getFolderPath($ID=0)
	{
		if($ID == 0){return $PATH;}
		while($ID != 0)
		{
			try 
			{
				$rs = NULL;
				$rs = $this->DBH->prepare("SELECT name,folderid FROM CS_Folders WHERE id = :id;");
				$rs->execute(array(':id' => $ID));
			}
			catch (PDOException $e){
				//$this->DBO->showErrorPage($sql,$e );
				return "Error getting file path ".$e." please contact brad.baago@linux.com.";							
			} 
			$array = $rs->fetchAll();
			$NAME = $array[0][0];
			$PATH = $NAME."/".$PATH;
			$ID = $array[0][1];
		}
		return "/".$PATH;
	}
	function getFolderParent($ID)
	{
		if($ID == 0){return 0;}
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("SELECT folderid FROM CS_Folders WHERE id = :id;");
			$rs->execute(array(':id' => $ID));
			$array = $rs->fetchAll();
			return $array[0][0];
		}
		catch (PDOException $e){
			//$this->DBO->showErrorPage($sql,$e );
			return "Error getting file path ".$e." please contact brad.baago@linux.com.";							
		} 
	}
	function getUserCount($UserID)
	{
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("SELECT COUNT(*) FROM CS_Folders WHERE userid = :userid;");
			$rs->execute(array(':userid' => $UserID));
		}
		catch (PDOException $e){
			//$this->DBO->showErrorPage($sql,$e );
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
	}
	function updateFolderName($ID, $Contents)
	{
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("UPDATE CS_Folders SET name = :name WHERE id = :id;");
			$rs->execute(array(':id' => $ID, ':name' => $Contents));
		}
		catch (PDOException $e)
		{
			return "Error renaming folder: ".$e." please contact brad.baago@linux.com.";							
		} 
		return "Folder Renamed.";
	}
	function getFolderName($ID)
	{
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("SELECT name FROM CS_Folders WHERE id = :id;");
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			//$this->DBO->showErrorPage($sql,$e );
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
	}
	function updateParentID($ID, $ParentID)
	{
		$sql = "SELECT COUNT(*) FROM CS_Folders WHERE name = :name AND folderid = :folderid;";
		try {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':name' => $this->getFolderName($ID), ':folderid' => $ParentID));
		}
		catch (PDOException $e){
			return "Failed to move folder.";
		}
		$array = $rs->fetchAll();
		if($array[0][0] > 0)
		{
			return "Folder already exists.";
		}
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("UPDATE CS_Folders SET folderid = :parent WHERE id = :id;");
			$rs->execute(array(':id' => $ID, ':parent' => $ParentID));
		}
		catch (PDOException $e)
		{
			return "Error updating folder: ".$e." please contact brad.baago@linux.com.";							
		} 
		return "Folder parent updated.";
	}
}
?>
