<?php
    require_once "config.php";

    $mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($mysqli === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $username = $password = $confirm_password = "";
    $usernameErr = $passwordErr = $confirm_passwordErr = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty(trim($_POST["username"])))
        {
            $usernameErr = "Please enter a username.";
        }
        elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"])))
        {
            $usernameErr = "Username can only contain letters, numbers, and underscores.";
        }
        else
        {
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = $mysqli->prepare($sql))
            {
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                $param_username = trim($_POST["username"]);

                if($stmt->execute())
                {
                    $stmt->store_result();
                    
                    if($stmt->num_rows() == 1)
                    {
                        $usernameErr = "This username is already taken.";
                    }
                    else
                    {
                        $username = trim($_POST["username"]);
                    }
                }
                else
                {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }

        if(empty(trim($_POST["password"])))
        {
            $passwordErr = "Please enter a password.";
        }
        elseif(strlen(trim($_POST["password"])) < 6)
        {
            $passwordErr = "Password must have at least 6 characters.";
        }
        else
        {
            $password = trim($_POST["password"]);
        }

        if(empty(trim($_POST["confirm_password"])))
        {
            $confirm_passwordErr = "Please confirm password.";
        }
        else
        {
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($passwordErr) && ($password != $confirm_password))
            {
                $confirm_passwordErr = "Password did not match.";
            }
        }

        if(empty($usernameErr) && empty($passwordErr) && empty($confirm_passwordErr))
        {
            $sql = "INSERT INTO `users` (`username`, `password`, `client_code`) VALUES (?, ?, 0)";

            if($stmt = $mysqli->prepare($sql))
            {
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                if($stmt->execute())
                {
                    header("location: login.php");
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
        <title>Sign Up</title>
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

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="form-outline mb-4">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control <?php echo (!empty($usernameErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                            <span class="invalid-feedback"><?php echo $usernameErr; ?></span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label>Password</label>
                                            <input type="password" name="password" class="form-control <?php echo (!empty($passwordErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                            <span class="invalid-feedback"><?php echo $passwordErr; ?></span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label>Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_passwordErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                            <span class="invalid-feedback"><?php echo $confirm_passwordErr; ?></span>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" value="Submit">
                                            <input type="reset" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" value="Reset">
                                        </div>

                                    </form>
                                <p>Already have an account? <a href="login.php">Login here</a>.</p>
                                </div>
                            </div>

                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">We are more than just a company</h4>
                                    <p class="small mb-0">Oferim o gam?? larg?? de echipamente ??i accesorii sportive pentru diverse sporturi ??i activit????i.
                                        Indiferent dac?? sunte??i un atlet experimentat sau ??ncep??tor, avem ceva pentru toat?? lumea.
                                        Selec??ia noastr?? include de la mingi de baschet ??i fotbal p??n?? la pantofi de alergare ??i m??turi de yoga.
                                        De asemenea, avem o varietate de echipamente pentru exterior, cum ar fi corturi de camping ??i rucsacuri de drume??ie.
                                        Ne m??ndrim cu oferirea de produse de ??nalt?? calitate la pre??uri competitive ??i echipa noastr?? prietenoas?? de servicii pentru clien??i este ??ntotdeauna aici pentru a v?? ajuta s?? g??si??i exact ceea ce ave??i nevoie.
                                        V?? mul??umim c?? a??i ales magazinul nostru pentru toate nevoile dvs. de articole sportive!</p>
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

