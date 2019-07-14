<?php
require("../Auth/Database.php");



function Register($username,$password,$email,$conn) {

    if(RegisterNewUser($username,$password,$email,$conn))
    {
        //Send to RegSuccess.php
    }else{
        return;
    }

}
?>