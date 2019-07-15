<?php
date_default_timezone_set("Europe/Bratislava");
require("../../Private/Cryptography.php");
require("../../Confg/config.php");
$host = constant("host");
$username = constant("username");
$password = constant("password");
$database = constant("database");
$dbconn = new mysqli($host,$username,$password,$database);
if($dbconn->connect_error){
    die("Connection to Database Failed!".$dbconn->connect_error);
}



function Authenticate_Client($username, $passsword){
    if(GetIdByName($username) != null || GetIdByName($username) != "Connection_Error")
    {
        $ID = GetIdByName($username);
    }
    $salt = GetSaltByID($ID);
    $enc_pass = AdvancedEncryptionWithSalt($passsword,$salt);

    global $dbconn;
    $stmt = $dbconn->prepare('SELECT * FROM clients WHERE USERNAME = ? AND `PASSWORD` = ?');
    $stmt->bind_param('ss',$username,$enc_pass);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    if($num_rows == 1 ){
        return true;
    }else{
        return false;
    }

}

function ProccessNewUser($user, $password, $email) {
    $user = TestInput($user);
    $date = date("Y-m-d");
    $salt = GenerateNewSalt();
    $password = AdvancedEncryptionWithSalt($password,$salt);
    if(AddNewUserToDB($user,$date,$password,$salt,$email)){
        return true;
    }else{
        return false;
    }
}

function AddNewUserToDB($user,$date,$password,$salt,$email){
    global $dbconn;
    $stmt = $dbconn->prepare('INSERT INTO clients (USERNAME,PASSWORD,KEY_SALT,EMAIL,REG_DATE) VALUES (?,?,?,?,?)');
    $stmt->bind_param('sssss',$user,$password,$salt,$email,$date);
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
        return "Username has been taken already by someone else!";
    }else if (EmailAlreadyInUse($email)) {
        return "Email is being used already by someone else!";
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

function GetIdByName($name){
    global $dbconn;
    if(CheckConnection())
    {
        $stmt = $dbconn->prepare('SELECT ID FROM clients WHERE USERNAME = ?');
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

function GetSaltByID($ID){
    global $dbconn;
    if(CheckConnection())
    {
        $stmt = $dbconn->prepare('SELECT `KEY_SALT` FROM clients WHERE ID = ?');
        $stmt->bind_param('i',$ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $salt = $result->fetch_row();
        $stmt->close();
        if($salt != null){
            return (string)$salt[0];
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

function GetNameByID($ID){
    global $dbconn;
    if(CheckConnection())
    {
        $stmt = $dbconn->prepare('SELECT `NAME` FROM clients WHERE ID = ?');
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

function GetEmailByID($ID){
    global $dbconn;
    if(CheckConnection())
    {
        $stmt = $dbconn->prepare('SELECT `EMAIL` FROM clients WHERE ID = ?');
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

function GetPassowrdByID($id){
    global $dbconn;
    if(CheckConnection()){
        $stmt = $dbconn->prepare('SELECT `PASSWORD` FROM clients WHERE ID = ?');
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

function GetAllDataByID($id) {
    global $dbconn;
    if(CheckConnection())
    {
        $stmt = $dbconn->prepare('SELECT * FROM clients WHERE ID = ?');
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

function CheckConnection(){
    global $dbconn;
    if($dbconn->connect_error)
    {
        return false;
    }else {
        return true;
    }
}

function GetUserIDByEmail($email){
    global $dbconn;
    $id = 0;
    $stmt = $dbconn->prepare('SELECT `ID` FROM clients WHERE `EMAIL` = ?');
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
        return false;
    }
}

function ResetPassword($email, $new_password){
    if(CheckConnection()){
        if(GetUserIDByEmail($email))
        {
            $userid = GetUserIDByEmail($email);
        }
    } else{
        return false;
    }
}

function ResetPasswordExistsCheck($id){
    global $dbconn;
    $id = 0;
    $email = GetEmailByID($id);
    $stmt = $dbconn->prepare('SELECT ID FROM `password_resets` WHERE `USER_ID` = ? AND `USER_EMAIL` = ?');
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
        echo($expiration);
    }else {
        $stmt->close();
        return false;
    }
}

function ResetToken($email){
    if(CheckConnection()){
        if(GetUserIDByEmail($email))
        {
            
            $userid = GetUserIDByEmail($email);
            if(!CheckForExistingToken($userid,$email)){
            //$token = strtoupper(bin2hex(random_bytes(26))); //Multiple Ways Of Generating Token (My Own Is Safer)
            $token = TOKEN_GENERATE_NEW();
            if(Reset_Token_Add_DB($userid,$token)){
                return true;
            }else{
                return false;
            }
        }else{
            return 404;
        }
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function Reset_Token_Add_DB($userid,$token){
    if(GetEmailByID($userid))
    {
        $email = GetEmailByID($userid);
    }else {
        return false;
    }
    global $dbconn;
    $expFormat = mktime(
        date("H"), date("i"), date("s"), date("m"), date("d")+3, date("Y")
        );
    $expDate = date("Y-m-d H:i:s",$expFormat);
    $stmt = $dbconn->prepare('INSERT INTO password_resets (`USER_ID`,`USER_EMAIL`,TOKEN,EXPIRATION) VALUES (?,?,?,?)');
    $stmt->bind_param('isss',$userid,$email,$token,$expDate);
    $suc = $stmt->execute();
    $stmt->close();
    if($suc){
        return true;
    }else {
        return false;
    }
}

function CheckForExistingToken($userid,$email){
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

?>