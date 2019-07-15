<?php

require("../Auth/Database.php");

/*$ID = GetIdByName("Ghost141", $dbconn);
echo($ID."::");
$DBPass = (GetPassowrdByID($ID, $dbconn));
echo($DBPass);*/

/*if(Authenticate_Client("Midas67","Tatra148",$dbconn)){
    echo '<script language="javascript"> alert("Successfully Authenticated!");</script>'; 
} else{
    die('<script language="javascript"> alert("Authentication Failed!");</script>');
}*/

/*if(RegisterNewUser("Midas67","Tatra148","Midas@King.com",$dbconn)){
    echo '<script language="javascript"> alert("Successfully Registrated!");</script>'; 
} else {
    die('<script language="javascript"> alert("Registration Failed!");</script>');
}*/
$res = ResetToken("Midas@King.com",$dbconn);

if((int)$res == 404){
    echo('<script language="javascript"> alert("Failed: Such Token Already Exists!");</script>');
}else if($res == true){
    echo('<script language="javascript"> alert("Token Was Generated Successfully!");</script>');
}else{
    die('<script language="javascript"> alert("Token Generation Failed!");</script>');
}

?>