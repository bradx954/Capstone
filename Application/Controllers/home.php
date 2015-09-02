<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Home extends Controller 
{
	private $M_Users;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
	}
	function index()
	{
		$TPL['Users'] = $this->M_Users->getCount();
		$TPL['Login_Page'] = $this->MUserAuth->login_page;
		$this->view->render('home',$TPL);
	}
	function registerNewUser()
	{
		return $this->M_Users->createUser($_POST['fName'],$_POST['lName'],$_POST['email'],$_POST['password'],$_POST['question'],$_POST['answer']);
	}
	function login()
	{
		return $this->MUserAuth->login($_POST['email'],$_POST['password']);
	}
	function logout()
	{
		$this->MUserAuth->logout();
		$this->index();
	}
    function checkEmail()
    {
        $EMAIL = $_POST['email'];
        $ID = $this->M_Users->getUserID($EMAIL);
        if($ID == "Error retreiving user id."){return $ID;}
        $QUESTION = $this->M_Users->getUserQuestion($ID);
        if($QUESTION == ""){return "No user with specified email found.";}
        return $QUESTION;
    }
    function checkAnswer()
    {
        $ANSWER = $_POST['answer'];
        $EMAIL = $_POST['email'];
        $ID = $this->M_Users->getUserID($EMAIL);
        switch($this->M_Users->verifyAnswer($ID, $ANSWER))
        {
            case true:
            return "Answer Correct.";
            break;
            case false:
            return "Wrong Answer.";
            break;
            default:
            return "Unknown server error.";
        }
    }
    function updatePassword()
    {
        $ANSWER = $_POST['answer'];
        $EMAIL = $_POST['email'];
        $ID = $this->M_Users->getUserID($EMAIL);
        $PASSWORD = $_POST['password'];
        return $this->M_Users->updateUserPassword($ID, $ANSWER, $PASSWORD);
    }
}
?>
