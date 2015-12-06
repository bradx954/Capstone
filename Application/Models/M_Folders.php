<?php

//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
/**
 * Model for handling folders.
 */
class M_Folders extends Model {

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
     * Gets the count of all folders in the system.
     * @return int count.
     */
    function getCount() {
        $sql = "SELECT COUNT(*) FROM CS_Folders";
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
     * Creates a new foler.
     * @param string $FolderName The name of the folder.
     * @param int $UserID The user to tie the folder to.
     * @param int $ParentID Default 0 The directory to place the folder.
     * @return string result.
     */
    function newFolder($FolderName, $UserID, $ParentID = 0) {
        if ($FolderName == "") {
            return "Folder name blank.";
        }
        $sql = "SELECT COUNT(*) FROM CS_Folders WHERE userid = :userid AND name = :name AND folderid = :folderid;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':userid' => $UserID, ':name' => $FolderName, ':folderid' => $ParentID));
        } catch (PDOException $e) {
            return "Failed to create folder.";
        }
        $array = $rs->fetchAll();
        if ($array[0][0] > 0) {
            return "Folder already exists.";
        }
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("insert into CS_Folders(name,userid,folderid) values(:foldername,:userid,:parentid);");
            $rs->execute(array(':foldername' => $FolderName, ':userid' => $UserID, ':parentid' => $ParentID));
        } catch (PDOException $e) {
            return "Error creating folder: " . $e . " please contact brad.baago@linux.com.";
        }
        return $this->DBH->lastInsertId();
    }
    /**
     * Gets the folders for the given user and directory.
     * @param int $UserID The user id.
     * @param int $FolderID The directory id.
     * @return array folders or string error.
     */
    function getFolders($UserID, $FolderID = 0) {
        $sql = "SELECT * from CS_Folders WHERE userid = :userid AND folderid = :folderid;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':userid' => $UserID, ':folderid' => $FolderID));
            foreach ($rs->fetchAll() as $row):
                $arr[] = $row;
            endforeach;
        } catch (PDOException $e) {
            return "Failed to retrieve folders.";
        }
        if (is_array($arr)) {
            return $arr;
        } else {
            return array();
        }
    }
    /**
     * Gets the owner of the given folder.
     * @param int $ID the folder id.
     * @return int user id.
     */
    function getFolderOwner($ID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT userid FROM CS_Folders WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Deletes specified folder and subfolders.
     * @param int $ID folder ID to delete.
     * @return array deleted folder ids.
     */
    function deleteDirectory($ID) {
        $IDS = array($ID);
        $newIDS = $IDS;
        while (count($newIDS) > 0) {
            try {
                $rs = NULL;
                $rs = $this->DBH->prepare("SELECT ID FROM CS_Folders WHERE FIND_IN_SET(folderid, :ids);");
                $rs->execute(array(':ids' => implode(',', $newIDS)));
                $newIDS = array();
                foreach ($rs->fetchAll() as $row):
                    array_push($newIDS, $row[0]);
                endforeach;
                $IDS = array_merge($IDS, $newIDS);
            } catch (PDOException $e) {
                return "Error selecting sub folders: " . $e . " please contact brad.baago@linux.com.";
            }
        }
        $this->deleteFolders($IDS);
        return $IDS;
    }
    /**
     * Deletes the given folder.
     * @param int $ID The folder id.
     * @return string result.
     */
    function deleteFolder($ID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("DELETE FROM CS_Folders WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            return "Error deleting folder: " . $e . " please contact brad.baago@linux.com.";
        }
        return "Folder deleted.";
    }
    /**
     * Deletes the given folders.
     * @param array $IDS of folders to delete.
     * @return string result.
     */
    function deleteFolders($IDS) {
        foreach ($IDS as $ID) {
            try {
                $this->deleteFolder($ID);
            } catch (PDOException $e) {
                return "Error deleting folders.";
            }
        }
        return "Folders " . implode(',', $IDS) . " deleted.";
    }
    /**
     * Gets the percieved path of the given folder.
     * @param int $ID the folder id.
     * @return string directory path.
     */
    function getFolderPath($ID = 0) {
        if ($ID == 0) {
            return $PATH;
        }
        while ($ID != 0) {
            try {
                $rs = NULL;
                $rs = $this->DBH->prepare("SELECT name,folderid FROM CS_Folders WHERE id = :id;");
                $rs->execute(array(':id' => $ID));
            } catch (PDOException $e) {
                //$this->DBO->showErrorPage($sql,$e );
                return "Error getting file path " . $e . " please contact brad.baago@linux.com.";
            }
            $array = $rs->fetchAll();
            $NAME = $array[0][0];
            $PATH = $NAME . "/" . $PATH;
            $ID = $array[0][1];
        }
        return "/" . $PATH;
    }
    /**
     * Gets the parent folder of the given folder.
     * @param int $ID the folder id.
     * @return int the parent id. String on error.
     */
    function getFolderParent($ID) {
        if ($ID == 0) {
            return 0;
        }
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT folderid FROM CS_Folders WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
            $array = $rs->fetchAll();
            return $array[0][0];
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return "Error getting file path " . $e . " please contact brad.baago@linux.com.";
        }
    }
    /**
     * Gets the folder count for the user.
     * @param int $UserID the user id.
     * @return int count.
     */
    function getUserCount($UserID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT COUNT(*) FROM CS_Folders WHERE userid = :userid;");
            $rs->execute(array(':userid' => $UserID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Updates the folder name.
     * @param int $ID the folder id.
     * @param string $Contents the new name.
     * @return string result.
     */
    function updateFolderName($ID, $Contents) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("UPDATE CS_Folders SET name = :name WHERE id = :id;");
            $rs->execute(array(':id' => $ID, ':name' => $Contents));
        } catch (PDOException $e) {
            return "Error renaming folder: " . $e . " please contact brad.baago@linux.com.";
        }
        return "Folder Renamed.";
    }
    /**
     * Gets the name of the given folder.
     * @param int $ID the folder id.
     * @return string name.
     */
    function getFolderName($ID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT name FROM CS_Folders WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Updates the directory location of the folder.
     * @param int $ID the folder id.
     * @param int $ParentID the new directory id.
     * @return string result.
     */
    function updateParentID($ID, $ParentID) {
        $sql = "SELECT COUNT(*) FROM CS_Folders WHERE name = :name AND folderid = :folderid;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':name' => $this->getFolderName($ID), ':folderid' => $ParentID));
        } catch (PDOException $e) {
            return "Failed to move folder.";
        }
        $array = $rs->fetchAll();
        if ($array[0][0] > 0) {
            return "Folder already exists.";
        }
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("UPDATE CS_Folders SET folderid = :parent WHERE id = :id;");
            $rs->execute(array(':id' => $ID, ':parent' => $ParentID));
        } catch (PDOException $e) {
            return "Error updating folder: " . $e . " please contact brad.baago@linux.com.";
        }
        return "Folder parent updated.";
    }

}

?>
