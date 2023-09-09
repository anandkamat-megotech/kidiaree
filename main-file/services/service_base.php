<?php

include './utilities/db_connection.php';

class ServiceBase {
    
    public $db;
    
    public function __construct(){
        $this->db = db_connect();
        return $this->db;
    }
    
    public function __destruct(){
        db_destroy($this->db);
    }
    
    public function getDb() {
        if ($this->db instanceof PDO) {
             return $this->db;
        }
  }
}

?>