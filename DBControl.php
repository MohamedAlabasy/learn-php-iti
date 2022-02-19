<?php

class DBControl
{
    private $connection, $databaseName, $host, $databaseUserName, $databaseUserPassword, $queryStatement, $tableName;

    public function __construct($databaseName = "student", $host = "localhost", $databaseUserName = "alabasy", $databaseUserPassword = "", $tableName = "student")
    {
        #=======================================================================================#
        #			                            Errors       		   	           	            #
        #=======================================================================================#
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $this->databaseName = $databaseName;
        $this->host = $host;
        $this->databaseUserName = $databaseUserName;
        $this->databaseUserPassword = $databaseUserPassword;
        $this->tableName = $tableName;
        try {
            $this->connection = new pdo("mysql:dbname=$this->databaseName;host=$this->host", $this->databaseUserName, $this->databaseUserPassword);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    #=======================================================================================#
    #			                        Delete from data 		   	           	            #
    #=======================================================================================#
    public function deleteFromDB($whereCondition)
    {
        $this->queryStatement = $this->connection->query("delete from $this->tableName where $whereCondition");
        header("Location:home.php?backToHome");
    }
    #=======================================================================================#
    #			                          Update user data 		   	           	            #
    #=======================================================================================#
    public function updateDB($whereCondition, $files, $columnsData)
    {
        if ($files["size"] > 0) {
            $this->savePicture($files);
            $this->queryStatement = $this->connection->prepare("UPDATE $this->tableName  SET userName = ? ,email = ? , pass = ?,roomNumber = ?,image= ? WHERE $whereCondition");
        } else {
            unset($columnsData[4]); //image index = 4;
            $this->queryStatement = $this->connection->prepare("UPDATE $this->tableName  SET userName = ? ,email = ? , pass = ?,roomNumber = ? WHERE $whereCondition");
        }
        $this->queryStatement->execute($columnsData);
        header("Location:home.php?backToHome");
    }
    #=======================================================================================#
    #			                          Save picture   		   	           	            #
    #=======================================================================================#
    private function savePicture($FILES)
    {
        #to save picture
        $errors = array();
        //to get file Data from $_FILES
        $file_name = $FILES['name'];
        $file_size = $FILES['size'];
        $file_tmp = $FILES['tmp_name'];
        $file_type = $FILES['type'];
        // get file extension
        $ext = explode('.', $FILES['name']);
        $file_ext = strtolower(end($ext));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }
        if ($file_size > 2097152) {
            $errors[] = 'File size must be excately 2 MB';
        }
        if (empty($errors) == true) {
            try {
                move_uploaded_file($file_tmp, "profilePicture/" . $file_name);
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            print_r($errors);
        }
    }
    #=======================================================================================#
    #			                          Show user data 		   	           	            #
    #=======================================================================================#
    public function showDB($whereCondition)
    {
        $this->queryStatement = $this->connection->query("select * from $this->tableName  where $whereCondition");
        $result = $this->queryStatement->fetch(PDO::FETCH_ASSOC);
        return json_encode($result);
    }
    #=======================================================================================#
    #			                          Add new user 		   	           	            #
    #=======================================================================================#
    public function addNewUser($files, $columnsData)
    {
        if ($files["size"] > 0) {
            $this->savePicture($files);
            $this->queryStatement = $this->connection->prepare("insert into $this->tableName (userName,email,pass,roomNumber,image) values (?,?,?,?,?)");
        } else {
            unset($columnsData[4]); //image index = 4;
            $this->queryStatement = $this->connection->prepare("insert into $this->tableName ($columnsName) values (?,?,?,?)");
        }
        $this->queryStatement->execute($columnsData);
    }
    #=======================================================================================#
    #			                         login check      		   	           	            #
    #=======================================================================================#
    public function loginCheck($userEmail, $userPassword)
    {
        $this->queryStatement = $this->connection->query("select * from $this->tableName where email = '$userEmail' and  pass = $userPassword");
        return $this->queryStatement->fetch(PDO::FETCH_ASSOC);
    }

    #=======================================================================================#
    #			                         close connection 		   	           	            #
    #=======================================================================================#
    private function __destruct()
    {
        $this->connection = null;
    }
}