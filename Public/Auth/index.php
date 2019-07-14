<?php

require("../Auth/Database.php");

$ID = GetIdByName("Ghost141", $dbconn);
echo($ID."::");
$DBPass = (GetPassowrdByID($ID, $dbconn));
echo($DBPass);

?>