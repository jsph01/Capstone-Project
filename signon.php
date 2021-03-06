<?php session_write_close(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel='stylesheet' type='text/css' href='style.css'/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="HandheldFriendly" content="true">
            <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=0">
                <link href="style.css" rel="stylesheet" type="text/css" media="screen" />
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src='scripts/ajax.js'></script>
                <script src='scripts/validate.js'></script>
                <script type="text/javascript">
                    var userOk = false;//Flag set to false until ajax call returns 'Available'
                    function callServer(url)
                    {
                        $.get(url,
                                function (retval) {
                                    return retval;
                                });
                    }
                    /*
                     * lost focus even on new username.
                     * Ajax call to query users table based on entered username.
                     */
                    function availUser(fld)
                    {
                        var val = fld.value;
                        json("ajax.php?id=1&username=" + val, availUser_Callback);
                    }
                    /* callback function from above. 
                     * If msg=='Available' username not taken and may be used.
                     */
                    function availUser_Callback(msg)
                    {
                        if (msg === "Available") {// Not found in user table and may be used.
                            userOk = true;
                            $("#userOk").val("1");
                            $("#userStatus").html("<font color='green'>" + msg + "</font>");
                        } else {// Found in database and may not be used.
                            userOk = false;
                            $("#userOk").val("0");
                            $("#userStatus").html("<font color='red'>" + msg + "</font>");
                            $("#userName").focus();
                        }
                    }


                    // fields on form to validate
                    var fields = ['userName', 'lastName', 'firstName', 'email', 'password1']
                    var names = ['User Name', 'Last Name', 'First Name', 'Email', 'Password'];

                    function form_Submit(frm)
                    {
                        if (!userOk)//if ajax server call returns 'Available'
                        {
                            if (frm.lastName.value !== "")
                            {//if form last name is entered but userOk is false probably
                                // because back button was hit from save page.
                                // Make Ajax call to validate
                                $.get("ajax.php?id=1&username=" + frm.userName.value,
                                        function (data) {
                                            if (data !== "Available")
                                            {
                                                alert("Invalid user name");
                                                return false;
                                            }
                                        });
                            } else {
                                alert("Invalid user name");
                                return false;
                            }
                        }
                        //validate all fields on form.  scripts/validate is in validate.js
                        var errors = validate(fields, names);
                        if (errors.length > 0)//errors found, loop through and display in message div.
                        {
                            var msg = "<font color='red'><b><u>Errors:</u></b><br/>";
                            for (var i in errors)
                                msg += errors[i] + " required field.<br/>";
                            //alert(msg);
                            $("#userStatus").html(msg + "</font>");
                            return false;
                        }

                        // basic validation on passwords equal and at least 8 characters.
                        if (frm.password1.value !== frm.password2.value)
                        {
                            $("#userStatus").html("<font color='red'>Passwords don't match!</font>");
                            return false;
                        } else if ((frm.password1.value + "").length < 8)
                        {
                            $("#userStatus").html("<font color='red'>Passwords must be at least 8 characters!</font>");

                            return false;
                        }
                        return true;
                    }

                    function forgot()
                    {
                        var email = prompt("Enter email to retrieve account information:");
                        if (email != null && email != "")
                            json("ajax.php?id=11&username=" + email, forgot_Callback);
                    }
                    function forgot_Callback(msg)
                    {
                        alert(msg);
                    }

                </script>
                <meta http-equiv="Content-Language" content="en-us" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style>
                    .titleLeft{
                        position:relative;
                        left:10%;
                        top:35px;
                        color:white;
                        font-size: xx-large;
                        vertical-align: bottom;
                    }
                    li{
                        font-size: x-large;
                    }
                    .titleRight{
                        position:relative;
                        left:55%;
                        color:white;
                    }
                    .divTitle{
                        position: absolute;
                        left:5px;
                        top:5px;
                        padding: 10px;

                    }
                    .divLogo{
                        position: absolute;
                        left:10px;
                        top:10px;
                    }
                    .divNewUserForm{
                        position:relative;
                        left: 65%;
                    }
                    .divContent{
                        position: absolute;
                        left:10px;
                        top:180px;
                        width:50%;
                    }
                    .forgot{
                        color:white;
                        position:relative;
                        left: 240px;  
                    }
                    a{color:white;}

                    .divInput{
                        height:25px;
                    }
                    .classMessage{
                        position: absolute;
                        left:480px;
                        top:240px;
                        color:red;
                    }
                </style>

                <title>Welcome to My Login</title>
                </head>

                <body style="color: white;" background="cubes_structure.jpg">
                    <div id='divMessage' class='classMessage'></div>
                    <div class="wrapper">

                        <div id="divLogin" class="divTitle">
                            <h2 align="center">Sign in to My Calculator</h2>
                        </div>		
                        <div id="divSignIn" class="divNewUserForm">
                            <h1>Sign In</h1>
                            <div>
                                <form method="post" action="calc.php">
                                    Username: <input type="text" name="username" id="username" size="10" />
                                    Password: <input type="password" name="pwd" id="pwd" size="10"/>
                                    <input type="submit" value="Login" />
                                </form>
                            </div>
                            <div> <span class='forgot'><a href='javascript:forgot()'>Forgot Account?</a></span></div>
                        </div>  

                        <div id="divAddUser" class="divNewUserForm">
                            <form method="post" action="addUser.php" name="frmAddUser" onsubmit="return form_Submit(this)">
                                <input type="hidden" name="userOk" id="userOk" value="0"/>
                                <h1>Sign up</h1><h3>It's free and easy.</h3>
                                <div>
                                    <div class='divInput'><input name="userName" id="userName" placeholder="User name" type="text" size="40" onblur="availUser(this)" /></div>
                                    <div class='divInput'><input name="firstName" id="firstName" placeholder="First name" type="text" size="40" /></div>

                                    <div class='divInput'><input name="lastName" id="lastName" placeholder="Last name" type="text" size="40"/></div>
                                    <div class='divInput'><input name="email" id="email"  placeholder="Email" type="text" size="40" 
                                                                 />
                                        <div class='divInput'> <input name="password1" id="password1" type="password" placeholder="Password" size="30"/></div>
                                        <div class='divInput'> <input name="password2" id="password2" type="password" placeholder="confirm password" size="30"/></div>
                                    </div><br/><br/><br/>

                                    <input type="submit" value="Create Profile"/></div>
                                <br/><span id="userStatus"></span></div>

                        </form>
                    </div>
                    </div>
                </body>
                </html>
