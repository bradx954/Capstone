<?php
//I, Brad Baago, 000306223 certify that this material is my original work. No other person's work has been used without due acknowledgement.
/**
 * Model for handling files.
 */
class M_Files extends Model {

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
     * Gets the count of files in the system.
     * @return int count or -1 on error.
     */
    function getCount() {
        $sql = "SELECT COUNT(*) FROM CS_Files;";
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
     * Gets the count of files tied to the given user.
     * @param int $UserID the user ID.
     * @return int file count.
     */
    function getUserCount($UserID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT COUNT(*) FROM CS_Files WHERE userid = :userid;");
            $rs->execute(array(':userid' => $UserID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Creates a new file.
     * @param string $FileName name of the file to be created.
     * @param int $UserID userid to tie the file to.
     * @param int $ParentID default 0 directory id in which the new file resides.
     * @return int new file id.
     */
    function newFile($FileName, $UserID, $ParentID = 0) {
        if ($FileName == "") {
            return "File name blank.";
        }
        $sql = "SELECT COUNT(*) FROM CS_Files WHERE userid = :userid AND name = :name AND folderid = :folderid;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':userid' => $UserID, ':name' => $FileName, ':folderid' => $ParentID));
        } catch (PDOException $e) {
            return "Failed to create file.";
        }
        $array = $rs->fetchAll();
        if ($array[0][0] > 0) {
            return "File already exists.";
        }
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("insert into CS_Files(name,filesize,userid,folderid) values(:filename,:filesize,:userid,:parentid);");
            $rs->execute(array(':filename' => $FileName, ':filesize' => 0, ':userid' => $UserID, ':parentid' => $ParentID));
            file_put_contents(ROOT . '/Files/' . $this->DBH->lastInsertId(), "");
        } catch (PDOException $e) {
            return "Error creating file: " . $e . " please contact brad.baago@linux.com.";
        }
        return $this->DBH->lastInsertId();
    }
    /**
     * Gets file headers of the given user in the given directory.
     * @param int $UserID the user id.
     * @param int $FolderID default 0 the folder id to retrieve from.
     * @return array of file headers.
     */
    function getFiles($UserID, $FolderID = 0) {
        $sql = "SELECT * from CS_Files WHERE userid = :userid AND folderid = :folderid;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':userid' => $UserID, ':folderid' => $FolderID));
            foreach ($rs->fetchAll() as $row):
                $arr[] = $row;
            endforeach;
        } catch (PDOException $e) {
            return "Failed to retrieve files.";
        }
        if (is_array($arr)) {
            return $arr;
        } else {
            return array();
        }
    }
    /**
     * Gets the owner of the given file id.
     * @param int $ID file id.
     * @return int user id. -1 on error.
     */
    function getFileOwner($ID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT userid FROM CS_Files WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Gets the name of the given file id.
     * @param int $ID the file id.
     * @return string name of the file.
     */
    function getFileName($ID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT name FROM CS_Files WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Deletes the given file.
     * @param int $ID the file id.
     * @return string result.
     */
    function deleteFile($ID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("DELETE FROM CS_Files WHERE id = :id;");
            $rs->execute(array(':id' => $ID));
            unlink(ROOT . '/Files/' . $ID);
        } catch (PDOException $e) {
            return "Error deleting file: " . $e . " please contact brad.baago@linux.com.";
        }
        return 'File deleted.';
    }
    /**
     * Deletes the given files.
     * @param array $IDS The IDs of files to be deleted.
     * @return string result.
     */
    function deleteFiles($IDS) {
        foreach ($IDS as $ID) {
            try {
                $this->deleteFile($ID);
            } catch (PDOException $e) {
                return "Error deleting files.";
            }
        }
        return "Files " . implode(',', $IDS) . " deleted.";
    }
    /**
     * Gets the contents of the given file.
     * @param int $ID the file id.
     * @return string base64 encoded.
     */
    function getFileContents($ID) {
        return base64_encode(file_get_contents(ROOT . '/Files/' . $ID));
    }
    /**
     * Updates the given file with the given contents.
     * @param int $ID the file id.
     * @param string base64 $Contents
     * @return string result.
     */
    function updateFileContents($ID, $Contents) {
        $FileSize = file_put_contents(ROOT . '/Files/' . $ID, base64_decode($Contents));
        if ($FileSize == false) {
            return "File Update Failed.";
        }
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("UPDATE CS_Files SET filesize = :filesize WHERE id = :id;");
            $rs->execute(array(':id' => $ID, ':filesize' => $FileSize));
        } catch (PDOException $e) {
            return "Error deleting file: " . $e . " please contact brad.baago@linux.com.";
        }
        return 'File Updated.';
    }
    /**
     * Gets the used space of the given user.
     * @param int $UserID the user id.
     * @return int space in bytes.
     */
    function getUserUsedSpace($UserID) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT SUM(filesize) FROM CS_Files WHERE userid = :userid;");
            $rs->execute(array(':userid' => $UserID));
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Gets the total system used space.
     * @return int space in bytes.
     */
    function getUsedSpace() {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT SUM(filesize) FROM CS_Files;");
            $rs->execute();
        } catch (PDOException $e) {
            //$this->DBO->showErrorPage($sql,$e );
            return -1;
        }
        $array = $rs->fetchAll();
        return $array[0][0];
    }
    /**
     * Deletes all the files in the given directories. Be careful using 0.
     * @param array $IDS ids of directories to purge.
     * @return string result.
     */
    function deleteDirectoryFiles($IDS) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("SELECT id FROM CS_Files WHERE FIND_IN_SET(folderid, :ids);");
            $rs->execute(array(':ids' => implode(',', $IDS)));
            $DeleteIDS = array();
            foreach ($rs->fetchAll() as $row):
                array_push($DeleteIDS, $row[0]);
            endforeach;
        } catch (PDOException $e) {
            return "Error deleteing sub folders: " . $e . " please contact brad.baago@linux.com.";
        }
        return $this->deleteFiles($DeleteIDS);
    }
    /**
     * Updates the given file with the given name.
     * @param int $ID file id.
     * @param string $Contents new name.
     * @return string result.
     */
    function updateFileName($ID, $Contents) {
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("UPDATE CS_Files SET name = :name WHERE id = :id;");
            $rs->execute(array(':id' => $ID, ':name' => $Contents));
        } catch (PDOException $e) {
            return "Error renaming file: " . $e . " please contact brad.baago@linux.com.";
        }
        return "File Renamed.";
    }
    /**
     * Updates the directory location of the given file.
     * @param int $ID the file id.
     * @param int $ParentID the destination directory.
     * @return string result.
     */
    function updateParentID($ID, $ParentID) {
        $sql = "SELECT COUNT(*) FROM CS_Files WHERE name = :name AND folderid = :folderid;";
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare($sql);
            $rs->execute(array(':name' => $this->getFileName($ID), ':folderid' => $ParentID));
        } catch (PDOException $e) {
            return "Failed to move file.";
        }
        $array = $rs->fetchAll();
        if ($array[0][0] > 0) {
            return "File already exists.";
        }
        try {
            $rs = NULL;
            $rs = $this->DBH->prepare("UPDATE CS_Files SET folderid = :parent WHERE id = :id;");
            $rs->execute(array(':id' => $ID, ':parent' => $ParentID));
        } catch (PDOException $e) {
            return "Error updating file: " . $e . " please contact brad.baago@linux.com.";
        }
        return "File parent updated.";
    }
    /**
     * Copies the given file to the given directory.
     * @param int $ID the file id.
     * @param int $UserID the userid for the new file.
     * @param int $Destination the directory for the new file.
     * @return string result.
     */
    function copyFile($ID, $UserID, $Destination) {
        $Filename = $this->getFileName($ID);
        if ($Filename == -1) {
            return "Thats not a valid file.";
        }
        $Filecontents = $this->getFileContents($ID);
        $newFileID = $this->newFile($Filename, $UserID, $Destination);
        if ($newFileID < 1) {
            return $newFileID;
        }
        $this->updateFileContents($newFileID, $Filecontents);
        return "File Copy completed.";
    }

}

?>
