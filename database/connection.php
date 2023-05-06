<?php
session_start();

class Database
{
    public $conn;

    public function __construct()
    {
        require_once("constants.php");
        $this->conn = new Mysqli(HOST, USERNAME, PASSWORD, DBNAME, PORT);
        $this->conn->set_charset("utf8");
        if ($this->conn) {
            date_default_timezone_set("Asia/Singapore");
            return $this->conn;
        } else {
            return "CANT CONNECT TO DATABASE" . $this->error;
        }
    }
}
