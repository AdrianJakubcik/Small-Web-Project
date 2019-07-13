<?php
 $host = "localhost";
 $username = "area51_user";
 $password = "area51";
 $database = "area51db";
 $conn = new mysqli($host,$username,$password,$database);
 if($conn->connect_error)
 {
     die("Connection to Database Failed!".$conn->connect_error);
 }

 function NewUser($user,$password,$email) {
    
 }

function CheckIfUserExists($user,$email, $conn) {
    $stmt = $conn->prepare('SELECT * FROM clients WHERE USERNAME = ? OR EMAIL = ?');
    $stmt->bind_param('ss',$user,$email);
    $stmt->execute();

    $result = $stmt->get_result();
    echo($result);
}

?>