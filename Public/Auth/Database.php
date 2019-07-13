<?php

require("../../Confg/config.php");
require("../../Private/Cryptography.php");

 $host = constant("host");
 $username = constant("username");
 $password = constant("password");
 $database = constant("database");
 $conn = new mysqli($host,$username,$password,$database);
 if($conn->connect_error)
 {
     die("Connection to Database Failed!".$conn->connect_error);
 }


function ProccessNewUser($user, $password, $email, $dbconn) {
    $user = TestInput($user);
    $date = date("Y-m-d");
    $salt = GenerateNewSalt();
    $password = AdvancedEncryptionWithSalt($password,$salt);
    AddNewUserToDB($user,$date,$password,$salt,$email,$dbconn);
}

function AddNewUserToDB($user,$date,$password,$salt,$email,$dbconn){
    $stmt = $dbconn->prepare('INSERT INTO clients (USERNAME,PASSWORD,KEY_SALT,EMAIL,REG_DATE) VALUES (?,?,?,?,?)');
    $stmt->bind_param('sssss',$user,$password,$salt,$email,$date);
    if($stmt->execute()){
        echo(" Registration was successfull! " . $user);
        return;
    } else{
        die("Registration Failed Due To Error " . $stmt->execute());
    }
}

 function NewUser($user,$password,$email, $conn) {
     $res = BeforeAddingToDBChecks($user,$email,$conn);
    if($res == "true")
    {
        ProccessNewUser($user,$password,$email,$conn);
    } else {
        die("Registration failed: " . $res);
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



?>