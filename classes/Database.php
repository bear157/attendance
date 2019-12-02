<?php
class Database{ 
    private $db_host = "localhost";
    private $db_username = "root";
    private $db_password = "";
    private $db_name = "suc_attendance";

    public $conn;
    
    public function __construct()
    {
        $this->dbConnect();
    }
    
    private function dbConnect()
    {
        try
        {
            $this->conn = new PDO("mysql:host=$this->db_host;dbname=$this->db_name",$this->db_username, $this->db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "DB connection error";
        }   
    }

    public function closeConn() 
    {
        $this->conn = null; 
    }
}
?>