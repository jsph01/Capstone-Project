<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>PostgreSQL Test</title>
    </head>
    <body>
        <?php
            include_once "Database.php";
            $dao = new Database(2);
            $sql="public.usp_save_user (0,'testnew','Test Insert','Jeff','jeff@insert.com','415-555-1234','Test1234')";
            //echo $sql;
            //$test = $dao->json("SELECT * FROM test");
            //$dao->call($sql);
            $sql="UPDATE test SET name='Update test 4' WHERE id =1";
            $dao->execute($sql);

            echo $sql;
        ?>
    </body>
</html>
