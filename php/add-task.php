<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'].'/php/database-connection.php';

    $database = new Database("localhost", "root", "michael", "users");
    $connection = $database->connect();

    // Get the POST information
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Insert the task on the database
    $result = $database->query(sprintf("INSERT INTO tasks (id, title, description, completed, id_user) VALUES (NULL, '%s', '%s', 0, %d);
                                        SELECT LAST_INSERT_ID();", $title, $description, $_SESSION['session_userid']));

    echo $result[0]['LAST_INSERT_ID()'];
?>
