<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class M_Files extends Model {
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
        $sql = "SELECT COUNT(*) FROM CS_Files;";
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
	function getUserCount($UserID)
	{
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare("SELECT COUNT(*) FROM CS_Files WHERE userid = :userid;");
			$rs->execute(array(':userid' => $UserID));
		}
		catch (PDOException $e){
			//$this->DBO->showErrorPage($sql,$e );
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
	}
	function newFile($FileName, $UserID, $ParentID=0)
	{
		$filelocation = $this->getUserCount($UserID);
		if(!file_exists(ROOT.'/Files/'.$UserID)){mkdir(ROOT.'/Files/'.$UserID,0777);}
		if($filelocation != -1)
		{
			try 
			{
				$rs = NULL;
				$rs = $this->DBH->prepare("insert into CS_Files(name,filelocation,filesize,userid,folderid) values(:filename,:filelocation,:filesize,:userid,:parentid);");
				$rs->execute(array(':filename' => $FileName, ':filelocation' => $filelocation, ':filesize' => 0, ':userid' => $UserID, ':parentid' => $ParentID));
			}
			catch (PDOException $e)
			{
				return "Error creating file: ".$e." please contact brad.baago@linux.com.";							
			} 
			file_put_contents(ROOT.'/Files/'.$UserID.'/'.$filelocation, "");
			return 'File Created.';
		}
		else{return "Error creating file please contact brad.baago@linux.com.";}
	}
}
?>
