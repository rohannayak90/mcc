<?php
 
/**
 * Create a database connection
 */
class DbConnect
{ 
    private $conn;
 
    function __construct()
    {     
        
    }
 
    /**
     * Establish a database connection
     * @return the database connection handler
     */
    function connect()
    {
        include_once dirname(__FILE__) . './Config.php';
 
        // Connect to the database
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
        // Check for any error while connecting database
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
 
        // returing connection resource
        return $this->conn;
    }
 
}
 
?>