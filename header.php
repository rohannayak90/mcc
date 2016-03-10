<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Creative Customizer</title>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
 
    <body>
        <header>
            <div class="container" style="clear:none">
                <h1>Creative</h1>
                <nav>
                    <ul>
				        <li><a href="index.php">Home</a></li>
				        <li><a href="register.php">Register</a></li>
				        <li><a href="contact.php">Contact</a></li>
				        <li><a href="blog.php">Blog</a></li>
                        <li><a href="flash/customizer.php">Customizer</a></li>
			         </ul>
                </nav>
            </div>
            
           
            <?php
            $server_folder = "/mcc/";
            $homepage = "index.php";
            $currentpage = $_SERVER['REQUEST_URI'];

            if ($currentpage == $server_folder.$homepage || $currentpage == $server_folder)
            {
                include('slideshow.php');
            }
            ?>
            
            <link rel="stylesheet" type="text/css" href="css/reset.css">
            <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
            <!-- Optional theme
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous"> -->
            <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
                        
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </header>
        