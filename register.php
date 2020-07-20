<html>
    <head>
        <title> To-Do List App - REGISTER</title>
        <link rel="stylesheet" type="text/css" href="css/login.css"/>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    </head>

    <body>
        <div class="login-container">
            <div class="login-box">
                <span class="login-title"> Register </span>

                <span class="login-credential"> E-Mail </span>
                <input id="email" type="text" placeholder="Type your e-mail" required/>

                <span class="login-credential"> Username </span>
                <input id="username" type="text" placeholder="Type your username" required/>

                <span class="login-credential"> Password </span>
                <input id="password" type="password" placeholder="Type your password" required/>

                <input type="submit" class="login-submit" value="Register">
            </div>
        </div>
    </body>

    <script>
        $(".login-submit").click(function() {
            $.post("/php/registration.php", {
                username: $("#username").val(),
                password: $("#password").val(),
                email: $("#email").val()
             })
             .done(function(data) {
                 if (data == "PASS") {
                     window.location = "http://localhost/login.php"
                 }
             })
        })
    </script>
</html>
