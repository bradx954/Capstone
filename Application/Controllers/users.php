<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
class Users extends Controller 
{
	private $M_Users;

	function __construct() 
	{
		parent::__construct(); 
		$this->M_Users = new M_Users();
	}
	function index()
	{
        $TPL['users'] = $this->M_Users->getUsers();
		$this->view->render('admin',$TPL);
	}
    function deleteUser()
    {
        $id = $_POST['id'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->deleteUser($id);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function deactivateUser()
    {
        $id = $_POST['id'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->deactivateUser($id);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function activateUser()
    {
        $id = $_POST['id'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->activateUser($id);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function updateUserQuota()
    {
        $id = $_POST['id'];
        $bytes = $_POST['bytes'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserQuota($id,$bytes);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function updateUserEmail()
    {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserEmail($id,$email);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function updateUserFirstName()
    {
        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserFirstName($id,$firstName);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function updateUserLastName()
    {
        $id = $_POST['id'];
        $lastName = $_POST['lastName'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserLastName($id,$lastName);}
        else{return 'Insuficent permisions to perform action.';}
    }
    function updateUserRank()
    {
        $id = $_POST['id'];
        $userRank = $_POST['rank'];
        $rank = $this->M_Users->getUserRank($id);
        if($GLOBALS['config']['uel'][$rank][$_SESSION['auth']['accesslevel']] && $GLOBALS['config']['uel'][$userRank][$_SESSION['auth']['accesslevel']]){return $this->M_Users->updateUserRank($id,$userRank);}
        else{return 'Insuficent permisions to perform action.';}
    }
}
?>
