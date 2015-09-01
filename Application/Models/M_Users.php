<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class M_Users extends Model {
	private   $DBO;
	private   $DBH;

	public function __construct(  )
	{ 
	 parent::__construct();

	 $this->DBO = Database::getInstance();
	 $this->DBH = $this->DBO->getPDOConnection();
	} 
		
		 
	public function getUsers($order='email')
	{
			$sql = "SELECT * from CS_Users order by :order";
			try {
				$rs = NULL;
				$rs = $this->DBH->prepare($sql);
				$rs->execute(array(':order' => $order));
				foreach ($rs->fetchAll() as $row): 
						$arr[]  =  $row;  
				endforeach;
			}
			catch (PDOException $e){
				$this->DBO->showErrorPage("Unable to retrieve all entries from database",$e );							
			} 
			return $arr;
	}
	public function getUserCount()
	{
		$sql = "SELECT COUNT(*) FROM CS_Users";
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
	public function createUser($firstname, $lastname, $email, $password, $question, $answer, $quota=1000000, $rank='user', $active=1)
	{
		$firstname = ucwords(strtolower($firstname));
		$lastname = ucwords(strtolower($lastname));
		if(is_array($this->getUser(mysql_escape_string($email))))
		{
			return '<div class="alert alert-danger">Email already registered.</div>';	
		}
		else
		{
			$salt = 1;
			$password = hash("md5", hash("md5", $password) + $salt);
			$answer = hash("md5", hash("md5", $answer) + $salt);
			//$sql = "insert into CS_Users(firstname,lastname,email,password, question, answer, quota, salt, rank, active) values ('".mysql_escape_string($firstname)."','".mysql_escape_string($lastname)."','".mysql_escape_string($email)."','".$password."','".mysql_escape_string($question)."','".$answer."',".$quota.",'".$salt."','".$rank."', ".$active.");";
			try 
			{
				$rs = NULL;
				$rs = $this->DBH->prepare("insert into CS_Users(firstname,lastname,email,password, question, answer, quota, salt, rank, active) values (:firstname,:lastname,:email,:password, :question, :answer, :quota, :salt, :rank, :active);");
				$rs->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':password' => $password, ':question' => $question, ':answer' => $answer, ':quota' => $quota, ':salt' => $salt, ':rank' => $rank, ':active' => $active));
				//$rs = $this->DBH->query($sql);
			}
			catch (PDOException $e)
			{
				//$this->DBO->showErrorPage($sql,$e );
				return '<div class="alert alert-danger">Database error! Please contact brad.baago@linux.com error:'.$e.'</div>';							
			} 
			return '<div class="alert alert-success">Sign up complete!</div>';
		}
	}
	public function deleteUser($ID)
	{
		$sql = "DELETE FROM CS_Users WHERE id = :ID;";
		try {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':ID' => $ID));
		}
		catch (PDOException $e){
			return "Error deleting user.";							
		}
        if($rs->rowCount() == 0){return 'Record no longer exists.';}
        return 'User '.$ID.' deleted.';
	}
	public function getUser($EMAIL)
	{
		$sql = "SELECT * FROM CS_Users WHERE email = :email;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':email' => $EMAIL));
		}
		catch (PDOException $e){
			return 'Error retreiving user.';						
		}
		$array = $rs->fetchAll();
		return $array[0];
	}
    public function getUserID($EMAIL)
    {
        $sql = "SELECT id FROM CS_Users WHERE email = :email;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':email' => $EMAIL));
		}
		catch (PDOException $e){
			return 'Error retreiving user id.';						
		}
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function userExists($ID)
    {
        $sql = "SELECT count(*) FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return 'Error retreiving user.';						
		}
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserRank($ID)
    {
        $sql = "SELECT rank FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserQuestion($ID)
    {
        $sql = "SELECT question FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserRegisterDate($ID)
    {
        $sql = "SELECT reg_date FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserEmail($ID)
    {
        $sql = "SELECT email FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserFirstName($ID)
    {
        $sql = "SELECT firstname FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserLastName($ID)
    {
        $sql = "SELECT lastname FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    public function getUserQuota($ID)
    {
        $sql = "SELECT quota FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    private function getUserSalt($ID)
    {
        $sql = "SELECT salt FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    private function getUserAnswer($ID)
    {
        $sql = "SELECT answer FROM CS_Users WHERE id = :id;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;							
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
	public function updateUserQuota($ID, $BYTES)
    {
        $sql = "UPDATE CS_Users SET quota=:quota WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':quota' => $BYTES));
		}
		catch (PDOException $e)
        {
			return "Error updating user.";						
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "Quota Updated.";
    }
    public function updateUserEmail($ID, $EMAIL)
    {
        if(is_array($this->getUser($EMAIL)))
		{
			return 'Email already registered.';
		}
        $sql = "UPDATE CS_Users SET email=:email WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':email' => $EMAIL));
		}
		catch (PDOException $e)
        {
			return "Error updating user.";						
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "Email Updated.";
    }
    public function updateUserPassword($ID, $ANSWER, $PASSWORD)
    {
        $SALT = $this->getUserSalt($ID);
        if($this->verifyAnswer($ID, $ANSWER) == false){return "Reset request denied.";}
        $PASSWORD = hash("md5", hash("md5", $PASSWORD) + $SALT);
        $sql = "UPDATE CS_Users SET password=:password WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':password' => $PASSWORD));
		}
		catch (PDOException $e)
        {
			return "Error updating user password.";						
		}
        return "Password Updated.";
    }
    public function verifyAnswer($ID, $ANSWER)
    {
        $SALT = $this->getUserSalt($ID);
        $ANSWER = hash("md5", hash("md5", $ANSWER) + $SALT);
        if($ANSWER != $this->getUserAnswer($ID)){return false;}
        else{return true;}
    }
    public function updateUserFirstName($ID, $FIRSTNAME)
    {
        $sql = "UPDATE CS_Users SET firstname=:firstname WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':firstname' => $FIRSTNAME));
		}
		catch (PDOException $e)
        {
			return "Error updating user.";						
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "First Name Updated.";
    }
    public function updateUserLastName($ID, $LASTNAME)
    {
        $sql = "UPDATE CS_Users SET lastname=:lastname WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':lastname' => $LASTNAME));
		}
		catch (PDOException $e)
        {
			return "Error updating user.";						
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "Last Name Updated.";
    }
    public function updateUserRank($ID, $RANK)
    {
        $sql = "UPDATE CS_Users SET rank=:rank WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':rank' => $RANK));
		}
		catch (PDOException $e)
        {
			return "Error updating user.";						
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "Rank Updated.";
    }
    public function activateUser($ID)
    {
        $sql = "UPDATE CS_Users SET active=1 WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e)
        {
			"Error updating user.";							
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "User Activated.";	
    }
	public function deactivateUser($ID)
    {
        $sql = "UPDATE CS_Users SET active=0 WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e)
        {
			return "Error updating user.";						
		}
        if($rs->rowCount() == 0 && $this->userExists($ID) == false){return 'User no longer exists.';}
        return "User Deactivated.";	
    }
    public function checkActive($ID)
    {
        $sql = "SELECT active FROM CS_Users WHERE id = :id;";
        try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
		}
		catch (PDOException $e){
			return -1;			
		} 
		$array = $rs->fetchAll();
		return $array[0][0];
    }
    function resetUsers()
    {
        $query = file_get_contents("Scripts/resetUsers.sql");
        
        $stmt = $this->DBH->prepare($query);

        if ($stmt->execute())
        {
             return "Reset Success.";
        }
        else
        {
             return "Reset Failed.";
        }
    }
}

?>
