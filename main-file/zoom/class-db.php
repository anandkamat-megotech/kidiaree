<?php
include '../globals/constants_db.php';
class DB {
    private $dbHost     = "10.35.160.3";
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;
    private $dbName     = "bricketc";
    private $db;
  
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
  
    public function is_table_empty($zoom_id) {
        $result = $this->db->query("SELECT id FROM zoom_oauth WHERE id = '$zoom_id'");
        if($result->num_rows) {
            return false;
        }
  
        return true;
    }
  
    public function get_access_token($zoom_id) {
        $sql = $this->db->query("SELECT provider_value FROM zoom_oauth WHERE id = '$zoom_id'");
        $result = $sql->fetch_assoc();
        return json_decode($result['provider_value']);
    }
  
    public function get_refersh_token($zoom_id) {
        $result = $this->get_access_token($zoom_id);
        return $result->refresh_token;
    }
  
    public function update_access_token($token,$zoom_id) {
        if($this->is_table_empty($zoom_id)) {
            $this->db->query("INSERT INTO zoom_oauth(provider, provider_value) VALUES('zoom$zoom_id', '$token')");
        } else {
            $this->db->query("UPDATE zoom_oauth SET provider_value = '$token' WHERE id = '$zoom_id'");
        }
    }
    public function create_data($sql) {
        $this->db->query($sql);
    }

    public function is_meeting_scheduled($meetingTimestamp, $zoom_id) {
        $result = $this->db->query("SELECT id FROM MultipleLiveSessions WHERE meetingTimestamp = '$meetingTimestamp' AND zoom_id = '$zoom_id'");
        if($result->num_rows) {
            return true;
        }
  
        return false;
    }

    public function get_zoom_id($cid) {
        // echo "SELECT id FROM zoom_oauth WHERE coursesId like '%-:-$cid-:-%'";
        $sql = $this->db->query("SELECT id FROM zoom_oauth WHERE coursesId like '%-:-$cid-:-%'");
        $result = $sql->fetch_assoc();
        return json_decode($result['id']);
    }
}