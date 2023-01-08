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

                            $sql="UPDATE `users` SET `client_code`='.$id.' WHERE `username`='.$username.'";
                            echo $sql;
                            $result = $mysqli->query($sql);
                            printf("Select returned %d rows.\n", $result->num_rows);
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
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;
            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ffae00, #ff9100, #ffb700, #ff8800);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #be7200, #ffae00, #ffb700, #ec8600);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }
        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style>
</head>
<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img src="../img/sports-wear.png"
                                         style="width: 320px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">We are The Sports Team</h4>
                                </div>


                                <?php
                                if(!empty($loginErr))
                                {
                                    echo '<div class="alert alert-danger">' . $loginErr . '</div>';
                                }
                                ?>

                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <p>Please fill in your credentials to login.</p>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control <?php echo (!empty($usernameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                        <span class="invalid-feedback"><?php echo $usernameErr; ?></span>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>">
                                        <span class="invalid-feedback"><?php echo $passwordErr; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" value="Login">
                                        <input type="reset" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" value="Reset">
                                    </div>
                                </form>
                                <p>Don't have an account? <a href="register.php" class="btn btn-outline-danger">Sign up</a></p>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">We are more than just a company</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
</section>
</body>
</html>
