<?php
#include_once "util/sendmail.php";
include_once "Database.php";

session_start();

if (!isset($_GET['id']))
    die("No Id");
$id = $_GET['id'];

$userId = null;
if (isset($_SESSION['webappUserId']))
    $userId = $_SESSION['webappUserId'];

//echo "$id - $userId";
//points($id, $userId);
switch ($id) {
    case 1:
        userExists();
        break;
    case 2:
        findUser();
        break;
	case 3:
	
    case 4:
        files();
        break;
}
function files()
{
    if (!isset($_GET['parentId'])) {
        die("No userId provided");
    }
    $parentId=$_GET['parentId'];
    $parentType=1;
    if (isset($_GET['parentType'])) 
        $parentType=$_GET['parentType'];

    $dao = new Database(1);
    try {
        $sql="SELECT * FROM view_files WHERE parentId = $parentId AND parentType=$parentType";
        $json = $dao->json($sql);
        echo $json;
    } catch (Exception $ex) {

    }
}


function resetPassword() {
    if (!isset($_GET['username'])) {
        die("No value provided");
    }
    $username = $_GET['username'];
    try {
        $db = new Database(1);

        //$sql = "INSERT INTO friends (user_id, friend_id, request_dt, status) VALUES($userId,$friendId,SYSDATE(),0)";
        echo $sql;
        $sql = "usp_reset_password('$username')";
        //echo $sql;

        extract($db->call($sql)->fetch());

        $db->close();
        if ($code < 1) {
            echo "Failed to send reset email";
            return;
        }
        $msg = "Username: $username\n\nclick link to reset your password: <a href='http://appjedi.net/clinbook/resetpwd.php?code=$code'>click here</a>";

        sendmail($username, "Account Information", $msg, "timlinator@gmail.com");
        echo "email sent to $username";
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}



function findUser() {
    if (!isset($_GET['str']))
        die("No query provided");
    $str = $_GET['str'];
    $dao = new Database(3);
    $query = "SELECT * FROM users WHERE ";
   // $query = "SELECT * FROM users WHERE ";
    try {
        if (is_numeric($str))
            $query .= " user_id=$str";
        else
            $query .= " lastname like '$str%'";

        $u = $dao->json($query);
        echo $u;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}



function userExists() {
    if (!isset($_GET['username']))
        die("No Username provided");
    $un = $_GET['username'];
    if (strlen($un) < 4) {
        echo "Not long enough, min length is four characters";
        return;
    }

    $query = "SELECT 1 FROM users WHERE username='$un'";
    $dao = new Database(1);
    try {
        $stmt = $dao->query($query);
        if ($stmt->rowCount() == 0)
            echo "Available";
        else
            echo "Not Available";
        $dao->close();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
