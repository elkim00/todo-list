<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'].'/php/database-connection.php';

    $database = new Database("localhost", "root", "michael", "users");
    $database->connect();

    // Get the parameters (username, password and email)
    // and register it onto the database
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $result = $database->query(sprintf("INSERT INTO `login` (`id`, `username`, `password`, `email`) VALUES (NULL, '%s', '%s', '%s')", $username, $password, $email));
    if ($result === TRUE) {
        echo "PASS";
    } else {
        echo "FAIL";
    }
?>
