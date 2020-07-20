var tasks = [];

class Task {
    // The constructor that takes the basic information of a task and
    // cretes a HTML string based on them that will be later shown upon
    // creation on the task list
    constructor(id, title, description) {
        this.id = id;
        this.title = title;
        this.description = description;
        this.html = '<div class="todo-task todo-task-normal"> <div onclick="taskIconPressed(this)" class="todo-task-icon"> </div> <div class="todo-task-description"> <span onclick="taskPressed(this);" id="task-title-' + this.id + '" class="task-title">' + this.title + ' </span>  <span class="task-description">' + this.description + '</span> </div> </div>';
        console.log(this.html);
    }

    getHTML() { return this.html; }
}

// Function called at the start to copy all the task created from the execution
// of PHP code to a JS array
function getTasksFromSQL() {
    $(".todo-task").each(function(i) {
        var description = $(".todo-task")[i]['children'][1];

        var id_string = description['children'][0]['id']
        var id = parseInt(id_string.substring(id_string.lastIndexOf('-') + 1))
        var task_title = description['children']['innerText'];
        var task_description = description['children'][1]['innerText'];

        addTask(new Task(id, task_title, task_description), false);
    });
}


// Add a task to the task list array; the 'visibility' value will determine whether
// the task will be added to the array and to the page with the proper addEventListener
function addTask(task, visibility = true) {
    tasks.push(task);
    if (visibility == true) {
        $(".todo-task-list").append(task.getHTML());
    }
}

// Remove the task from the array given an ID and make the task disappear with
// an effect
function removeTask(id) {
    for (var i = 0; i < tasks.length; i++) {
        if (tasks[i].id == id) {
            var parent = $("#task-title-" + tasks[i].id).parent().parent();
            parent.addClass("disappear-animation");
            setTimeout(function() {
                parent.remove();
            }, 750);

            tasks.splice(i, 1);
        }
    }
}

// On event taskPressed, this will collapse or show the description of the clicked
// task and its content
function taskPressed(event) {
    var id_string = event['id'];
    var id = parseInt(id_string.substring(id_string.lastIndexOf('-') + 1))

    var description = $("#task-title-" + id).next()[0];

    if ($(description).hasClass("collapse-height-auto")) $(description).removeClass("collapse-height-auto");
    else $(description).addClass("collapse-height-auto");
}


// On event taskIconPressed, this will remove the task on the array of tasks append
// will use AJAX to remove the clicked task from the database
function taskIconPressed(event) {
    console.log(event);

    var id_string = event['parentElement']['children'][1]['children'][0]['id'];
    var id_task = parseInt(id_string.substring(id_string.lastIndexOf('-') + 1));

    $.post("/php/remove-task.php", {
        id: id_task
    })
    .done(function(data) {
        removeTask(id_task);
    })
}

$(document).ready(function() {
    getTasksFromSQL();

    $(".todo-add-button").click(function() {
        // Set the visibility and the opacity of the form
        // (if it's clickable on not while on opacity 0)
        var form = $(".task-add-form");
        var button = $(".todo-add-button");
        var opacity = form.css("opacity") == 1 ? 0 : 1;
        form.css("visibility", "visible");
        form.css("opacity", opacity);

        if (opacity == 1) {
            // This will move the form on the mouse's position
            // only if it's not visible otherwise
            form.css("top", button.position().top + parseInt(button.css("height")) + 30);
            form.css("left", button.position().left
                             - parseInt(form.css("width")) / 2
                             + parseInt(button.css("width")) / 2
                    );
        }

        setTimeout(function() {
            if (form.css("opacity") == 0) form.css("visibility", "hidden");
        }, 550);
    })

    $("#task-form-submit").click(function() {
        // This will use AJAX to call the addition of a task onto the database
        // with the given information; when done add the task on the JS array and
        // reset the 'add task' form
        $.post("/php/add-task.php", {
            title: $("#task-form-title").val(),
            description: $("#task-form-description").val()
        })
        .done(function(data) {
            if (data != undefined) {
                var description = $("#task-form-description").val();
                var task = new Task(parseInt(data), $("#task-form-title").val(), `${description}`);
                addTask(task);

                $("#task-form-title").val("");
                $("#task-form-description").val("");
            }
        })
    })
})
