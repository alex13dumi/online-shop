<?php
    session_start();
    require_once "config.php";

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    function UpdateUser()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi
        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


    }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Welcome</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <style>
            body{ font: 14px sans-serif; text-align: center; }
        </style>
    </head>
    <body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>

    <hr>
    <center>
        <p style="text-align: center;"><b>Update client</p>
        <form method="post" autocomplete="off">
            <p>
            <div class="form-group w-25">
                <label for="username_client"><b>Current username:</label>
                <input type="username" class="form-control" name="username_client" id="username_client" value="<?php echo $_SESSION['username'], $_SESSION["id"];?>" readonly>
                <label for="parola_client"><b>New password:</label>
                <input type="password" class="form-control" name="parola_client" id="parola_client" value="<?php echo $GLOBALS['name'];?>">
                <label for="nume_client"><b>Nume complet:</label>
                <input type="name" class="form-control" name="nume_client" id="nume_client" value="<?php echo $GLOBALS['name'];?>">
                <label for="telefon_client"><b>Numar telefon:</label>
                <input type="phone" class="form-control" id="telefon_client"  name="telefon_client" value="<?php echo $GLOBALS['name'];?>">
                <label for="email_client"><b>Email:</label>
                <input type="email" class="form-control" id="email_client" value="<?php echo $GLOBALS['email'];?>">
            </div>
            <br>
            </p>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-info" name="UpdateUser">Update</button>
            </div>
        </form>
    </center>
    <hr>

    </body>
</html>