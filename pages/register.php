<?php
include('../header.php');

require_once '../services/include/APIHandler.php';

$message = 'First Message';

if (isset($_SESSION['user_id']))
{
    header('Location: ' . base_url() . 'pages/dashboard.php?userID=' . $_SESSION['user_id']);    
}
else
{
    $message = 'Registering';
    if (isset($_POST['register']))
    {
        $message = 'Register';
        /*** if we are here the data is valid and we can insert it into database ***/
        $name = filter_var($_POST['form_user_name'], FILTER_SANITIZE_STRING);        
        $email = filter_var($_POST['form_email_id'], FILTER_SANITIZE_STRING);
        $login_username = filter_var($_POST['form_email_id'], FILTER_SANITIZE_STRING);
        $login_password = filter_var($_POST['form_password'], FILTER_SANITIZE_STRING);
        
        $data = [];
        $data['name'] = $name;
        $data['email'] = $email;
        $data['username'] = $login_username;
        $data['password'] = $login_password;
        
        $result = CallAPI('POST', 'register', $data);
        $result_array = json_decode($result);
        
        if (isset($result_array->error) && $result_array->error == 1)
        {
            //die('Error Occured - ' . $result_array->message);
            $message = $result_array->message;
        }
        else
        {
            $message = $result;
            //echo $result_array->message;
            header('Location: ' . base_url() . 'pages/dashboard.php');
        }
    }
    else
    {
        $message = 'Please fill in all the fields';
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
                    <h2>Register</h2>
                    <p><?php echo $message; ?></p>
                </div>
                <div class="form-bottom">
                    <form role="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" class="login-form">
                        <div class="form-group">
                            <label class="sr-only" for="form-user-name">First Name</label>
                            <input type="text" name="form_user_name" placeholder="Your Name..." class="form-control"/>
                            <!-- The above one is simplified
                            <input type="text" name="form-username" placeholder="First Name..." class="form-username form-control" id="form-username">-->
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-email-id">eMail ID</label>
                            <input type="email" name="form_email_id" placeholder="Your eMail..." class="form-password form-control" id="form-password">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-password">Password</label>
                            <input type="password" name="form_password" placeholder="Your Password..." class="form-password form-control" id="form-password">
                        </div>
                        <button type="submit" name="register" class="btn">TAKE ME IN</button>
                        <div>
                            <a href="login.php" style="float:left;">Already Registered?</a>
                            <a href="reset-password.php" style="float:right;">Forgot Password?</a>
                        </div>
                    </form>                        
                </div>
            </div>                        
        </div>                    
    </div>
</section>

<?php include('../footer.php'); ?>