<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'].'/php/database-connection.php';

    $database = new Database("localhost", "root", "michael", "users");
    $connection = $database->connect();

    // Check if the given parameters (username and password)
    // exist on the database
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $database->query(sprintf("SELECT id, username, password FROM login WHERE username='%s' AND password='%s'", $username, $password));

    if (count($result) > 0) {
        $_SESSION['session_id'] = session_id();
        $_SESSION['session_userid'] = $result[0]['id'];
        echo "PASS";
    } else {
        echo "FAIL";
    }
?>
