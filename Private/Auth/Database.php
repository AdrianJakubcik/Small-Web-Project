<?php
date_default_timezone_set("Europe/Bratislava");
require("../../Private/Cryptography.php");
require("../../Confg/config.php");
$host = constant("host");
$username = constant("username");
$password = constant("password");
$database = constant("database");
$dbconn = new mysqli($host,$username,$password,$database);
$db = new Database_Functions($dbconn);
$pw_reset_util = new ResetPasswordUtilities($dbconn,$db);
if($dbconn->connect_error){
    die("Connection to Database Failed!".$dbconn->connect_error);
}

function SetupDB()
{
    // CREATE TABLE IF NOT EXISTS `password_resets` ( `ID` INT NOT NULL AUTO_INCREMENT , `USER_ID` INT NOT NULL , `USER_EMAIL` TEXT NOT NULL , `TOKEN` VARCHAR(250) NOT NULL , `EXPIRATION` DATETIME NOT NULL , PRIMARY KEY (`ID`), UNIQUE `USER_ID` (`USER_ID`)) ENGINE = InnoDB;
    //CREATE TABLE IF NOT EXISTS `Clients` ( `ID` INT NOT NULL AUTO_INCREMENT , `USERNAME` VARCHAR(252) NOT NULL , `PASSWORD` VARCHAR(280) NOT NULL , `EMAIL` VARCHAR(250) NOT NULL , `REG_DATE` DATE NOT NULL , `RANK` INT NOT NULL DEFAULT '1' , `ISADMIN` BOOLEAN NULL DEFAULT FALSE , PRIMARY KEY (`ID`), UNIQUE `EMAIL` (`EMAIL`)) ENGINE = InnoDB;

}


function Authenticate_Client($username, $password){
    try {
        global $db;
        $key = $db->getSingleRecord('SELECT * FROM Clients WHERE USERNAME = ?','s',$username)['PASSWORD'];
        if(password_verify($password,$key)){
            return true;
        }else {
            return false;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}

function ProccessNewUser($user, $password, $email) {
    $user = TestInput($user);
    $date = date("Y-m-d");
    $password = password_hash($password, PASSWORD_DEFAULT);
    if(AddNewUserToDB($user,$date,$password,$email)){
        return true;
    }else{
        return false;
    }
}

function AddNewUserToDB($user,$date,$password,$email){
    global $dbconn;
    $stmt = $dbconn->prepare('INSERT INTO clients (USERNAME,PASSWORD,EMAIL,REG_DATE) VALUES (?,?,?,?)');
    $stmt->bind_param('ssss',$user,$password,$email,$date);
    if($stmt->execute()){
        $stmt->close();
        return true;
    } else{
        die("Registration Failed Due To Error " . $stmt->error);
        return false;
    }
}

 function RegisterNewUser($user,$password,$email) {
     $res = BeforeAddingToDBChecks($user,$email);
    if($res == "true")
    {
        if(ProccessNewUser($user,$password,$email)){
            return true;
        }else{
            return false;    
        }
    } else {
        die("Registration failed: " . $res);
        return false;
    }
 }

function UserExists($user) {
    global $dbconn;
    $stmt = $dbconn->prepare('SELECT * FROM clients WHERE USERNAME = ?');
    $stmt->bind_param('s',$user);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    if($row == null)
    {
        return false;
    }
    else {
        return true;
    }
}

function EmailAlreadyInUse($email) {
    global $dbconn;
    $stmt = $dbconn->prepare('SELECT * FROM clients WHERE EMAIL = ?');
    $stmt->bind_param('s',$email);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    if($row == null)
    {
        return false;
    }
    else {
        return true;
    }
}

function BeforeAddingToDBChecks($user,$email) {
    if(UserExists($user))
    {
        return "Username has been taken by someone else!";
    }else if (EmailAlreadyInUse($email)) {
        return "Email is already being used by someone else!";
    }
    else {
        return "true";
    }
}

function TestInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function CheckConnection(mysqli $conn = null){
    global $dbconn;
    if($conn == null)
        $conn = $dbconn;
    if($conn->connect_error)
    {
        return false;
    }else {
        return true;
    }
}

/**
 * Summary of ResetPasswordUtilities
 * @param string $db_table
 * @throws 
 */
class ResetPasswordUtilities{

    private $table;
    public $dbconn;
    public $db;

    public function __construct(mysqli $db_conn, Database_Functions $db ,$db_table = "password_resets")
    {   
        $this->db = $db;
        if(CheckConnection($db_conn)){
            $this->dbconn = $db_conn;
        }
        if($db->exists_table($db_table))
        {
            $this->table = $db_table;
        }
    }

    function ResetPassword($email, $new_password){
        if(CheckConnection()){
            $usr_id = $this->db->getUserIDByEmail($email);
            if($usr_id != null || !empty($usr_id) || $usr_id <= 0){
                //Reset Coding done here
            }
        } else{
            return false;
        }
    }
    
    function ResetPasswordExistsCheck($id){
        $id = 0;
        $email = $this->db->getEmailByID($id);
        $stmt = $this->dbconn->prepare('SELECT ID FROM `password_resets` WHERE `USER_ID` = ? AND `USER_EMAIL` = ?');
        $stmt->bind_param('is',$id,$email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        if(($result = $stmt->fetch()) == true){
            $stmt->close();
            return (int)$id;
        }else {
            return false;
        }
    }
    
    function ResetPasswordExpirationCheck($ID){
        $expiration = "";
        if(ResetPasswordExistsCheck($ID))
        {
            $RES_ID = (int)ResetPasswordExistsCheck($ID);
        }else{
            return false;
        }
        global $dbconn;
        $stmt = $dbconn->prepare('SELECT EXPIRATION FROM `password_resets` WHERE ID = ?');
        $stmt->bind_param('i',$RES_ID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($expiration);
        if(($result = $stmt->fetch()) == true){
            $stmt->close();
            return $expiration;
        }else {
            $stmt->close();
            return false;
        }
    }
    
    function ResetToken($email){
        if(CheckConnection()){
            global $db;
            $userid = $db->getUserIDByEmail($email);
            if($userid > 0)
            {
                //$token = strtoupper(bin2hex(random_bytes(26))); //Multiple Ways Of Generating Token Uncomment the one you would like to use.
                //$token = TOKEN_GENERATE_NEW();

                $reset_data = Reset_Token_Add_DB($userid,$token);
                if(!CheckForExistingToken($userid,$email)){
                if($reset_data != false){
                    return $reset_data;
                }else{
                    return false;
                }
            }else{
                $expFormat = mktime(
                    date("H"), date("i"), date("s"), date("m"), date("d")+3, date("Y")
                    );
                $new_expDate = date("Y-m-d H:i:s",$expFormat);
                $res = modifyExisitngToken($email,$userid,$token,$new_expDate);
                if($res != false){
                    return $res;
                }else{
                    return false;
                }
            }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function Reset_Token_Add_DB($userid,$token){
        global $db;
        global $dbconn;
        $email = $db->getEmailByID($userid);
        if(empty($email) || $email == null){
            return false;
        }
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m"), date("d")+3, date("Y")
            );
        $expDate = date("Y-m-d H:i:s",$expFormat);
        $stmt = $dbconn->prepare('INSERT INTO password_resets (`USER_ID`,`USER_EMAIL`,TOKEN,EXPIRATION) VALUES (?,?,?,?)');
        $stmt->bind_param('isss',$userid,$email,$token,$expDate);
        $suc = $stmt->execute();
        $stmt->close();
        if($suc){
            $Token_Data['Token'] = $token;
            $Token_Data['Expiration'] = $expDate; 
            return $Token_Data;
        }else {
            return false;
        }
    }
    
    function modifyExisitngToken($email,$userid, $new_token, $new_expdate){
        global $dbconn;
        $stmt = $dbconn->prepare('UPDATE password_resets SET TOKEN = ?, EXPIRATION = ? WHERE USER_EMAIL = ? AND `USER_ID` = ?');
        $stmt->bind_param('sssi',$new_token,$new_expdate,$email,$userid);
        $res = $stmt->execute();
        $stmt->close();
        if($res){
            $data['Token'] = $new_token;
            $data['Expiration'] = $new_expdate;
            return $data;
        }else{
            return false;
        }
    }
    
    function checkForExistingToken($userid,$email){
        global $dbconn;
        $stmt = $dbconn->prepare('SELECT * FROM password_resets WHERE `USER_ID` = ? AND `USER_EMAIL` = ?');
        $stmt->bind_param('is',$userid,$email);
        $stmt->execute();
        $stmt->store_result();
        $rows = $stmt->num_rows;
        $stmt->close();
        if($rows == 0){
            return false;
        } else {
            return true;
        }
    }
}

/** 
 * Database Functions serves as a static library for all the database neccessary functions.
 * @param mysqli $db_conn
 * @param string $db_table
 * @throws Exception
 * @todo Review!
 */
class Database_Functions{

    public $table;
    private $dbconn;

    public function __construct(mysqli $db_conn, $db_table = "clients")
    {
        try {
            if (CheckConnection()) {
                $this->dbconn = $db_conn;
                if (exists_table($db_table) == true) {
                    $this->table = $db_table;
                } else
                    throw new Exception("Table " . $db_table . " doesn't exist!", 404);
            } else {
                throw new Exception("A Connection Error Occured, Please Proceed By Reloading Your Web Browser.", 400);
            }
        } catch (Exception $error) {
            header("HTTP/1.0 404");
            die($error->getMessage());
        }
    }

    function exists_table($table)
    {
        try {
            if (CheckConnection()) {
                $sql = $this->dbconn->prepare('SELECT 1 FROM ' . $table . ' LIMIT 1');
                $sql->execute();
                if ($sql->get_result() !== FALSE) {
                    return true;
                } else
                    return $sql->get_result();
            }
        } catch (Exception $error) {
            header("HTTP/1.1 404 Not Found");
        }
    }

    function getIdByName($name){
        global $dbconn;
        if(CheckConnection())
        {
            $stmt = $dbconn->prepare("SELECT ID FROM ".$this->table." WHERE USERNAME = ?");
            $stmt->bind_param('s',$name);
            $stmt->execute();
            $result = $stmt->get_result();
            $ID = $result->fetch_row();
            $stmt->close();
            if($ID != null){
                return (int)$ID[0];
            }else {
                return null;
            }
            
        }else {
            return "Connection_Error";
        }
    }
    
    function getSingleRecord($sql, $types = null, $params = []){
        global $dbconn;
        if(CheckConnection()){
            $stmt = $dbconn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $User = $result->fetch_assoc();
            $stmt->close();
            return $User;
        }else{
            return false;
        }
    }
    
    function getMultipleRecords($sql, $types = null, $params = []){
        global $dbconn;
        $stmt = $dbconn->prepare($sql);
        if (!empty($params) && !empty($params)) {
          $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $user;
    }
    
    function modifyRecord($sql, $types, $params) {
        global $dbconn;
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    function getNameByID($ID){
        global $dbconn;
        if(CheckConnection())
        {
            $stmt = $dbconn->prepare("SELECT `NAME` FROM ".$this->table." WHERE ID = ?");
            $stmt->bind_param('i',$ID);
            $stmt->execute();
            $result = $stmt->get_result();
            $username = $result->fetch_row();
            $stmt->close();
            if($username != null){
                return (string)$username[0];
            }else {
                return "Not Found";
            }
            
        }else {
            return "Connection_Error";
        }
    }
    
    function getEmailByID($ID){
        global $dbconn;
        if(CheckConnection())
        {
            $stmt = $dbconn->prepare('SELECT `EMAIL` FROM '.$this->table.' WHERE ID = ?');
            $stmt->bind_param('i',$ID);
            $stmt->execute();
            $result = $stmt->get_result();
            $username = $result->fetch_row();
            $stmt->close();
            if($username != null){
                return (string)$username[0];
            }else {
                return "Not Found";
            }
            
        }else {
            return "Connection_Error";
        }
    }
    
    function getPassowrdByID($id){
        global $dbconn;
        if(CheckConnection()){
            $stmt = $dbconn->prepare('SELECT `PASSWORD` FROM '.$this->table.' WHERE ID = ?');
            $stmt->bind_param('i',$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $pass = $result->fetch_row();
            $stmt->close();
            if($pass != null){   
                return $pass[0];
            }else{
                return "Not Found";
            }
        }else{
            return ("Error");
        }
    }
    
    function getAllDataByID($id) {
        global $dbconn;
        if(CheckConnection())
        {
            $stmt = $dbconn->prepare('SELECT * FROM '.$this->table.' WHERE ID = ?');
            $stmt->bind_param('i',$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            if($row != null){
                return $row;
            }else {
                return "Not Found";
            }
            
        }else {
            return "Connection_Error";
        }
    }
    
    function getUserIDByEmail($email){
        global $dbconn;
        $id = 0;
        $stmt = $dbconn->prepare('SELECT `ID` FROM '.$this->table.' WHERE `EMAIL` = ?');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id);
        if(($result = $stmt->fetch()) == true)
        {
            $stmt->close();
            return (int)$id;
        }else{
            $stmt->close();
            return 0;
        }
    }
}

?>