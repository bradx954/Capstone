<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class UsersAuth extends Model {
	private   $DBO;
	private   $DBH;
	
	private $DB_users =  '' ; 

	private $member_area = 'main.php';  
	private $login_page = 'main.php?c=login';   
	private $logout_page = "main.php?c=login";
	private $error_page = 'errorpage';

	private $admin_page = "main.php?c=admin";
	private $gold_page = "main.php?c=helpdesk";
	private $silver_page = "main.php?c=supervisors";
	private $bronze_page = "main.php?c=staff";


	private $username;
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
    public function login() {
        
        //User is already logged in if SESSION variables are good. 
        if ($this->validSessionExists() == true):
            $this->redirect($this->member_area);
       endif;
	   
	   //First time users don't get an error message.... 
	   if ($_SERVER['REQUEST_METHOD'] == 'GET') return;
        
        //Check login form for well formedness.....if bad, send error message
        if ($this->formHasValidCharacters() == false):
                return "Invalid characters in form fields! Only letters,numbers, 3-15 chars in length.";
        endif;
        
        // verify if form's data coresponds to database's data
		if ($this->userIsInDatabase() == false):
			return 'Invalid  username/password. ';
		else :
				//We're in!
				//Don't let people who's accounts are frozen in.
				//Redirect authenticated users to the correct landing page
				// ex: admin goes to admin, gold goes to help desk etc....
				
				$this->writeSession();
				if($_SESSION['auth']['freezeaccount'] == "Y")
				{
					$_SESSION = array();
        				session_destroy();
					return 'Account is suspended';
				}
				switch($_SESSION['auth']['accesslevel'])
				{
					case "admin":
						$this->redirect($this->admin_page);
					break;
					case "gold":
						$this->redirect($this->gold_page);
					break;
					case "silver":
						$this->redirect($this->silver_page);
					break;
					case "bronze":
						$this->redirect($this->bronze_page);
					break;
					default:
						$this->redirect($this->member_area);
				}
	   endif;
    }
	
	/**
    * @return void
    * @desc Validate if user is logged in
    */
    public function loggedin() {
        
         //Users who are not logged in are redirected out
        if ($this->validSessionExists() == false):
			return 'Authentication Error: You must be logged in to access site.';
         endif;  
	if(isset($_GET['c']) && isset($_SESSION['auth'])){
		$controller = $_GET['c'];
		$access = $_SESSION['auth']['accesslevel'];
		 $config['acl'] = array('home' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true),
					'staff' 			=> 		array('public' => false,	'bronze'=>true,	'silver'=>true,	'gold'=>false, 	'admin' => true),
					'supervisors' 		=> 		array('public' => false,	'bronze'=>false,'silver'=>true,	'gold'=>false, 	'admin' => true),
					'helpdesk' 			=> 		array('public' => false,	'bronze'=>false,'silver'=>false,'gold'=>true, 	'admin' => true),
					'admin' 			=> 		array('public' => false,	'bronze'=>false,'silver'=>false,'gold'=>false, 	'admin' => true),
					'login' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true),
					'logout' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true),
					'register' 			=> 		array('public' => true,		'bronze'=>true,	'silver'=>true,	'gold'=>true, 	'admin' => true) 
 					);
		 if($config['acl'][$controller][$access] == true){return 'true';}
		else{return 'Access Level Error: You do not have sufficient priveleges to access this resource.';}}
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
	public function formHasValidCharacters() {
	 
		//check form values for strange characters and length (3-12 characters).
		if(strlen($_POST['username']) < 3 || strlen($_POST['username']) > 12){ return false;}
		if(strlen($_POST['password']) < 3 || strlen($_POST['password']) > 12){ return false;}
		 //If both values have values at this point, then basic requirements met
        if ( empty($_POST['username']) == false && empty($_POST['password']) == false):
				$this->username = $_POST['username'];
				$this->password = $_POST['password'];
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
		$sql = "SELECT * FROM usersAuth WHERE username = '".$this->username."' AND password = '".$this->password."';";
		$rs = NULL;
		try 
		{
			$rs = $this->DBH->query($sql);
			$value = $rs->fetchAll(); 
		}
		catch (PDOException $e)
		{
			$this->DBO->showErrorPage("Error loging in.",$e );							
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
	$_SESSION['auth']['username'] = $this->values[1];
	$_SESSION['auth']['ipAddress'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['auth']['accesslevel'] = $this->values[4];
	$_SESSION['auth']['freezeaccount'] = $this->values[3];
	$_SESSION['auth']['logintime'] = date("Y-m-d h:m:s",time());
     }
	
	/**
    * @return string
    * @desc Username getter, not necessary 
    */
	public function getUsername() {
		return $_SESSION['auth']['username'];
    }
	
}

?>
