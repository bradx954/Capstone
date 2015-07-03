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
		$sql = "DELETE FROM CS_Users WHERE compid = :ID;";
		try {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':ID' => $ID));
		}
		catch (PDOException $e){
			$this->DBO->showErrorPage("Error deleting user.",$e );							
		}
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
	public function updateUser($ID,$username, $password, $accesslevel, $freezeaccount)
	{
		$sql = "UPDATE CS_Users SET username='".$username."', password='".$password."', accesslevel='".$accesslevel."',freezeaccount='".$freezeaccount."' WHERE compid = ".$ID.";";
		try {
			$rs = NULL;
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':order' => $order));
		}
		catch (PDOException $e){
			$this->DBO->showErrorPage("Error updating user.",$e );							
		}
	}
	
}

?>
