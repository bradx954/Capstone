<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Settings extends Controller 
{
	private $M_Users;
    private $UserID;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
        $this->UserID = $_SESSION['auth']['id'];

	}
	function index()
	{
		$this->view->render('settings',$TPL);
	}
    function deleteUser()
    {
        return $this->M_Users->deleteUser($this->UserID);
    }
    function updateUserEmail()
    {
        $email = $_POST['email'];
        return $this->M_Users->updateUserEmail($this->UserID,$email);
    }
    function updateUserFirstName()
    {
        $firstName = $_POST['firstName'];
        return $this->M_Users->updateUserFirstName($this->UserID,$firstName);
    }
    function updateUserLastName()
    {
        $lastName = $_POST['lastName'];
        return $this->M_Users->updateUserLastName($this->UserID,$lastName);
    }
    function updateUserPassword()
    {
        $curentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
    }
    function updateUserQuestion()
    {
        $curentPassword = $_POST['currentPassword'];
        $question = $_POST['question'];
        $answer = $_POST['answer'];
    }
    function updateUserAvatar()
    {
        $avatar = $_FILES['newImage']['tmp_name'];
        return $this->M_Users->updateUserAvatar($this->UserID,$avatar);
    }
}
?>
