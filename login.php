<?php
    session_start();

    if (isset($_SESSION['session_userid'])) {
        header("Location: http://localhost/application.php");
    }
?>

<html>
    <head>
        <title> To-Do List App - LOGIN</title>
        <link rel="stylesheet" type="text/css" href="css/login.css"/>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    </head>

    <body>
        <div class="login-container">
            <div class="login-box">
                <span class="login-title"> Login </span>

                <span class="login-credential"> Username </span>
                <input id="username" type="text" placeholder="Type your username" required/>

                <span class="login-credential"> Password </span>
                <input id="password" type="password" placeholder="Type your password" required/>

                <input type="submit" class="login-submit" value="Log in">

                <span class="login-register"> or <a href="register.php"> create an account </a> </span>
            </div>
        </div>
    </body>

    <script>
        $(".login-submit").click(function() {
            $.post("/php/check-login.php", { username: $("#username").val(), password: $("#password").val() })
             .done(function(data) {
                 console.log(data);
                 if (data == "PASS") {
                     window.location = "http://localhost/application.php";
                 }
             })
             .fail(function(xhr) {
                 console.log(xhr);
             })
        })
    </script>
</html>
