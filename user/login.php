<html>
    <head>
        <title>Login</title>
    </head>

    <body>
        <?php if( isset( $_SESSION['user_id'] ) )
        { ?>
        <h2>Logout Here</h2>
            <p><a href="logout.php">Log Out Link </p>
        <?php }
        else { ?>
            <h2>Login Here</h2>
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
        <?php } ?>
    </body>
</html>