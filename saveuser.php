<?php
include_once "Database.php";

@extract($_POST);
if ($email && $lastName && $firstName && $username) {
    if ($password != $password2)
        die("<h1><font color='red'>passwords don't match!  Click back to fix</font></h1>");
    else if (strlen($password) < 8 && $userId < 1)
        die("<h1><font color='red'>$userId passwords missing or invalid</font></h1>");
    $sql = "usp_save_user($userId, '$userName','$email','$lastName', '$firstName','415-555-1212','12345',"
            . "'$password1','$password2',1,'$userName')";
//echo $sql;
    $dao = new Database(1);
    extract($dao->call($sql)->fetch());

    $id = $retcode;
    echo "\nResult: $id, $retval";
    $msg = "You user account has been created for: $username";
    /*
    if ($id == 0) {
        $Result = sendmail($email, "You user account has been created for: $username", $msg);
        $Result = sendmail("bob@timslist.com", "User account has been created for: $username", "User account has been created for: $username");
    } else {
        $Result = sendmail("bob@timslist.com", "User account has been updated for: $username", "User account has been created for: $username");
    }
     * */
     
} else {
    echo $lastName;
    echo $firstName;
    echo $email;
    echo $username;
    die("<h1><font color='red'>Data missing!  Click back to fix.</font></h1>");
}
?>