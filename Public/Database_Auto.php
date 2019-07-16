<?php
require('Auth/Database.php');


function RunAutoDeleteExpiredTokens(){
    global $dbconn;
    if(CheckConnection()){
        $stmt = $dbconn->prepare('DELETE FROM password_resets WHERE EXPIRATION < ?');
        $stmt->bind_param('s', date("Y-m-d H:i:s"));
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }else {
        return (int)404;
    }
}

function getUserIDofExpiredUsers(){
    global $dbconn;
    if(CheckConnection()){

    }else {
        return (int)404;
    }
}

function getUserIDofUnexpiredUsers(){
    global $dbconn;
    if(CheckConnection()){
        
    }else {
        return (int)404;
    }
}

?>