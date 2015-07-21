<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Users extends Model {
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
			$salt = mt_rand();
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
			return "<div class='alert alert-danger'>Error deleting user.</div>";							
		}
        return '<div class="alert alert-success">User '.$ID.' deleted.</div>';
	}
	public function getUser($Email)
	{
		$sql = "SELECT * FROM CS_Users WHERE email = :email;";
		try 
		{
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':email' => $Email));
		}
		catch (PDOException $e){
			$this->DBO->showErrorPage("Error retrieving user.",$e );							
		}
		$array = $rs->fetchAll();
		return $array[0];
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
			return "<div class='alert alert-danger'>Error updating user.</div>";						
		}
        return "<div class='alert alert-success'>Quota Updated.</div>";
    }
    public function updateUserEmail($ID, $EMAIL)
    {
        $sql = "UPDATE CS_Users SET email=:email WHERE id = :id;";
		try 
        {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':id' => $ID, ':email' => $EMAIL));
		}
		catch (PDOException $e)
        {
			return "<div class='alert alert-danger'>Error updating user.</div>";						
		}
        return "<div class='alert alert-success'>Email Updated.</div>";
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
			return "<div class='alert alert-danger'>Error updating user.</div>";						
		}
        return "<div class='alert alert-success'>First Name Updated.</div>";
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
			return "<div class='alert alert-danger'>Error updating user.</div>";						
		}
        return "<div class='alert alert-success'>First Name Updated.</div>";
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
			return "<div class='alert alert-danger'>Error updating user.</div>";						
		}
        return "<div class='alert alert-success'>Rank Updated.</div>";
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
        if($rs->rowCount() == 0){return 'Record no longer exists.';}
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
        if($rs->rowCount() == 0){return 'Record no longer exists.';}
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
}

?>
