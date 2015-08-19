<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Server extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
	}
	function index()
	{
        $TPL['users'] = $this->M_Users->getUserCount();
        $TPL['avatars'] = 0;
        $TPL['files'] = 0;
        $TPL['folders'] = 0;
		$this->view->render('server',$TPL);
	}
    function resetUsers()
    {
        $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);

        $query = file_get_contents("Scripts/resetUsers.sql");
        return $query;
        $stmt = $db->prepare($query);

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
