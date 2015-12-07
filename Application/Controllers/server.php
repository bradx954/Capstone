<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
/**
 * Controller for server page.
 */
class Server extends Controller {
    
    private $M_Users;
    /**
     * Creates models on construct.
     */
    function __construct() {
        parent::__construct();
        $this->M_Users = new M_Users();
        $this->M_Avatars = new M_Avatars();
        $this->M_Files = new M_Files();
        $this->M_Folders = new M_Folders();
    }
    /**
     * Renders the page.
     */
    function index() {
        $TPL['users'] = $this->M_Users->getCount();
        $TPL['avatars'] = $this->M_Avatars->getCount();
        $TPL['files'] = $this->M_Files->getCount();
        $TPL['folders'] = $this->M_Folders->getCount();
        $this->view->render('server', $TPL);
    }
    /**
     * Resets the users.
     * @return string result.
     */
    function resetUsers() {
        return $this->M_Users->resetUsers();
    }
    /**
     * Resets the avatars.
     * @return string result.
     */
    function resetAvatars() {
        return "Not implemented.";
    }
    /**
     * Resets the files.
     * @return string result.
     */
    function resetFiles() {
        return "Not implemented.";
    }
    /**
     * Resets the folders.
     * @return string result.
     */
    function resetFolders() {
        return "Not implemented.";
    }
}
?>
