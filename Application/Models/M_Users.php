<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
/**
 * The model for handling users.
 */
class M_Users extends Model {

    private $DBO;
    private $DBH;
    /**
     * Creates database connection on construct.
     */
    public function __construct() {
        parent::__construct();

        $this->DBO = Database::getInstance();
        $this->DBH = $this->DBO->getPDOConnection();
    }
    /**
     * Gets the users in the system by the given order.
     * @param string $order sort order default email.
     * @return array users.
     */
    public function getUsers($order = 'email') {
        $sql = "SELECT * from CS_Users order by :order";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':order' => $order));
            foreach ($rs->fetchAll() as $row):
                $arr[] = $row;
            endforeach;
        } catch (PDOException $e) {
            $this->DBO->showErrorPage("Unable to retrieve all entries from database", $e);
        }
        return $arr;
    }
    /**
     * Gets the count of users in the system.
     * @return int count
     */
    public function getCount() {
        $sql = "SELECT COUNT(*) FROM CS_Users";
        try {
            $rs = NULL;
            $rs = $this->DBH->query($sql);
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Creates a new user.
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $password
     * @param string $question
     * @param string $answer
     * @param int $quota default = 1000000
     * @param string $rank default = user
     * @param int $active default = 1
     * @return string result.
     */
    public function createUser($firstname, $lastname, $email, $password, $question, $answer, $quota = 1000000, $rank = 'user', $active = 1) {
        $firstname = ucwords(strtolower($firstname));
        $lastname = ucwords(strtolower($lastname));
        if (is_array($this->getUser(mysql_escape_string($email)))) {
            return '<div class="alert alert-danger">Email already registered.</div>';
        } else {
            $salt = mt_rand(0, 1000000);
            $password = hash("sha1", $salt . $password);
            $answer = hash("sha1", $salt . $answer);
            //$sql = "insert into CS_Users(firstname,lastname,email,password, question, answer, quota, salt, rank, active) values ('".mysql_escape_string($firstname)."','".mysql_escape_string($lastname)."','".mysql_escape_string($email)."','".$password."','".mysql_escape_string($question)."','".$answer."',".$quota.",'".$salt."','".$rank."', ".$active.");";
            try {
                $rs = NULL;
                $rs = $this->DBH->prepare("insert into CS_Users(firstname,lastname,email,password, question, answer, quota, salt, rank, active) values (:firstname,:lastname,:email,:password, :question, :answer, :quota, :salt, :rank, :active);");
                $rs->execute(array(':firstname' => $firstname, ':lastname' => $lastname, ':email' => $email, ':password' => $password, ':question' => $question, ':answer' => $answer, ':quota' => $quota, ':salt' => $salt, ':rank' => $rank, ':active' => $active));
                //$rs = $this->DBH->query($sql);
            } catch (PDOException $e) {
                //$this->DBO->showErrorPage($sql,$e );
                return '<div class="alert alert-danger">Database error! Please contact brad.baago@linux.com error:' . $e . '</div>';
            }
            return '<div class="alert alert-success">Sign up complete!</div>';
        }
    }
    /**
     * Deletes a given user.
     * @param int $ID user id.
     * @return string result.
     */
    public function deleteUser($ID) {
        $sql = "DELETE FROM CS_Users WHERE id = :ID;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':ID' => $ID));
        } catch (PDOException $e) {
            return "Error deleting user.";
        }
        if ($rs->rowCount() == 0) {
            return 'Record no longer exists.';
        }
        return 'User ' . $ID . ' deleted.';
    }
    /**
     * Get user by email.
     * @param string $EMAIL
     * @return array or string error.
     */
    public function getUser($EMAIL) {
        $sql = "SELECT * FROM CS_Users WHERE email = :email;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':email' => $EMAIL));
        } catch (PDOException $e) {
            return 'Error retreiving user.';
        }
        $array = $rs->fetchAll();
        return $array[0];
    }
    /**
     * Gets userid by email.
     * @param string $EMAIL
     * @return int id or error string.
     */
    public function getUserID($EMAIL) {
        $sql = "SELECT id FROM CS_Users WHERE email = :email;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':email' => $EMAIL));
        } catch (PDOException $e) {
            return 'Error retreiving user id.';
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Check if user id exists.
     * @param int $ID
     * @return boolean true or false.
     */
    public function userExists($ID) {
        $sql = "SELECT count(*) FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return 'Error retreiving user.';
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the rank of the user.
     * @param int $ID
     * @return string rank
     */
    public function getUserRank($ID) {
        $sql = "SELECT rank FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Gets the user security question
     * @param int $ID the user id.
     * @return string question or -1 on error.
     */
    public function getUserQuestion($ID) {
        $sql = "SELECT question FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get user registration date.
     * @param int $ID the user id.
     * @return string date.
     */
    public function getUserRegisterDate($ID) {
        $sql = "SELECT reg_date FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the user email.
     * @param int $ID the user id.
     * @return string email.
     */
    public function getUserEmail($ID) {
        $sql = "SELECT email FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the user first name.
     * @param int $ID the user id.
     * @return string first name.
     */
    public function getUserFirstName($ID) {
        $sql = "SELECT firstname FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the user last name.
     * @param int $ID the user id.
     * @return string last name.
     */
    public function getUserLastName($ID) {
        $sql = "SELECT lastname FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the user quote.
     * @param int $ID the user id.
     * @return int bytes.
     */
    public function getUserQuota($ID) {
        $sql = "SELECT quota FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the user salt.
     * @param int $ID the user id.
     * @return string salt.
     */
    private function getUserSalt($ID) {
        $sql = "SELECT salt FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Get the user security answer.
     * @param int $ID the user id.
     * @return string answer.
     */
    private function getUserAnswer($ID) {
        $sql = "SELECT answer FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Update user quota.
     * @param int $ID the user id.
     * @param int $BYTES the new quota in bytes.
     * @return string result.
     */
    public function updateUserQuota($ID, $BYTES) {
        $sql = "UPDATE CS_Users SET quota=:quota WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID, ':quota' => $BYTES));
        } catch (PDOException $e) {
            return "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "Quota Updated.";
    }
    /**
     * Update the user email.
     * @param int $ID the user id.
     * @param string $EMAIL the new email.
     * @return string result.
     */
    public function updateUserEmail($ID, $EMAIL) {
        if (is_array($this->getUser($EMAIL))) {
            return 'Email already registered.';
        }
        $sql = "UPDATE CS_Users SET email=:email WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID, ':email' => $EMAIL));
        } catch (PDOException $e) {
            return "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "Email Updated.";
    }
    /**
     * Update user password.
     * @param int $ID the user id.
     * @param string $ANSWER the security answer.
     * @param string $PASSWORD the password.
     * @return string result.
     */
    public function updateUserPassword($ID, $ANSWER, $PASSWORD) {
        $SALT = $this->getUserSalt($ID);
        if ($this->verifyAnswer($ID, $ANSWER) == false) {
            return "Reset request denied.";
        }
        $PASSWORD = hash("sha1", $SALT . $PASSWORD);
        $sql = "UPDATE CS_Users SET password=:password WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID, ':password' => $PASSWORD));
        } catch (PDOException $e) {
            return "Error updating user password.";
        }
        return "Password Updated.";
    }
    /**
     * Checks if the user's answer to the security question is correct.
     * @param int $ID the user id.
     * @param string $ANSWER the answer.
     * @return boolean
     */
    public function verifyAnswer($ID, $ANSWER) {
        $SALT = $this->getUserSalt($ID);
        $ANSWER = hash("sha1", $SALT . $ANSWER);
        if ($ANSWER != $this->getUserAnswer($ID)) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Updates the user's first name.
     * @param int $ID the user id.
     * @param string $FIRSTNAME the new first name.
     * @return string result.
     */
    public function updateUserFirstName($ID, $FIRSTNAME) {
        $sql = "UPDATE CS_Users SET firstname=:firstname WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID, ':firstname' => $FIRSTNAME));
        } catch (PDOException $e) {
            return "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "First Name Updated.";
    }
    /**
     * Update the user's last name.
     * @param int $ID the user id.
     * @param string $LASTNAME the new last name.
     * @return string result.
     */
    public function updateUserLastName($ID, $LASTNAME) {
        $sql = "UPDATE CS_Users SET lastname=:lastname WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID, ':lastname' => $LASTNAME));
        } catch (PDOException $e) {
            return "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "Last Name Updated.";
    }
    /**
     * Update the user rank.
     * @param int $ID the user id.
     * @param string $RANK the new rank.
     * @return string result.
     */
    public function updateUserRank($ID, $RANK) {
        $sql = "UPDATE CS_Users SET rank=:rank WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID, ':rank' => $RANK));
        } catch (PDOException $e) {
            return "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "Rank Updated.";
    }
    /**
     * Activates the given user.
     * @param int $ID the user id.
     * @return string result.
     */
    public function activateUser($ID) {
        $sql = "UPDATE CS_Users SET active=1 WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "User Activated.";
    }
    /**
     * Deactivates the given user.
     * @param int $ID the user rid.
     * @return string result.
     */
    public function deactivateUser($ID) {
        $sql = "UPDATE CS_Users SET active=0 WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return "Error updating user.";
        }
        if ($rs->rowCount() == 0 && $this->userExists($ID) == false) {
            return 'User no longer exists.';
        }
        return "User Deactivated.";
    }
    /**
     * Checks if the user is active.
     * @param int $ID the user id.
     * @return boolean
     */
    public function checkActive($ID) {
        $sql = "SELECT active FROM CS_Users WHERE id = :id;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Resets the users table.
     * @return string result.
     */
    function resetUsers() {
        $query = file_get_contents("Scripts/resetUsers.sql");

        $stmt = $this->DBH->prepare($query);

        if ($stmt->execute()) {
            return "Reset Success.";
        } else {
            return "Reset Failed.";
        }
    }

}

?>
