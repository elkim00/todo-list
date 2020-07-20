<?php
    class Task {
        public $id = -1;
        public $title = "Generic Title";
        public $description = "Generic Description";
        public $completed = FALSE;

        function __construct($id, $title, $description, $completed) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->completed = $completed;
        }
    }
?>
