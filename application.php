<?php
    // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    session_start();

    include $_SERVER['DOCUMENT_ROOT'].'/php/database-connection.php';
    include $_SERVER['DOCUMENT_ROOT'].'/php/task.php';

    if (isset($_SESSION['session_id']) === FALSE) {
        header("Location: http://localhost/login.php");
    }

    $database = new Database("localhost", "root", "michael", "users");
    $connection = $database->connect();

    $tasks = array();
    $result = $database->query(sprintf("SELECT tasks.id, tasks.title, tasks.description, tasks.completed FROM tasks WHERE tasks.id_user = %d", $_SESSION['session_userid']));
    for ($i = 0; $i < count($result); $i++) {
        $task = new Task($result[$i]['id'], $result[$i]['title'], $result[$i]['description'], $result[$i]['completed']);
        array_push($tasks, $task);
    }

    $getUsernameQuery = $database->query(sprintf("SELECT login.username FROM login WHERE login.id = %d", $_SESSION['session_userid']));
    $sessionUsername = $getUsernameQuery[0]['username'];
?>

<html>
    <head>
        <title> To-Do List App - LOGIN</title>
        <link rel="stylesheet" type="text/css" href="css/application.css"/>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="http://localhost/js/application.js"> </script>
    </head>

    <body>
        <div class="task-add-form">
            <div class="task-add-form-title"> Create Task </div>

            <div class="task-add-form-input-title"> Title </div>
            <input id="task-form-title" type="text" placeholder="Type the title of the task"/>

            <div class="task-add-form-input-title"> Description </div>
            <textarea id="task-form-description" rows="4" cols="50" placeholder="Type the description of the task"> </textarea>

            <div class="task-add-form-submit">
                <input id="task-form-submit" type="submit" value="Create task" />
            </div>
        </div>

        <div class="application-container">
            <div class="application-table">
                <div class="table-left table-container-left">
                    <div class="table-content">
                        <div class="todo-content">
                            <div class="todo-header">
                                <div class="todo-title"> To-Do List </div>
                                <button class="todo-add-button"> + </button>
                            </div>
                            <div class="todo-task-list">
                                <?php for ($i = 0; $i < count($tasks); $i++): ?>
                                    <div class="todo-task todo-task-normal">
                                        <div onclick="taskIconPressed(this)" class="todo-task-icon"> </div>
                                        <div class="todo-task-description">
                                            <span onclick="taskPressed(this);" id="task-title-<?php echo $tasks[$i]->id; ?>" class="task-title">
                                                <?php echo $tasks[$i]->title ?>
                                            </span>
                                            <span class="task-description">
                                                <?php echo $tasks[$i]->description; ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-right table-container-right">
                    <div class="table-content">
                        <div class="todo-content">
                            <div class="account-section">
                                <div class="account-icon"> </div>
                                <div class="account-name"> <?php echo $sessionUsername; ?> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
