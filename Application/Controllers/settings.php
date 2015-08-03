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
        $TPL['email'] = $this->M_Users->getUserEmail($this->UserID);
        $TPL['fname'] = $this->M_Users->getUserFirstName($this->UserID);
        $TPL['lname'] = $this->M_Users->getUserLastName($this->UserID);
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
        $avatar = $_POST['image'];
        if($avatar ==""){return 'Error no image';}
        if(strlen($avatar) > 50000)
        {
            return "Image to large.";
        }
        $result = $this->M_Users->updateUserAvatar($this->UserID,$avatar);
        if($result == "Avatar Updated.")
        {
            $_SESSION['auth']['avatar'] = $avatar;
            return $result;
        }
        return $result;
    }
    function deleteUserAvatar()
    {
        $result = $this->M_Users->updateUserAvatar($this->UserID,"");
        if($result == "Avatar Updated.")
        {
            $_SESSION['auth']['avatar'] = "data:image/png;base64,".base64_encode(file_get_contents('Web/Images/default-avatar.jpg'));
            return "Avatar Deleted.";
        }
        return $result;
    }
}
?>
