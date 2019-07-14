<?php

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
            return "Not Found";
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

?>