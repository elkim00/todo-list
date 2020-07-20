<?php
    session_start();

    class Database {
        public $server = "localhost";
        public $user = "root";
        public $password = "michael";
        public $table = "users";
        public $connection;

        public function __construct($server, $user, $password, $table) {
            $this->server = $server;
            $this->user = $user;
            $this->password = $password;
            $this->table = $table;
        }

        public function connect() {
            $this->connection = new mysqli($this->server, $this->user, $this->password, $this->table);
            return $this->connection;
        }

        public function query($query) {
            $array = array();
            $result = $this->connection->multi_query($query);

            // Check if it's a single value return...
            // if ($result === TRUE) return TRUE;
            // else if ($result === FALSE) return FALSE;

            do {
                if ($record = $this->connection->store_result()) {
                    $new_array = array();
                    while ($row = $record->fetch_assoc()) {
                        array_push($new_array, $row);
                    }
                    array_push($array, $new_array);
                    $record->free();
                }
            } while ($this->connection->next_result());

            if (count($array) == 1) return $array[0];
            return $array;
        }
    }
?>
