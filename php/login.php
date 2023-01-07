<?php
    session_start();
    
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
    {
        header("location: ../index.php");
        exit;
    }
    
    require_once "config.php";

    $mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($mysqli === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    $username = $password = "";
    $usernameErr = $passwordErr = $loginErr = "";
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty(trim($_POST["username"])))
        {
            $usernameErr = "Please enter username.";
        }
        else
        {
            $username = trim($_POST["username"]);
        }

        if(empty(trim($_POST["password"])))
        {
            $passwordErr = "Please enter your password.";
        }
        else
        {
            $password = trim($_POST["password"]);
        }

        if(empty($usernameErr) && empty($passwordErr))
        {
            $sql = "SELECT id, username, password FROM users WHERE username = ?";

            if($stmt = $mysqli->prepare($sql))
            {
                $stmt->bind_param("s", $param_username);
                $param_username = $username;

                if($stmt->execute())
                {
                    $stmt->store_result();

                    if($stmt->num_rows == 1)
                    {
                        $stmt->bind_result($id, $username, $hashed_password);
                        if($stmt->fetch())
                        {
                            if(password_verify($password, $hashed_password))
                            {
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                header("location: ../index.php");
                            }
                            else
                            {
                                $loginErr = "Invalid username or password.";
                            }
                        }
                    }
                    else
                    {
                        $loginErr = "Invalid username or password.";
                    }
                }
                else
                {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
        $mysqli->close();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body{ font: 14px sans-serif; }
            .wrapper{ width: 360px; padding: 20px; }
        </style>
    </head>
    <body>
    <center>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if(!empty($loginErr))
        {
            echo '<div class="alert alert-danger">' . $loginErr . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($usernameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $usernameErr; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
    </body>
    </center>
</html>
