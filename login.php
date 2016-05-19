<?php
include('header.php');
//$api_handler_url = base_url() . 'services/include/APIHandler.php'; /// Not working by using this
require_once 'services/include/APIHandler.php';

$message = 'Login';

if (isset($_SESSION['user_id']))
{
    //echo 'Location: ' . base_url() . 'pages/dashboard.php';
    header('Location: ' . base_url() . 'pages/dashboard.php');    
}
else
{
    //Form submitted
    if (isset($_POST['login']))
    {
        $message = 'Login';
        
        $login_username = $_POST['login_username'];

        /*if (isset($_POST['user_first_name']))
        {
            $message = "My Name is ";
            return;
        }*/
        /*** check if the users is already logged in ***/
        if(isset( $_SESSION['user_id'] ))
        {
            $message = 'User is already logged in';
        }
        /*** check that both the username, password have been submitted ***/
        elseif(!isset( $_POST['login_username'], $_POST['login_password']))
        {
            $message = 'Please enter a valid username and password';
        }
        /*** check the username is the correct length ***/
        elseif (strlen( $_POST['login_username']) > 20 || strlen($_POST['login_username']) < 4)
        {
            $message = 'Incorrect Length for Username';
        }
        /*** check the password is the correct length ***/
        elseif (strlen( $_POST['login_password']) > 20 || strlen($_POST['login_password']) < 4)
        {
            $message = 'Incorrect Length for Password';
        }
        /*** check the username has only alpha numeric characters ***/
        elseif (preg_match('/^[a-zA-Z0-9.@_]*$/', $login_username) != true)
        {
            /*** if there is no match ***/
            $message = "Username must containonly  alphabets, numerals, . or @";
        }
        /*** check the password has only alpha numeric characters **
        elseif (ctype_alnum($_POST['login_password']) != true)
        {
            /*** if there is no match ***
            $message = "Password must be alpha numeric";
        }*/
        else
        {
            /*** if we are here the data is valid and we can insert it into database ***/
            $login_username = filter_var($_POST['login_username'], FILTER_SANITIZE_STRING);
            $login_password = filter_var($_POST['login_password'], FILTER_SANITIZE_STRING);

            $data = [];
            $data['username'] = $login_username;
            $data['password'] = $login_password;

            $result = CallAPI('POST', 'login', $data);

            $result_array = json_decode($result);
            
            if ($result_array)
            {
                if (isset($result_array->error) && $result_array->error == 1)
                {
                    //die('Error Occured - ' . $result_array->message);
                    $message = $result_array->message;
                }
                else
                {
                    $message = $result;
                    /*
                     echo $result_array->message;*/
                    $user_id = $result_array->userID;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['api_key'] = $result_array->apiKey;
                    $message = 'You are now logged in with userID = ' . $_SESSION['user_id'];
                    header('Location: ' . base_url() . 'pages/dashboard.php');
                }
            }
            else
            {
                $message = $result;//'There is some problem while trying to login. Please contact support.';
            }
        } 
    }
    else
    {
        $message = 'Please enter your credentials.';
    }
}

?>
<!-- css for forms -->
<link rel="stylesheet" href="<?php echo base_url() . 'css/forms.css'?>" type="text/css">

<section class="bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top">
                    <h2>Login</h2>
                    <p><?php echo $message; ?></p>
                </div>
                <div class="form-bottom">
                    <form role="form" action="" method="post" class="login-form">                        
                        <div class="form-group">
                            <label class="sr-only" for="form-username">Username</label>
                            <input type="text" name="login_username" placeholder="Username..." class="form-username form-control" id="form-username">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-password">Password</label>
                            <input type="password" name="login_password" placeholder="Password..." class="form-password form-control"
                                   id="form-password">
                        </div>
                        <button type="submit" name="login" class="btn">Sign in!</button>
                        <div>
                            <a href="pages/register.php" style="float:left;">New User?</a>
                            <a href="pages/reset-password.php" style="float:right;">Forgot Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--
<div class="top-content">
    <div class="inner-bg">
        <div class="container">                    
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <h2>Login</h2>
                        <p><?php echo $message; ?></p>
                    </div>
                    <div class="form-bottom">
                        <form role="form" action="" method="post" class="login-form">
                            <div class="form-group styled-input">
                                <input type="text" id="" class="form-control" required="">
                                <label>Author Name</label>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="login_username" placeholder="Username..." class="form-username form-control" id="form-username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="login_password" placeholder="Password..." class="form-password form-control"
                                       id="form-password">
                            </div>
                            <button type="submit" name="login" class="btn">Sign in!</button>
                            <div>
                                <a href="register.php" style="float:left;">New User?</a>
                                <a href="dashboard.php" style="float:right;">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 social-login">
                    <h3>...or login with:</h3>
                    <div class="social-login-buttons">
                        <a class="btn btn-link-1 btn-link-1-facebook" href="#">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a class="btn btn-link-1 btn-link-1-twitter" href="#">
	                       <i class="fa fa-twitter"></i> Twitter
	                    </a>
	                    <a class="btn btn-link-1 btn-link-1-google-plus" href="#">
	                       <i class="fa fa-google-plus"></i> Google Plus
	                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<?php include('footer.php'); ?>