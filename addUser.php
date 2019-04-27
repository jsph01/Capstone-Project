<?php
include_once "Database.php";
#include_once "util/sendmail.php";
$userId=0;
@extract($_POST);
if ($email && $lastName && $firstName && $password1 && $password2) {
    if ($password1 != $password2)
        die("<h1><font color='red'>passwords don't match!  Click back to fix</font></h1>");
    else if (strlen($password1) < 8 && $userId < 1)
        die("<h1><font color='red'>$userId passwords missing or invalid $password1</font></h1>");
    
    $sql="usp_save_user(0, '$userName','$email','$lastName', '$firstName','415-555-1212','12345',"
            . "'$password1','$password2',1,'$userName')";
//echo $sql;
    $dao = new Database(1);
   // extract($dao->call($sql)->fetch());
    extract($dao->call($sql)->fetch());
    $id = $retcode;
    echo "\nResult: $id, $retval";
    echo "<h3>You account has been created</h3><a href='signon.php'>Click here to login</a>";
    $msg = "You user account has been created for: $userName";
    
} else {
    echo $lastName;
    echo $firstName;
    echo $email;
    echo $userName;
    die("<h1><font color='red'>Data missing!  Click back to fix.</font></h1>");
}
?>