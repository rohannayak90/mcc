<?php
 
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 */
class DbHandler {
    
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . './DBConnect.php';
        // opening db connection
        $db = new DBConnect();
        $this->conn = $db->connect();
    }
 
    /* ------------- `users` table method ------------------ */
 
    /**
     * Creating new user
     * @param String $name User full name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function createUser($name, $email, $username, $password)
    {
        require_once 'PassHash.php';
        $response = array();
 
        // First check if user already existed in db
        if (!$this->isUserExists($email))
        {
            // Generating password hash
            $password_hash = PassHash::hash($password);
 
            // Generating API key
            $api_key = $this->generateApiKey();
 
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO tbl_mst_user(api_key, user_name, user_email, status, login_username, login_password) values(?, ?, ?, 1, ?, ?)");
            $stmt->bind_param("sssss", $api_key, $name, $email, $username, $password_hash);
 
            $result = $stmt->execute();
 
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }
 
        return $response;
    }
 
    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    public function checkLogin($email, $password)
    {
        // fetching user by email
        $stmt = $this->conn->prepare("SELECT login_password FROM tbl_mst_user WHERE login_username = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->bind_result($password_hash);
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // Found user with the email
            // Now verify the password
 
            $stmt->fetch();
 
            $stmt->close();
 
            if (PassHash::check_password($password_hash, $password)) {
                // User password is correct
                return TRUE;
            } else {
                // user password is incorrect
                return FALSE;
            }
        } else {
            $stmt->close();
 
            // user not existed with the email
            return FALSE;
        }
    }
 
    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isUserExists($email)
    {
        $stmt = $this->conn->prepare("SELECT pk_user_id FROM tbl_mst_user WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
 
    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT pk_user_id, api_key, user_first_name, user_last_name, user_email, status, created_on, modified_on FROM tbl_mst_users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute())
        {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
    
    public function getUserByUserName($username)
    {
        $stmt = $this->conn->prepare("SELECT pk_id, api_key, user_name, user_email, status, created_on, modified_on FROM tbl_mst_user WHERE login_username = ?");
        $stmt->bind_param("s", $username);
       
        if ($stmt->execute())
        {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        }
        else
        {
            return NULL;
        }
    }
 
    /**
     * Fetching user api key
     * @param String $user_id user id primary key in user table
     */
    public function getApiKeyById($user_id)
    {
        $stmt = $this->conn->prepare("SELECT api_key FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $api_key = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $api_key;
        } else {
            return NULL;
        }
    }
 
    /**
     * Fetching user id by api key
     * @param String $api_key user api key
     */
    public function getUserId($api_key)
    {
        $stmt = $this->conn->prepare("SELECT pk_id FROM tbl_mst_user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        if ($stmt->execute()) {
            $user_id = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user_id;
        } else {
            return NULL;
        }
    }
 
    /**
     * Validating user api key
     * If the api key is there in db, it is a valid key
     * @param String $api_key user api key
     * @return boolean
     */
    public function isValidApiKey($api_key)
    {
        $stmt = $this->conn->prepare("SELECT pk_id from tbl_mst_user WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
 
    /**
     * Generating random Unique MD5 String for user Api key
     */
    private function generateApiKey()
    {
        return md5(uniqid(rand(), true));
    }
 
    /* ------------- `tasks` table method ------------------ */
 
    /**
     * Creating new task
     * @param String $user_id user id to whom task belongs to
     * @param String $task task text
     */
    public function createTask($user_id, $task)
    {        
        $stmt = $this->conn->prepare("INSERT INTO tasks(task) VALUES(?)");
        $stmt->bind_param("s", $task);
        $result = $stmt->execute();
        $stmt->close();
 
        if ($result) {
            // task row created
            // now assign the task to user
            $new_task_id = $this->conn->insert_id;
            $res = $this->createUserTask($user_id, $new_task_id);
            if ($res) {
                // task created successfully
                return $new_task_id;
            } else {
                // task failed to create
                return NULL;
            }
        } else {
            // task failed to create
            return NULL;
        }
    }
 
    /**
     * Fetching single task
     * @param String $task_id id of the task
     */
    public function getTask($task_id, $user_id)
    {
        $stmt = $this->conn->prepare("SELECT t.id, t.task, t.status, t.created_at from tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        if ($stmt->execute()) {
            $task = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $task;
        } else {
            return NULL;
        }
    }
 
    /**
     * Fetching all user tasks
     * @param String $user_id id of the user
     */
    public function getAllUserTasks($user_id)
    {
        $stmt = $this->conn->prepare("SELECT t.* FROM tasks t, user_tasks ut WHERE t.id = ut.task_id AND ut.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
 
    /**
     * Updating task
     * @param String $task_id id of the task
     * @param String $task task text
     * @param String $status task status
     */
    public function updateTask($user_id, $task_id, $task, $status)
    {
        $stmt = $this->conn->prepare("UPDATE tasks t, user_tasks ut set t.task = ?, t.status = ? WHERE t.id = ? AND t.id = ut.task_id AND ut.user_id = ?");
        $stmt->bind_param("siii", $task, $status, $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }
 
    /**
     * Deleting a task
     * @param String $task_id id of the task to delete
     */
    public function deleteTask($user_id, $task_id)
    {
        $stmt = $this->conn->prepare("DELETE t FROM tasks t, user_tasks ut WHERE t.id = ? AND ut.task_id = t.id AND ut.user_id = ?");
        $stmt->bind_param("ii", $task_id, $user_id);
        $stmt->execute();
        $num_affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $num_affected_rows > 0;
    }
 
    /* ------------- `user_tasks` table method ------------------ */
 
    /**
     * Function to assign a task to user
     * @param String $user_id id of the user
     * @param String $task_id id of the task
     */
    public function createUserTask($user_id, $task_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO user_tasks(user_id, task_id) values(?, ?)");
        $stmt->bind_param("ii", $user_id, $task_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    /* -------------- MY FUNCTIONS ------------------- */
    
    /**
     * Fetching all users
     * @param String $user_id id of the user
     */
    public function get_all_users($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_mst_user");        
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        return $tasks;
    }
 
    public function getUserModules($user_id)
    {
        $statement = "SELECT * FROM tbl_mst_module WHERE pk_id IN (SELECT fk_module_id FROM tbl_map_user_module WHERE fk_user_id = ? AND status = 1) AND status = 1";
        
        if ($stmt = $this->conn->prepare($statement))        
        {
            //echo $statement;
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        }
        else
        {            
            $error = $this->conn->errno . ' ' . $this->conn->error;
            $result = $error; // 1054 Unknown column 'foo' in 'field list'
        }
        return $result;
    }
    
    /**
     * Fetching Design
     * @param String $design_id id of the design
     */
    public function getDesign($design_id = 0)
    {
        $statement = 'SELECT * FROM tbl_mst_design WHERE status = 1';
        if ($design_id > 0)
            $statement .= ' AND pk_id = ' . $design_id;
        
        $stmt = $this->conn->prepare($statement);                
        //$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $designs = $stmt->get_result();
        $stmt->close();
        return $designs;
    }
    
    /**
     * Function to create a new design
     * @param String $design_name to be given to the design
     * @param String $design_desc to be given as the description to the design.
     * @param String $design_image_path
     */
    public function insertDesign($name, $desc, $image_path)
    {
        $statement = "INSERT INTO tbl_mst_design(name, description, image_path) values(?, ?, ?)";
        if ($stmt = $this->conn->prepare($statement))
        {
            $stmt->bind_param("sss", $name, $desc, $image_path);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }
    
    public function updateDesign($id, $name, $desc, $image_path)
    {
        $statement = "UPDATE tbl_mst_design SET name = ?, description = ?, image_path = ? WHERE pk_id = ?";
        if ($stmt = $this->conn->prepare($statement))        
        {
            //echo $statement;
            $stmt->bind_param("sssi", $name, $desc, $image_path, $id);
            $result = $stmt->execute();
            $stmt->close();
        }
        else
        {            
            $error = $this->conn->errno . ' ' . $this->conn->error;
            $result = $error; // 1054 Unknown column 'foo' in 'field list'
        }
        
        
        return $result;
    }
    
    /**
     * Fetching Design
     * @param String $design_id id of the design
     */
    public function getTemplate($template_id = 0)
    {
        $statement = 'SELECT * FROM tbl_mst_template WHERE status = 1';
        if ($template_id > 0)
            $statement .= ' AND pk_id = ' . $template_id;
        
        $stmt = $this->conn->prepare($statement);
        //$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $designs = $stmt->get_result();
        $stmt->close();
        return $designs;
    }
    
    /**
     * Function to create a new design
     * @param String $design_name to be given to the design
     * @param String $design_desc to be given as the description to the design.
     * @param String $design_image_path
     */
    public function insertTemplate($name, $desc, $image_path)
    {
        $statement = "INSERT INTO tbl_mst_template(name, description, image_path) values(?, ?, ?)";
        if ($stmt = $this->conn->prepare($statement))
        {
            $stmt->bind_param("sss", $name, $desc, $image_path);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }
    
    public function updateTemplate($id, $name, $desc, $image_path)
    {
        $statement = "UPDATE tbl_mst_template SET name = ?, description = ?, image_path = ? WHERE pk_id = ?";
        if ($stmt = $this->conn->prepare($statement))        
        {
            //echo $statement;
            $stmt->bind_param("sssi", $name, $desc, $image_path, $id);
            $result = $stmt->execute();
            $stmt->close();
        }
        else
        {            
            $error = $this->conn->errno . ' ' . $this->conn->error;
            $result = $error; // 1054 Unknown column 'foo' in 'field list'
        }
        
        
        return $result;
    }
    
    /**
     * Fetching Design
     * @param String $design_id id of the design
     */
    public function getTheme($theme_id = 0)
    {
        $statement = 'SELECT * FROM tbl_mst_theme WHERE status = 1';
        if ($theme_id > 0)
            $statement .= ' AND pk_id = ' . $theme_id;
        
        $stmt = $this->conn->prepare($statement);                
        //$stmt->bind_param("i", $user_id);
        $stmt->execute();
        $designs = $stmt->get_result();
        $stmt->close();
        return $designs;
    }
    
    /**
     * Function to create a new design
     * @param String $design_name to be given to the design
     * @param String $design_desc to be given as the description to the design.
     * @param String $design_image_path
     */
    public function insertTheme($name, $desc, $image_path)
    {
        $statement = "INSERT INTO tbl_mst_theme(name, description, image_path) values(?, ?, ?)";
        if ($stmt = $this->conn->prepare($statement))
        {
            $stmt->bind_param("sss", $name, $desc, $image_path);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }
    
    public function updateTheme($id, $name, $desc, $image_path)
    {
        $statement = "UPDATE tbl_mst_theme SET name = ?, description = ?, image_path = ? WHERE pk_id = ?";
        if ($stmt = $this->conn->prepare($statement))        
        {
            //echo $statement;
            $stmt->bind_param("sssi", $name, $desc, $image_path, $id);
            $result = $stmt->execute();
            $stmt->close();
        }
        else
        {            
            $error = $this->conn->errno . ' ' . $this->conn->error;
            $result = $error; // 1054 Unknown column 'foo' in 'field list'
        }
        
        
        return $result;
    }
}
 
?>