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



function Authenticate_Client($username, $passsword, $conn){
    if(GetIdByName($username,$conn) != null || GetIdByName($username,$conn) != "Connection_Error")
    {
        $ID = GetIdByName($username,$conn);
    }
    $salt = GetSaltByID($ID,$conn);
    $enc_pass = AdvancedEncryptionWithSalt($passsword,$salt);

    $stmt = $conn->prepare('SELECT * FROM clients WHERE USERNAME = ? AND `PASSWORD` = ?');
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

function ProccessNewUser($user, $password, $email, $dbconn) {
    $user = TestInput($user);
    $date = date("Y-m-d");
    $salt = GenerateNewSalt();
    $password = AdvancedEncryptionWithSalt($password,$salt);
    if(AddNewUserToDB($user,$date,$password,$salt,$email,$dbconn)){
        return true;
    }else{
        return false;
    }
}

function AddNewUserToDB($user,$date,$password,$salt,$email,$dbconn){
    $stmt = $dbconn->prepare('INSERT INTO clients (USERNAME,PASSWORD,KEY_SALT,EMAIL,REG_DATE) VALUES (?,?,?,?,?)');
    $stmt->bind_param('sssss',$user,$password,$salt,$email,$date);
    if($stmt->execute()){
        return true;
    } else{
        die("Registration Failed Due To Error " . $stmt->execute());
        return false;
    }
}

 function RegisterNewUser($user,$password,$email, $conn) {
     $res = BeforeAddingToDBChecks($user,$email,$conn);
    if($res == "true")
    {
        if(ProccessNewUser($user,$password,$email,$conn)){
            return true;
        }else{
            return false;    
        }
    } else {
        die("Registration failed: " . $res);
        return false;
    }
 }

function UserExists($user, $conn) {
    $stmt = $conn->prepare('SELECT * FROM clients WHERE USERNAME = ?');
    $stmt->bind_param('s',$user);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row == null)
    {
        return false;
    }
    else {
        return true;
    }
}

function EmailAlreadyInUse($email, $conn) {
    $stmt = $conn->prepare('SELECT * FROM clients WHERE EMAIL = ?');
    $stmt->bind_param('s',$email);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row == null)
    {
        return false;
    }
    else {
        return true;
    }
}

function BeforeAddingToDBChecks($user,$email,$connection) {
    if(UserExists($user,$connection))
    {
        return "Username has been taken already by someone else!";
    }else if (EmailAlreadyInUse($email,$connection)) {
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

function GetIdByName($name, $conn){
    if(CheckConnection($conn))
    {
        $stmt = $conn->prepare('SELECT ID FROM clients WHERE USERNAME = ?');
        $stmt->bind_param('s',$name);
        $stmt->execute();
        $result = $stmt->get_result();
        $ID = $result->fetch_row();
        if($ID != null){
            return (int)$ID[0];
        }else {
            return null;
        }
        
    }else {
        return "Connection_Error";
    }
}

function GetSaltByID($ID, $conn){
    if(CheckConnection($conn))
    {
        $stmt = $conn->prepare('SELECT `KEY_SALT` FROM clients WHERE ID = ?');
        $stmt->bind_param('i',$ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $salt = $result->fetch_row();
        if($salt != null){
            return (string)$salt[0];
        }else {
            return null;
        }
        
    }else {
        return "Connection_Error";
    }
}

function GetNameByID($ID, $conn){
    if(CheckConnection($conn))
    {
        $stmt = $conn->prepare('SELECT `NAME` FROM clients WHERE ID = ?');
        $stmt->bind_param('i',$ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $username = $result->fetch_row();
        if($username != null){
            return (string)$username[0];
        }else {
            return "Not Found";
        }
        
    }else {
        return "Connection_Error";
    }
}

function GetEmailByID($ID, $conn){
    if(CheckConnection($conn))
    {
        $stmt = $conn->prepare('SELECT `EMAIL` FROM clients WHERE ID = ?');
        $stmt->bind_param('i',$ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $username = $result->fetch_row();
        if($username != null){
            return (string)$username[0];
        }else {
            return "Not Found";
        }
        
    }else {
        return "Connection_Error";
    }
}

function GetPassowrdByID($id,$conn){
    if(CheckConnection($conn)){
        $stmt = $conn->prepare('SELECT `PASSWORD` FROM clients WHERE ID = ?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pass = $result->fetch_row();
        if($pass != null){   
            return $pass[0];
        }else{
            return "Not Found";
        }
    }else{
        return ("Error");
    }
}

function GetAllDataByID($id, $conn) {
    if(CheckConnection($conn))
    {
        $stmt = $conn->prepare('SELECT * FROM clients WHERE ID = ?');
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row != null){
            $Data['ID'] = $id;
            $Data['Username'] = $row['USERNAME'];
            $Data['Password'] = $row['PASSWORD'];
            $Data['Email'] = $row['EMAIL'];
            $Data['Registration'] = $row['REG_DATE'];
            $Data['Rank'] = $row['RANK'];
            $Data['Admin'] = $row['ISADMIN'];
            return $Data;
        }else {
            return "Not Found";
        }
        
    }else {
        return "Connection_Error";
    }
}

function CheckConnection($conn){
    if($conn->connect_error)
    {
        return false;
    }else {
        return true;
    }
}

function GetUserIDByEmail($email,$conn){
    $id = 0;
    $stmt = $conn->prepare('SELECT `ID` FROM clients WHERE `EMAIL` = ?');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id);
    if(($result = $stmt->fetch()) == true)
    {
        $stmt->close();
        return (int)$id;
    }else{
        return false;
    }
}

function ResetPassword($email, $conn, $new_password){
    if(CheckConnection($conn)){
        if(getUserIDFromResetDB($email,$conn))
        {
            $userid = getUserIDFromResetDB($email,$conn);
        }
    } else{
        return false;
    }
}

function ResetPasswordExistsCheck($id,$conn){
    $id = 0;
    $email = GetEmailByID($id,$conn);
    $stmt = $conn->prepare('SELECT ID FROM `password_resets` WHERE `USER_ID` = ? AND `USER_EMAIL` = ?');
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

function ResetPasswordExpirationCheck($ID, $conn){
    $expiration = "";
    if(ResetPasswordExistsCheck($ID,$conn))
    {
        $RES_ID = (int)ResetPasswordExistsCheck($ID,$conn);
    }else{
        return false;
    }
    $stmt = $conn->prepare('SELECT EXPIRATION FROM `password_resets` WHERE ID = ?');
    $stmt->bind_param('i',$RES_ID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($expiration);
    if(($result = $stmt->fetch()) == true){
        $stmt->close();
        echo($expiration);
    }else {
        return false;
    }
}

function ResetToken($email, $conn){
    if(CheckConnection($conn)){
        if(GetUserIDByEmail($email,$conn))
        {
            
            $userid = GetUserIDByEmail($email,$conn);
            if(!CheckForExistingToken($userid,$email,$conn)){
            //$token = strtoupper(bin2hex(random_bytes(26))); //Multiple Ways Of Generating Token (My Own Is Safer)
            $token = TOKEN_GENERATE_NEW();
            if(Reset_Token_Add_DB($userid,$token,$conn)){
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

function Reset_Token_Add_DB($userid,$token,$conn){
    if(GetEmailByID($userid,$conn))
    {
        $email = GetEmailByID($userid,$conn);
    }else {
        return false;
    }
    $expFormat = mktime(
        date("H"), date("i"), date("s"), date("m"), date("d")+3, date("Y")
        );
    $expDate = date("Y-m-d H:i:s",$expFormat);
    $stmt = $conn->prepare('INSERT INTO password_resets (`USER_ID`,`USER_EMAIL`,TOKEN,EXPIRATION) VALUES (?,?,?,?)');
    $stmt->bind_param('isss',$userid,$email,$token,$expDate);
    $suc = $stmt->execute();
    if($suc){
        return true;
    }else {
        return false;
    }
}

function CheckForExistingToken($userid,$email,$conn){
    $stmt = $conn->prepare('SELECT * FROM password_resets WHERE `USER_ID` = ? AND `USER_EMAIL` = ?');
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