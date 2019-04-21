<?php
session_start();

include_once "Database.php";
if (!isset($_POST['username']) || !isset($_POST['pwd'])) {
    die("<h1><font color='red'>Not Logged In!</font></h1><p><a href='signon.php'>Sign On</a>");
}
$username = $_POST['username'];
$pwd = $_POST['pwd'];
$dao = new Database(1);
$user = $dao->json("SELECT * FROM users WHERE username = '$username' AND password='$pwd'");
if ($user == null)
    die("<h1><font color='red'>Invalid Login!</font></h1><p><a href='signon.php'>Sign On</a>");

$_SESSION["webappUserId"] = $username;
?>

<!DOCTYPE html>
<!-- files in C:\xampp\htdocs\calc 
Developer: Joseph Lister
Developed: 2018-Oct-15.

Description: My Calculator page including some scientific functions.

Deployed: http://joseph-lister.com/calc/

-->
<html> 
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <title>Calculator</title>
        <style type="text/css"> 
            body {
                background-color: teal;
                
            }
            .button{
                width:50px;
                height:50px;
                text-align:center;
            }
            .button2{
                position:relative;
                left:2px;
                width:50px;
                height:50px;
                text-align: center;
                color:blue;
                font-size:12px;
            } 
            .display input{
                position:relative;
                left:2px;
                top:2px;
                height:33px;
                color:blue;
                text-align:right;
                font-size:19px;
            }
        </style>
        <script type="text/javascript">
            var user = <?php echo $user; ?>

            jQuery(document).ready(function () {
                $("#divHeader").html("Welcome "+user[0].firstname+" "+user[0].lastname);
            });
            function math(val)
            {
                var inputField = document.getElementById("displayText"); // get a reference to the display field.
                if (val === "C") // C is for clear.
                {
                    inputField.value = "";
                    return;
                }
                if (val === "=") // user clicked "=" perform calculation.
                {
                    var t = inputField.value; //get the input value
                    try {
                        var v = 0;
                        if (t.indexOf("^") > 0)  // raise to a power.
                        {
                            var p = t.split("^"); // split on ^, i.e. 4^2 becomes array p[0]=4, p[1]=2
                            v = Math.pow(p[0], p[1]);
                        } else
                            v = eval(t);  // use the built in eval function to perform the calculation.
                        inputField.value = v;

                    } catch (e) {
                        alert("Error");
                    }
                    return;
                }
                if (val === "O") { // cosine
                    var cos = inputField.value.split("*");

                    var c = Math.cos(cos[0]) * cos[1];

                    inputField.value = (c);
                    return;
                }
                if (val === "S") { //sine
                    var sin = inputField.value.split("*");

                    var s = Math.sin(sin[0]) * sin[1];
                    inputField.value = (s);
                    return;
                }
                if (val === "T") { // tangent
                    var v = inputField.value;

                    var t = Math.tan(v * Math.PI / 180);

                    inputField.value = (t);
                    return;
                }
                if (val === "P") { // PI
                    var v = document.getElementById("displayText").value;

                    var t = 2 * Math.PI * v;

                    inputField.value = (t);
                    return;
                }
                var t = inputField.value;

                t += val;

                inputField.value = t;

            }
        </script>
    </head>

    <body style="color: white;" background="cubes_structure.jpg">
        <div><span id='divHeader'></span> <a href="logout.php"><font color='white'>[Logout]</font></a></div>

        <div align="center">
            <h1>Calculator</h1>
            <div class="display">
                <input type="text" id="displayText" size="50" class="display" value="" readonly/> 
                <div class="keys"> 
                    <p>
                        <input type="button" class="button"  style='text-align: center; background-color:grey;color:white' value="(" onclick='math("(")'>

                        <input type="button" class="button" style='text-align: center; color:white;background-color:grey' value=")" onclick='math(")")'>
                        <input type="button" class="button" style='text-align: center; background-color:grey;color:white' value="/" onclick='math("/")'>	
                        <input type="button" class="button"  style='text-align: center; background-color:grey;color:white' value="=" onclick='math("=")'>
                    </p>
                    <p>
                        <input type="button" class="button" value="7" style='text-align: center; background-color:grey;color:white' onclick='math("7")'>
                        <input type="button" class="button" value="8" style='text-align: center; background-color:grey;color:white' onclick='math("8")'>
                        <input type="button" class="button" value="9" style='text-align: center; background-color:grey;color:white'onclick='math("9")'>
                        <input type="button" class="button" value="*" style='text-align: center; background-color:grey;color:white'onclick='math("*")'>
                    </p>
                    <p>
                        <input type="button" class="button" value="4" style='text-align: center; background-color:grey;color:white'onclick='math("4")'>
                        <input type="button" class="button" value="5" style='text-align: center; background-color:grey;color:white'onclick='math("5")'>
                        <input type="button" class="button" value="6" style='text-align: center; background-color:grey;color:white'onclick='math("6")'>
                        <input type="button" class="button" value="+"  style='text-align: center; background-color:grey;color:white'onclick='math("+")'>

                    </p> 
                    <p>

                        <input type="button" class="button" value="1" style='text-align: center; background-color:grey;color:white' onclick='math("1")'>
                        <input type="button" class="button" value="2" style='text-align: center; background-color:grey;color:white' onclick='math("2")'>
                        <input type="button" class="button" value="3" style='text-align: center; background-color:grey;color:white' onclick='math("3")'>
                        <input type="button" class="button" value="-" style='text-align: center; background-color:grey;color:white' onclick='math("-")'>

                    </p>
                    <p>
                        <input type="button" class="button" value="0" style='text-align: center; background-color:grey;color:white' onclick='math("0")'>
                        <input type="button" class="button" value="." style='text-align: center; background-color:grey;color:white' onclick='math(".")'>
                        <input type="button" class="button" value="^" style='text-align: center; background-color:grey;color:white' onclick='math("^")'>
                        <input type="button" class="button" value="C" style='text-align: center; background-color:grey;color:white' onclick='math("C")'>

                    </p>
                    <button class="button2" onclick='math("O")' style='text-align: center; background-color:grey;color:white'>COS</button>
                    <button class="button2" onclick='math("S")' style='text-align: center; background-color:grey;color:white'>SIN</button>
                    <button class="button2" onclick='math("T")' style='text-align: center; background-color:grey;color:white'>TAN</button>
                    <button class="button2" onclick='math("P")' style='text-align: center; background-color:grey;color:white'>PI</button>

                </div>
            </div>
        </div> 


    </body>
</html> 
