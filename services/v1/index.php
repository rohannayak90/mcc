<?php
 
require_once '../include/DBHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();
 
// User id from db - Global Variable
$user_id = NULL;

$app->get('/', function() {
    $app = \Slim\Slim::getInstance();
    $app->response->setStatus(200);
    echo "Welcome to Slim based API";
});
/*
$app->get('/template', function() {
    $app = \Slim\Slim::getInstance();
    $app->response->setStatus(200);
    echo "HERE to Slim based API";
});*/

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}
 
/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}
 
/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
 
    echo json_encode($response);
}


/**
 * User Registration
 * url - /register
 * method - POST
 * params - name, email, password
 */
$app->post('/register', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('name', 'email', 'username', 'password'));
            
            $response = array();
 
            // reading post params
            $name = $app->request->post('name');
            $email = $app->request->post('email');
            $username = $app->request->post('username');
            $password = $app->request->post('password');
    
            ///echoRespnse(200, $user_first_name);
 
            // validating email address
            validateEmail($email);
 
            $db = new DBHandler();
            $res = $db->createUser($name, $email, $username, $password);
 
            if ($res == USER_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully registered";
                echoRespnse(201, $response);
            } else if ($res == USER_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";
                echoRespnse(200, $response);
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this email already existed";
                echoRespnse(200, $response);
            }
        });

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('username', 'password'));
 
            // reading post params
            $username = $app->request()->post('username');
            $password = $app->request()->post('password');
            $response = array();
 
            $db = new DBHandler();
            // check for correct email and password
            if ($db->checkLogin($username, $password))
            {
                // get the user by email
                $user = $db->getUserByUserName($username);
 
                if ($user != NULL)
                {
                    $response["error"] = false;
                    $response["userID"] = $user['pk_id'];
                    $response['apiKey'] = $user['api_key'];
                    $response['name'] = $user['user_name'];                    
                    $response['email'] = $user['user_email'];
                    $response['createdOn'] = $user['created_on'];
                    $response['modifiedOn'] = $user['modified_on'];
                }
                else
                {
                    // unknown error occurred
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                }
            }
            else
            {
                // user credentials are wrong
                $response['error'] = true;
                $response['message'] = 'Login failed. Incorrect credentials';
            }
 
            echoRespnse(200, $response);
        });

/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    $authorization_header_set = true;
    $api_key = '';
    
    //print_r($headers);
    // There are problems with header and are case-sensitive while they should not be. So please check prior hand.
    if (isset($headers['Authorization']))
        $api_key = $headers['Authorization'];
    else if (isset($headers['authorization']))
        $api_key = $headers['authorization'];
    else
        $authorization_header_set = false;
    
    // Verifying Authorization Header    
    if ($authorization_header_set)
    {
        $db = new DBHandler();
 
        // get the api key
        //$api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key))
        {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        }
        else
        {
            global $user_id;
            // get user primary key id
            $user = $db->getUserId($api_key);
           
            if ($user != NULL)
                $user_id = $user["pk_id"];
        }
    } 
    else
    {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "API key is misssing" . implode(", ", array_map(
            function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
            $headers,
            array_keys($headers)
        ));
        
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Creating new task in db
 * method POST
 * params - name
 * url - /tasks/
 */
$app->post('/tasks', 'authenticate', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('task'));
 
            $response = array();
            $task = $app->request->post('task');
 
            global $user_id;
            $db = new DbHandler();
 
            // creating new task
            $task_id = $db->createTask($user_id, $task);
 
            if ($task_id != NULL) {
                $response["error"] = false;
                $response["message"] = "Task created successfully";
                $response["task_id"] = $task_id;
            } else {
                $response["error"] = true;
                $response["message"] = "Failed to create task. Please try again";
            }
            echoRespnse(201, $response);
        });

/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
$app->get('/tasks', 'authenticate', function() {
            global $user_id;
            $response = array();
            $db = new DbHandler();
 
            // fetching all user tasks
            $result = $db->getAllUserTasks($user_id);
 
            $response["error"] = false;
            $response["tasks"] = array();
 
            // looping through result and preparing tasks array
            while ($task = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["task"] = $task["task"];
                $tmp["status"] = $task["status"];
                $tmp["createdAt"] = $task["created_at"];
                array_push($response["tasks"], $tmp);
            }
 
            echoRespnse(200, $response);
        });

/**
 * Listing single task of particual user
 * method GET
 * url /tasks/:id
 * Will return 404 if the task doesn't belongs to user
 */
$app->get('/tasks/:id', 'authenticate', function($task_id) {
            global $user_id;
            $response = array();
            $db = new DbHandler();
 
            // fetch task
            $result = $db->getTask($task_id, $user_id);
 
            if ($result != NULL) {
                $response["error"] = false;
                $response["id"] = $result["id"];
                $response["task"] = $result["task"];
                $response["status"] = $result["status"];
                $response["createdAt"] = $result["created_at"];
                echoRespnse(200, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
            }
        });

/**
 * Updating existing task
 * method PUT
 * params task, status
 * url - /tasks/:id
 */
$app->put('/tasks/:id', 'authenticate', function($task_id) use($app) {
            // check for required params
            verifyRequiredParams(array('task', 'status'));
 
            global $user_id;            
            $task = $app->request->put('task');
            $status = $app->request->put('status');
 
            $db = new DbHandler();
            $response = array();
 
            // updating task
            $result = $db->updateTask($user_id, $task_id, $task, $status);
            if ($result) {
                // task updated successfully
                $response["error"] = false;
                $response["message"] = "Task updated successfully";
            } else {
                // task failed to update
                $response["error"] = true;
                $response["message"] = "Task failed to update. Please try again!";
            }
            echoRespnse(200, $response);
        });

/**
 * Deleting task. Users can delete only their tasks
 * method DELETE
 * url /tasks
 */
$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
            global $user_id;
 
            $db = new DBHandler();
            $response = array();
            $result = $db->deleteTask($user_id, $task_id);
            if ($result) {
                // task deleted successfully
                $response["error"] = false;
                $response["message"] = "Task deleted succesfully";
            } else {
                // task failed to delete
                $response["error"] = true;
                $response["message"] = "Task failed to delete. Please try again!";
            }
            echoRespnse(200, $response);
        });


/**
 * Listing all users
 * method GET
 * url /tasks          
 */
$app->get('/users', 'authenticate', function()
          {
            global $user_id;
            $response = array();
            $db = new DBHandler();
 
            // fetching all users
            $result = $db->get_all_users($user_id);
 
            $response["error"] = false;
            $response["tasks"] = array();
 
            // looping through result and preparing tasks array
            while ($task = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["task"] = $task["task"];
                $tmp["status"] = $task["status"];
                $tmp["createdAt"] = $task["created_at"];
                array_push($response["tasks"], $tmp);
            }
 
            echoRespnse(200, $response);
        });

/**
 * Fetch Templates
 */
$app->post('/get_template', 'authenticate', function() use($app)
          {
              $response = array();
              $db = new DBHandler();
              
              $templateID = $app->request()->post('template_id');
              // fetching all user tasks
              $result = $db->getTemplate($templateID);
              
              $response["error"] = false;
              $response["templates"] = array();
              
              // looping through result and preparing tasks array
              while ($design = $result->fetch_assoc())
              {
                  $tmp = array();
                  $tmp["id"] = $design["pk_id"];
                  $tmp["name"] = $design["name"];
                  $tmp["description"] = $design["description"];
                  $tmp["image_path"] = $design["image_path"];
                  $tmp["status"] = $design["status"];
                  
                  array_push($response["templates"], $tmp);
              }
              
              echoRespnse(200, $response);
          });

/**
 * Save Template
 */
$app->post('/post_template', 'authenticate', function() use($app)
           {
               $response["message"] = "Started verification";
               // check for required params
               verifyRequiredParams(array('template_id', 'template_name', 'template_description', 'image_path'));
               $response["message"] .= "verification complete";
               $response = array();
               $template_id = $app->request->put('template_id');
               $template_name = $app->request->put('template_name');
               $template_description = $app->request->put('template_description');
               $template_image_path = $app->request->put('image_path');

               $db = new DBHandler();

               if ($template_id > 0)
               {
                   $result = $db->updateTemplate($template_id, $templatename, $template_description, $template_image_path); 
                   //$message = $design_id . ' - ' . $design_name . ' - ' . $result;                   
               }
               else
               {
                   // creating new task
                   //$design_id = $db->insertDesign($design_id, $design);
                   $result = $db->insertTemplate($template_name, $template_description, $template_image_path);
               }

               if ($result != NULL)
               {
                   $response["error"] = false;
                   $response["message"] = "Design created successfully";
                   $response["result"] = $result;
               }
               else
               {
                   $response["error"] = true;
                   $response["message"] = $message . "Failed to create design. Please try again";
               }
               echoRespnse(201, $response);
           });


/**
 * Fetch Template Size
 */
$app->get('/template_size', 'authenticate', function() use ($app)
{
    ///global $user_id;
    $response = array();
    $db = new DBHandler();

    $templateID = $app->request()->get('template_id');
    // fetching all user tasks
    $result = $db->getTemplateSize($templateID);

    $response["error"] = false;
    $response["template_sizes"] = array();

    // looping through result and preparing tasks array
    while ($design = $result->fetch_assoc())
    {
        $tmp = array();
        $tmp["id"] = $design["pk_id"];
        $tmp["name"] = $design["name"];
        $tmp["description"] = $design["description"];
        $tmp["width"] = $design["width"];
        $tmp["height"] = $design["height"];
        $tmp["image_path"] = $design["image_path"];
        $tmp["status"] = $design["status"];

        array_push($response["template_sizes"], $tmp);
    }

    echoRespnse(200, $response);
});

/**
 * Save Template
*/
$app->post('/template_size', 'authenticate',  function() use($app)
{
    $response["message"] = "Started verification";
    // check for required params
    verifyRequiredParams(array(
                        'template_size_id',
                        'template_size_name',
                        'template_size_description',
                        'template_size_width',
                        'template_size_height',
                        'image_path'
                    ));
    $response["message"] .= "verification complete";
    $response = array();
    $id = $app->request->put('template_size_id');
    $name = $app->request->put('template_size_name');
    $description = $app->request->put('template_size_description');
    $width = $app->request->put('template_size_width');
    $height = $app->request->put('template_size_height');
    $image_path = $app->request->put('image_path');

    $db = new DBHandler();

    if ($id > 0)
    {
        $result = $db->updateTemplateSize($id, $name, $description, $width, $height, $image_path);
    }
    else
    { 
        $result = $db->insertTemplateSize($name, $description, $width, $height, $image_path);
    }

    if ($result != NULL)
    {
        $response["error"] = false;
        $response["message"] = "Template Size created successfully";
        $response["result"] = $result;
    }
    else
    {
        $response["error"] = true;
        $response["message"] = $message . "Failed to create design. Please try again";
    }
    echoRespnse(201, $response);
});

/**
 * Fetch Theme
 */
$app->get('/theme', 'authenticate', function() use ($app)
          {
              ///global $user_id;
              $response = array();
              $db = new DBHandler();
              
              $themeID = $app->request()->get('theme_id');
              // fetching all user tasks
              $result = $db->getTheme($themeID);
              
              $response["error"] = false;
              $response["themes"] = array();
              
              // looping through result and preparing tasks array
              while ($theme = $result->fetch_assoc())
              {
                  $tmp = array();
                  $tmp["id"] = $theme["pk_id"];
                  $tmp["name"] = $theme["name"];
                  $tmp["description"] = $theme["description"];
                  $tmp["image_path"] = $theme["image_path"];
                  $tmp["status"] = $theme["status"];
                  
                  array_push($response["themes"], $tmp);
              }
              
              echoRespnse(200, $response);
          });
 
/**
 * Save Theme
 */
$app->post('/theme', 'authenticate',  function() use($app)
           {
               $response["message"] = "Started verification";
                // check for required params
                verifyRequiredParams(array('theme_id', 'theme_name', 'theme_description', 'image_path'));
                $response["message"] .= "verification complete";
                $response = array();
                $theme_id = $app->request->put('theme_id');
                $theme_name = $app->request->put('theme_name');
                $theme_description = $app->request->put('theme_description');
                $theme_image_path = $app->request->put('image_path');

                $db = new DBHandler();

                if ($theme_id > 0)
                {
                    $result = $db->updateTheme($theme_id, $theme_name, $theme_description, $theme_image_path); 
                    //$message = $design_id . ' - ' . $design_name . ' - ' . $result;                   
                }
                else
                {
                    // creating new task
                    //$design_id = $db->insertDesign($design_id, $design);
                    $result = $db->insertTheme($theme_name, $theme_description, $theme_image_path);
                }

                if ($result != NULL)
                {
                    $response["error"] = false;
                    $response["message"] = "Design created successfully";
                    $response["result"] = $result;
                }
                else
                {
                    $response["error"] = true;
                    $response["message"] = $message . "Failed to create design. Please try again";
                }
                echoRespnse(201, $response);
           });

$app->get('/module', 'authenticate', function()
          {
              global $user_id;
              
              $db = new DBHandler();
              $result = $db->getAllModules();
              //$message = $user_id;
              
              if ($result != NULL)
              {
                  $response["error"] = false;
                  $response["message"] = "Module fetched successfully";
                  $response["modules"] = array();
                  
                  // looping through result and preparing tasks array
                  while ($map_item = $result->fetch_assoc())
                  {
                      $item = array();
                      $item["id"] = $map_item["pk_id"];
                      $item["name"] = $map_item["name"];
                      $item["description"] = $map_item["description"];
                      $item["image_path"] = $map_item["image_path"];
                      $item["fa_icon"] = $map_item["fa_icon"];
                      $item["link"] = $map_item["link"];
                      
                      array_push($response["modules"], $item);
                  }
              }
              else
              {
                  $response["error"] = true;
                  $response["message"] = $message . " Failed to fetch modules. Please try again";
              }
              echoRespnse(201, $response);
          });

$app->get('/map_user_module', 'authenticate', function()
          {
              global $user_id;
              
              $db = new DBHandler();
              $result = $db->getUserModules($user_id);
              $message = $user_id;
              
              if ($result != NULL)
              {
                  $response["error"] = false;
                  $response["message"] = "Design created successfully";
                  $response["user_modules"] = array();
                  
                  // looping through result and preparing tasks array
                  while ($map_item = $result->fetch_assoc())
                  {
                      $item = array();
                      $item["id"] = $map_item["pk_id"];
                      $item["name"] = $map_item["name"];
                      $item["description"] = $map_item["description"];
                      $item["image_path"] = $map_item["image_path"];
                      $item["fa_icon"] = $map_item["fa_icon"];
                      $item["link"] = $map_item["link"];
                      array_push($response["user_modules"], $item);
                  }
              }
              else
              {
                  $response["error"] = true;
                  $response["message"] = $message . " Failed to fetch modules. Please try again";
              }
              echoRespnse(201, $response);
          });


$app->run();


?>