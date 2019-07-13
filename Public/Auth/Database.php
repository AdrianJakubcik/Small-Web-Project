<?php

//require

 $host = "localhost";
 $username = "area51_user";
 $password = "area51";
 $database = "area51db";
 $conn = new mysqli($host,$username,$password,$database);
 if($conn->connect_error)
 {
     die("Connection to Database Failed!".$conn->connect_error);
 }


 function NewUser($user,$password,$email, $conn) {
     $res = BeforeAddingToDBChecks($user,$email,$conn);
    if($res == "true")
    {
        
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

function AddToDB($user, $password, $date, $salt, $dbconn) {
    $user = TestInput($user);
    
}

?>