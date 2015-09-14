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
		return $arr;
	}
}
?>
