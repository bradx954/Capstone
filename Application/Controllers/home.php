<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
/**
 * Controller for home page.
 */
class Home extends Controller {

    private $M_Users;
    private $M_Files;
    /**
     * Creates models on construct.
     */
    function __construct() {
        parent::__construct();
        $this->M_Users = new M_Users();
        $this->M_Files = new M_Files();
    }
    /**
     * Renders the page.
     */
    function index() {
        $TPL['Users'] = $this->M_Users->getCount();
        $TPL['Bytes'] = $this->M_Files->getUsedSpace();
        $TPL['Login_Page'] = $this->MUserAuth->login_page;
        $this->view->render('home', $TPL);
    }
    /**
     * Creates new user.
     * @return string result.
     */
    function registerNewUser() {
        return $this->M_Users->createUser($_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['password'], $_POST['question'], $_POST['answer']);
    }
    /**
     * Attempts login.
     * @return string result
     */
    function login() {
        return $this->MUserAuth->login($_POST['email'], $_POST['password']);
    }
    /**
     * Destroys session. Redirects to home page.
     */
    function logout() {
        $this->MUserAuth->logout();
        $this->index();
    }
    /**
     * Checks if email is valid.
     * @return string error or security question.
     */
    function checkEmail() {
        $EMAIL = $_POST['email'];
        $ID = $this->M_Users->getUserID($EMAIL);
        if ($ID == "Error retreiving user id.") {
            return $ID;
        }
        $QUESTION = $this->M_Users->getUserQuestion($ID);
        if ($QUESTION == "") {
            return "No user with specified email found.";
        }
        return $QUESTION;
    }
    /**
     * Checks if answer to security question is valid.
     * @return string result.
     */
    function checkAnswer() {
        $ANSWER = $_POST['answer'];
        $EMAIL = $_POST['email'];
        $ID = $this->M_Users->getUserID($EMAIL);
        switch ($this->M_Users->verifyAnswer($ID, $ANSWER)) {
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
    /**
     * Updates the given users password.
     * @return string result.
     */
    function updatePassword() {
        $ANSWER = $_POST['answer'];
        $EMAIL = $_POST['email'];
        $ID = $this->M_Users->getUserID($EMAIL);
        $PASSWORD = $_POST['password'];
        return $this->M_Users->updateUserPassword($ID, $ANSWER, $PASSWORD);
    }
}
?>
