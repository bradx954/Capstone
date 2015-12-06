<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
/**
 * Model for handling avatars.
 */
class M_Avatars extends Model {
    private   $DBO;
    private   $DBH;
    /**
     * Generates database connection.
     */
    public function __construct(  )
    { 
         parent::__construct();

         $this->DBO = Database::getInstance();
         $this->DBH = $this->DBO->getPDOConnection();
    }
    /**
     * Gets the count of avatars.
     * @return int Count
     */
    function getCount()
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
    /**
     * Gets the avatar of specified user.
     * @param int $USERID of user to retrieve.
     * @return string base64 image.
     */
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
    /**
     * Sets the avatar of the given user to the given avatar.
     * @param int $USERID ID of the user.
     * @param string base64 $AVATAR.
     * @return string result.
     */
    function setAvatar($USERID, $AVATAR)
    {
        $ID = $this->getAvatarID($USERID);
        if($ID > -1){return $this->updateAvatar($ID, $AVATAR);}
        else{return $this->createAvatar($USERID, $AVATAR);}
    }
    /**
     * Gets the id of the given user.
     * @param int $USERID the user ID.
     * @return int Avatar ID.
     */
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
    /**
     * Creates a new avatar for the given user with the given avatar.
     * @param int $USERID the user ID.
     * @param string base64 $AVATAR
     * @return string result.
     */
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
		return 'Avatar Updated.';
    }
    /**
     * Updates avatar of the given user with the supplied user ID.
     * @param int $ID the user ID.
     * @param string base64 $AVATAR
     * @return string result.
     */
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
		return 'Avatar Updated.';
    }
}
?>
