<?php include('../header.php'); ?>
<div class="container" style="display: none;">
<?php
if( isset( $_SESSION['user_id'] ) )
    { ?>
    <h3>Logout Here</h3>
        <p><a href="logout.php">Log Out Link </p>
    <?php
    }
    else {
    ?>
        <h4>Login Here</h4>
        <form action="login_submit.php" method="post">
            <fieldset>
                <p>
                    <label for="phpro_username">Username</label>
                    <input type="text" id="phpro_username" name="phpro_username" value="" maxlength="20" />
                </p>
                <p>
                    <label for="phpro_password">Password</label>
                    <input type="text" id="phpro_password" name="phpro_password" value="" maxlength="20" />
                </p>
                <p>
                    <input type="submit" value="→ Login" />
                </p>
            </fieldset>
        </form>
        <?php
    }
?>
</div>
<?php
$message = 'basic';
//Form submitted
if (isset($_POST['submit']))
{
    $login_username = $_POST['login_username'];
    
    if (isset($_POST['user_first_name']))
    {
        $message = "My Name is ";
        return;
    }
    /*** check if the users is already logged in ***
    if(isset( $_SESSION['user_id'] ))
    {
        $message = 'Users is already logged in';
    }
    /*** check that both the username, password have been submitted ***
    if(!isset( $_POST['login_username'], $_POST['login_password']))
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
    /*** check the password has only alpha numeric characters ***/
    elseif (ctype_alnum($_POST['login_password']) != true)
    {
            /*** if there is no match ***/
            $message = "Password must be alpha numeric";
    }
    else
    {
        /*** if we are here the data is valid and we can insert it into database ***/
        $login_username = filter_var($_POST['login_username'], FILTER_SANITIZE_STRING);
        $login_password = filter_var($_POST['login_password'], FILTER_SANITIZE_STRING);

        /*** now we can encrypt the password ***/
        $login_password = sha1( $login_password );

        /*** connect to database ***/
        /*** mysql hostname ***/
        $mysql_hostname = 'localhost';

        /*** mysql username ***/
        $mysql_username = 'root';

        /*** mysql password ***/
        $mysql_password = '';

        /*** database name ***/
        $mysql_dbname = 'mcc';

        try
        {
            $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
            /*** $message = a message saying we have connected ***/

            /*** set the error mode to excptions ***/
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*** prepare the select statement ***/
            $stmt = $dbh->prepare("SELECT login_user_id, login_username, login_password FROM tbl_mst_users 
                        WHERE login_username = :login_username AND login_password = :login_password");

            /*** bind the parameters ***/
            $stmt->bindParam(':login_username', $login_username, PDO::PARAM_STR);
            $stmt->bindParam(':login_password', $login_password, PDO::PARAM_STR, 40);

            /*** execute the prepared statement ***/
            $stmt->execute();

            /*** check for a result ***/
            $user_id = $stmt->fetchColumn();

            /*** if we have no result then fail boat ***/
            if($user_id == false)
            {
                    $message = 'Login Failed';
            }
            /*** if we do have a result, all is well ***/
            else
            {
                    /*** set the session user_id variable ***/
                    $_SESSION['user_id'] = $user_id;

                    /*** tell the user we are logged in ***/
                    $message = 'You are now logged in';
            }
        }
        catch(Exception $e)
        {
            /*** if we are here, something has gone wrong with the database ***/
            $message = 'We are unable to process your request. Please try again later"';
        }
    } 
}
else if (isset($_POST['register']))
{
    $message = 'Register';
}
?>
<div  style="background: #F7F7F7;">
    <div class="container">
        <div class="form">      
            <ul class="tab-group">
                <li class="tab active"><a href="#login">Log In</a></li>
                <li class="tab"><a href="#signup">Sign Up</a></li>
            </ul>      
            <div class="tab-content">
                <div id="login">   
                    <h3>Welcome Back!</h3>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email"required name="login_username" autocomplete="off"/>
                        </div>                
                        <div class="field-wrap">
                            <label>
                                Password<span class="req">*</span>
                            </label>
                            <input type="password"required name="login_password" autocomplete="off"/>
                        </div>
                        <p style="color: #FF6565; "><?php echo $message; ?></p>
                        <p class="forgot"><a href="#">Forgot Password?</a></p>
                        <p><input type="submit" name="submit" value="Log In" /></p>
                        <!--<button value="submit" class="button button-block"/></button>-->
                    </form>
                </div>
                <div id="signup">   
                    <h3>Sign Up for Free</h3>          
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="top-row">
                            <div class="field-wrap">
                                <label>
                                    First Name<span class="req">*</span>
                                </label>
                                <input type="text" required name="user_first_name" autocomplete="off" />
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Last Name<span class="req">*</span>
                                </label>
                                <input type="text"required name="user_last_name" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email"required autocomplete="off"/>
                        </div>
                        <div class="field-wrap">
                            <label>
                                Set A Password<span class="req">*</span>
                            </label>
                            <input type="password"required autocomplete="off"/>
                        </div>
                        <button type="submit" name="register" class="button button-block"/>Get Started</button>
                    </form>
                </div>
            </div><!-- tab-content -->      
        </div> <!-- /form -->
    </div>
</div>
<style>

    *, *:before, *:after {
      box-sizing: border-box;
    }

    html {
      overflow-y: scroll;
    }

    /*body {
      background: #c1bdba;
      font-family: 'Titillium Web', sans-serif;
    }*/

    a {
      text-decoration: none;
      color: #1ab188;
      -webkit-transition: .5s ease;
      transition: .5s ease;
    }
    a:hover {
      color: #179b77;
    }

    .form {
      background: rgba(19, 35, 47, 0.9);
      padding: 40px;
      max-width: 600px;
      margin: 40px auto;
      border-radius: 4px;
      box-shadow: 0 4px 10px 4px rgba(19, 35, 47, 0.3);
    }

    .tab-group {
      list-style: none;
      padding: 0;
      margin: 0 0 20px 0;
    }
    .tab-group:after {
      content: "";
      display: table;
      clear: both;
    }
    .tab-group li a {
      display: block;
      text-decoration: none;
      padding: 15px;
      background: rgba(160, 179, 176, 0.25);
      color: #a0b3b0;
      font-size: 20px;
      float: left;
      width: 50%;
      text-align: center;
      cursor: pointer;
      -webkit-transition: .5s ease;
      transition: .5s ease;
    }
    .tab-group li a:hover {
      background: #179b77;
      color: #ffffff;
    }
    .tab-group .active a {
      background: #1ab188;
      color: #ffffff;
    }

    .tab-content > div:last-child {
      display: none;
    }

    h3 {
      text-align: center;
      color: #ffffff;
      font-weight: 300;
      margin: 0 0 20px;
    }

    label {
      position: absolute;
      -webkit-transform: translateY(6px);
              transform: translateY(6px);
      left: 13px;
      color: rgba(255, 255, 255, 0.5);
      -webkit-transition: all 0.25s ease;
      transition: all 0.25s ease;
      -webkit-backface-visibility: hidden;
      pointer-events: none;
      font-size: 22px;
    }
    label .req {
      margin: 2px;
      color: #1ab188;
    }

    label.active {
      -webkit-transform: translateY(50px);
              transform: translateY(50px);
      left: 2px;
      font-size: 14px;
    }
    label.active .req {
      opacity: 0;
    }

    label.highlight {
      color: #ffffff;
    }

    input, textarea {
      font-size: 22px;
      display: block;
      width: 100%;
      height: 100%;
      padding: 5px 10px;
      background: none;
      background-image: none;
      border: 1px solid #a0b3b0;
      color: #ffffff;
      border-radius: 0;
      -webkit-transition: border-color .25s ease, box-shadow .25s ease;
      transition: border-color .25s ease, box-shadow .25s ease;
    }
    input:focus, textarea:focus {
      outline: 0;
      border-color: #1ab188;
    }

    textarea {
      border: 2px solid #a0b3b0;
      resize: vertical;
    }

    .field-wrap {
      position: relative;
      margin-bottom: 40px;
    }

    .top-row:after {
      content: "";
      display: table;
      clear: both;
    }
    .top-row > div {
      float: left;
      width: 48%;
      margin-right: 4%;
    }
    .top-row > div:last-child {
      margin: 0;
    }

    .button {
      border: 0;
      outline: none;
      border-radius: 0;
      padding: 15px 0;  
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .1em;
      background: #1ab188;
      color: #ffffff;
      -webkit-transition: all 0.5s ease;
      transition: all 0.5s ease;
      -webkit-appearance: none;
    }
    .button:hover, .button:focus {
      background: #179b77;
    }

    .button-block {
      display: block;
      width: 100%;
    }

    .forgot {
      margin-top: -30px;
      text-align: right;
    }

</style>

<script>
    $('.form').find('input, textarea').on('keyup blur focus', function (e) {
        
        var $this = $(this), label = $this.prev('label');
        if (e.type === 'keyup')
        {
            if ($this.val() === '')
            {
                label.removeClass('active highlight');
            }
            else
            {
                label.addClass('active highlight');
            }
        }
        else if (e.type === 'blur')
        {
            if( $this.val() === '' )
            {
                label.removeClass('active highlight'); 
            }
            else
            {
                label.removeClass('highlight');   
			}
        }
        else if (e.type === 'focus')
        {
            if( $this.val() === '' )
            {
                label.removeClass('highlight'); 
			}
            else if( $this.val() !== '' )
            {
                label.addClass('highlight');
			}
        }

    });

    $('.tab a').on('click', function (e) {
        
        e.preventDefault();
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        
        target = $(this).attr('href');
        
        $('.tab-content > div').not(target).hide();
        
        $(target).fadeIn(600);
    });
</script>

<?php include('../footer.php');