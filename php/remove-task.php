<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'].'/php/database-connection.php';

    $database = new Database("localhost", "root", "michael", "users");
    $connection = $database->connect();

    $id = $_POST['id'];

    $query = $database->query(sprintf("DELETE FROM tasks WHERE tasks.id = %d", $id));

    echo $query[0];
?>
