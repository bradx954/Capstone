<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class UserAuth extends Model { 
	private   $DBO;
	private   $DBH;
	
	private $DB_users =  ''; 

	public $login_page = 'index.php?c=home';   
	private $logout_page = "index.php?c=home";
	private $error_page = 'errorpage';

	private $email;
	private $password;
	private $values;
	private $admin;  
	private $activate;  
	private $adminpage;

	public function __construct(  )
	{ 
	 parent::__construct();

	 $this->DBO = Database::getInstance();
	 $this->DBH = $this->DBO->getPDOConnection();
	} 
		
	 /**
    * @return string
    * @desc Login handling
    */
    public function login($email, $password) {
        
        //User is already logged in if SESSION variables are good. 
        if ($this->validSessionExists() == true):
            return 'Already logged in.';
       endif;
	   
	   //First time users don't get an error message.... 
	   //if ($_SERVER['REQUEST_METHOD'] == 'GET') return;
        
        //Check login form for well formedness.....if bad, send error message
        if ($this->formHasValidCharacters($email, $password) == false):
                return "Invalid Form!";
        endif;
        
        // verify if form's data coresponds to database's data
		if ($this->userIsInDatabase() == false):
			return 'Invalid username/password. ';
		else :
				//We're in!
				//Don't let people who's accounts are frozen in.
				//Redirect authenticated users to the correct landing page
				// ex: admin goes to admin, gold goes to help desk etc....
				
				$this->writeSession();
				if($_SESSION['auth']['active'] == 0)
				{
					$_SESSION = array();
        				session_destroy();
					return 'Account is suspended';
				}
				return 'Login Success';
	   endif;
    }
	
	/**
    * @return void
    * @desc Validate if user is logged in
    */
    public function loggedin() {
        
         //Users who are not logged in are redirected out
        if ($this->validSessionExists() == false):
			return false;
         endif;  
	if(isset($_GET['c']) && isset($_SESSION['auth'])){
		$controller = $_GET['c'];
		$access = $_SESSION['auth']['accesslevel'];
		 if($GLOBALS['config']['acl'][$controller][$access] == true){return true;}
		else{return false;}}
		//Access Control List checking goes here..
		//Does user have sufficient permissions to access page?
		//Ex. Can a bronze level access the Admin page?   
    }
	
	/**
    * @return void
    * @desc The user will be logged out.
    */
    public function logout() {
        $_SESSION = array();
        session_destroy();
        header("Location: ".$this->logout_page);
    }
    
    /**
    * @return bool
    * @desc Verify if user has got a session and if the user's IP corresonds to the IP in the session.
    */
    public function validSessionExists() {
        if (!isset($_SESSION['auth'])):
            return false;
       else:
	    if($_SESSION['auth']['ipAddress'] != $_SERVER['REMOTE_ADDR']){return false;}
            return true;
        endif;
    }
    
	/**
    * @return void
    * @desc Verify if login form fields were filled out correctly
    */
	public function formHasValidCharacters($email, $password) 
	{
		 //If both values have values at this point, then basic requirements met
        if ( empty($email) == false && empty($password) == false):
				$this->email = $email;
				$this->password = $password;
				return true;
        else:
            	return false;
        endif;
    }
	
	/**
	* @return bool
	* @desc Verify username and password with MySQL database.
	*/
	public function userIsInDatabase() 
	{
		$sql = "SELECT salt FROM CS_Users WHERE email = :email";
		try 
		{
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':email' => $this->email));
			$value = $rs->fetchAll(); 
		}
		catch (PDOException $e)
		{
			return 'Database Error: '.$e.' Please contact brad.baago@linux.com';						
		}
		$salt = $value[0][0];
		$this->password = hash("md5", hash("md5", $this->password) + $salt);
		$sql = "SELECT * FROM CS_Users WHERE email = :email AND password = :password;";
		$rs = NULL;
		try 
		{
			$rs = $this->DBH->prepare($sql);
			$rs->execute(array(':email' => $this->email, ':password' => $this->password));
			$value = $rs->fetchAll(); 
		}
		catch (PDOException $e)
		{
			return 'Database Error: '.$e.' Please contact brad.baago@linux.com';						
		}
		if(isset($value[0]))
		{
			$this->values = $value[0];
			return true;
		}
		else{return false;}
	}
    
    
    /**
    * @return void
    * @param string $page
    * @desc Redirect the browser to the value in $page.
    */
    public function redirect($page) {
	
        header("Location: ".$page);
        exit();
    }
    
    /**
    * @return void
    * @desc Write username, email and IP into the session.
    */
    public function writeSession() 
    {
	    $_SESSION['auth']['email'] = $this->values[3];
	    $_SESSION['auth']['ipAddress'] = $_SERVER['REMOTE_ADDR'];
	    $_SESSION['auth']['accesslevel'] = $this->values[11];
	    $_SESSION['auth']['active'] = $this->values[9];
	    $_SESSION['auth']['logintime'] = date("Y-m-d h:m:s",time());
        $_SESSION['auth']['id'] = $this->values[0];
        if(isset($this->values[12]) != true || $this->values[12]==""){$_SESSION['auth']['avatar'] = "data:image/png;base64,".base64_encode(file_get_contents('Web/Images/default-avatar.jpg'));}
        else{$_SESSION['auth']['avatar'] = $this->values[12];}
     }
	
	/**
    * @return string
    * @desc Username getter, not necessary 
    */
	public function getUsername() {
		return $_SESSION['auth']['email'];
    }
	
}

?>
