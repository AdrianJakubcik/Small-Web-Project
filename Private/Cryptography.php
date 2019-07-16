<?php
function GenerateNewSalt() {
    $newstr = GenerateRandomString(12);
    $newstr = crypt($newstr, $newstr);
   return $newstr;
}

function AdvancedEncryption($key){
    $enc_str = password_hash(crypt($key,$key), PASSWORD_DEFAULT);
    return $enc_str;
}

function AdvancedEncryptionVerify($key, $pw_key){
    $res = password_verify(crypt($key,$key), $pw_key);
    if($res)
    {
        return true;
    }else {
        return false;
    }
}

function TOKEN_GENERATE_NEW(){
   return GenerateRandomString(52, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
}

function GenerateRandomString($length, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}
?>