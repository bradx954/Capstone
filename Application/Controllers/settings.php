<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Settings extends Controller 
{
	private $M_Users;
    private $M_Avatars;
	private $M_Files;
	private $M_Folders;
    private $UserID;
	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
        $this->M_Avatars = new M_Avatars();
		$this->M_Files = new M_Files();
		$this->M_Folders = new M_Folders();
        $this->UserID = $_SESSION['auth']['id'];

	}
	function index()
	{
        $TPL['email'] = $this->M_Users->getUserEmail($this->UserID);
        $TPL['fname'] = $this->M_Users->getUserFirstName($this->UserID);
        $TPL['lname'] = $this->M_Users->getUserLastName($this->UserID);
        $TPL['rank'] = $this->M_Users->getUserRank($this->UserID);
        $TPL['quota'] = $this->M_Users->getUserQuota($this->UserID);
        $TPL['rdate'] = $this->M_Users->getUserRegisterDate($this->UserID);

        $TPL['files'] = $this->M_Files->getUserCount($this->UserID);
        $TPL['folders'] = $this->M_Folders->getUserCount($this->UserID);
        $TPL['usedspace'] = $this->M_Files->getUserUsedSpace($this->UserID);
        $TPL['freespace'] = $TPL['quota']-$TPL['usedspace'];

		$this->view->render('settings',$TPL);
	}
    function deleteUser()
    {
        return $this->M_Users->deleteUser($this->UserID);
    }
    function updateUserEmail()
    {
        $email = $_POST['email'];
        if($GLOBALS['config']['usel']['email'][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserEmail($this->UserID,$email);}
        else{return "insufficent permissions.";}
    }
    function updateUserFirstName()
    {
        $firstName = $_POST['firstName'];
        if($GLOBALS['config']['usel']['fname'][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserFirstName($this->UserID,$firstName);}
        else{return "insufficent permissions.";}
    }
    function updateUserLastName()
    {
        $lastName = $_POST['lastName'];
        if($GLOBALS['config']['usel']['lname'][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserLastName($this->UserID,$lastName);}
        else{return "insufficent permissions.";}
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
        $result = $this->M_Avatars->setAvatar($this->UserID,$avatar);
        if($result == "Avatar Updated.")
        {
            $_SESSION['auth']['avatar'] = $avatar;
            return $result;
        }
        return $result;
    }
    function deleteUserAvatar()
    {
        $result = $this->M_Avatars->setAvatar($this->UserID,"");
        if($result == "Avatar Updated.")
        {
            $_SESSION['auth']['avatar'] = "data:image/png;base64,".base64_encode(file_get_contents('Web/Images/default-avatar.jpg'));
            return "Avatar Deleted.";
        }
        return $result;
    }
}
?>
