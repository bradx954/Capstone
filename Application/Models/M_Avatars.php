<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class M_Avatars extends Model {
	private   $DBO;
	private   $DBH;

	public function __construct(  )
	{ 
	     parent::__construct();

	     $this->DBO = Database::getInstance();
	     $this->DBH = $this->DBO->getPDOConnection();
	}
    function getAvatarCount()
    {
        $sql = "SELECT COUNT(*) FROM CS_Avatars";
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
    function getAvatar($USERID)
    {
        $sql = "SELECT id FROM CS_Avatars WHERE userid = :userid;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':userid' => $USERID));
		}
		catch (PDOException $e){
			return 'Error retreiving user id.';						
		}
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    function setAvatar($USERID, $AVATAR)
    {
        $ID = $this->getAvatarID($USERID);
        if($ID != -1){return $this->updateAvatar($ID, $AVATAR);}
        else{return $this->createAvatar($USERID, $AVATAR);}
    }
    private function getAvatarID($USERID)
    {
        $sql = "SELECT id FROM CS_Avatars WHERE userid = :userid;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':userid' => $USERID));
		}
		catch (PDOException $e){
			return -1;						
		}
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    private function createAvatar($USERID, $AVATAR)
    {
        $sql = "insert into CS_Avatars(userid,avatar) values (:userid,:avatar);";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':userid' => $USERID, ':avatar' => $AVATAR));
		}
		catch (PDOException $e){
			return 'Failed to create avatar.';						
		}
		return 'Avatar updated.';
    }
    private function updateAvatar($ID, $AVATAR)
    {
        $sql = "Update CS_Avatars set avatar = :avatar where userid = :userid;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':userid' => $USERID, ':avatar' => $AVATAR));
		}
		catch (PDOException $e){
			return 'Failed to update avatar.';						
		}
		return 'Avatar updated.';
    }
}
?>
