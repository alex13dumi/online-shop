<?php
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    require_once "config.php";
    $mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($mysqli === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $new_password = $confirm_password = "";
    $new_password_err = $confirm_password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {

        if(empty(trim($_POST["new_password"])))
        {
            $new_password_err = "Please enter the new password.";
        }
        elseif(strlen(trim($_POST["new_password"])) < 6)
        {
            $new_password_err = "Password must have atleast 6 characters.";
        }
        else
        {
            $new_password = trim($_POST["new_password"]);
        }

        if(empty(trim($_POST["confirm_password"])))
        {
            $confirm_password_err = "Please confirm the password.";
        }
        else
        {
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($new_password_err) && ($new_password != $confirm_password))
            {
                $confirm_password_err = "Password did not match.";
            }
        }

        if(empty($new_password_err) && empty($confirm_password_err))
        {
            $sql = "UPDATE users SET password = ? WHERE id = ?";

            if($stmt = $mysqli->prepare($sql))
            {
                $stmt->bind_param("si", $param_password, $param_id);

                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_id = $_SESSION["id"];

                if($stmt->execute()){
                    session_destroy();
                    header("location: login.php");
                    exit();
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
        <title>Reset Password</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">        <style>
            body{ font: 14px sans-serif; }
            .wrapper{ width: 360px; padding: 20px; }
        </style>
    </head>
    <body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>
    </body>
</html>