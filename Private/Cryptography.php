<?php
function GenerateNewSalt() {
    $newstr = GenerateRandomString(12);
    $newstr = crypt($newstr, $newstr);
   return $newstr;
}

function AdvancedEncryptionWithSalt($key, $salt){
    $enc_str = crypt($key,$salt);
    $enc_str = $salt . $enc_str;
    $enc_str = hash("sha256", $enc_str);
    return $enc_str;
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