<?php
session_start();
require_once "config.php";
require "functions.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}

$username = $name = $phone = $email = "";
$usernameErr = $nameErr = $phoneErr = $emailErr = $complete_nameErr = $phone_numberErr = $generalErr = "";

function UpdateUser()
{
    global $usernameErr;

    if($_SERVER["REQUEST_METHOD"] != "POST")
        return;

    if (empty(trim($_POST['username_client_nou'])))
    {
        $usernameErr = "Please enter username.";
    }
    else
    {
        $username = trim($_POST['username_client_nou']);
    }
    if (empty($usernameErr))
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi
        $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = 'UPDATE `users` SET `username`=\'' . $username . '\' WHERE id=' . $_SESSION["id"];
        if ($stmt = $mysqli->prepare($sql))
        {
            if ($stmt->execute())
            {
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
        $mysqli->close();
    }
}

function CreateClient()
{
    if($_SERVER["REQUEST_METHOD"] != "POST")
        return;

    global $name, $phone, $email;
    global $generalErr, $nameErr, $phoneErr, $emailErr;

    $name = FormatName($_POST['create_client']);
    $email = trim($_POST['create_email']);
    $phone = trim($_POST['create_phone']);
    $coduser = $_SESSION["id"];

    if (empty($name))
    {
        $nameErr = 'Field is empty !';
    }
    if(empty($phone))
    {
        $phoneErr = 'Field is empty !';
    }
    if(empty($email))
    {
        $emailErr = 'Field is empty !';
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name))
    {
        $nameErr = 'Only letters and white space allowed';
    }
    if (!preg_match("/^(?:(?:(?:00\s?|\+)40\s?|0)(?:7\d{2}\s?\d{3}\s?\d{3}|(21|31)\d{1}\s?\d{3}\s?\d{3}|((2|3)[3-7]\d{1})\s?\d{3}\s?\d{3}|(8|9)0\d{1}\s?\d{3}\s?\d{3}))$/", $phone))
    {
        $phoneErr = 'Only 10 digit numbers are allowed !';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $emailErr = 'Invalid email format';
    }
    if(empty($nameErr) and empty($phoneErr) and empty($emailErr))
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

        $sql = 'INSERT INTO `tblClienti` (`numeClient`, `telefonClient`, `emailClient`, `codUser`) VALUES (?,?,?,?)';
        $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style

        $stmt = $mysqli->prepare($sql);
        $stmt->execute([$name, $phone, $email, $coduser]);

        if (!$stmt->affected_rows)
        {
            $generalErr = 'Couldn\'t INSERT into `tblClienti`!';
        }
        $stmt->close();
        $mysqli->close();
    }
}

function SearchClient()
{
    if($_SERVER["REQUEST_METHOD"] != "POST")
        return;

    global $generalErr, $complete_nameErr, $phone_numberErr;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

    $sql = 'SELECT `numeClient`, `telefonClient`, `emailClient`, `pretComanda`, `adresaComanda`, `statusComanda`, `dataPlasareComanda` FROM `tblClienti` JOIN `tblComenzi`' .
        ' ON `codUser`=`codClient` WHERE `numeClient`=\'' . FormatName($_POST['search_client']) . '\' AND `telefonClient`=\'' . trim($_POST['search_phone']) . '\' AND `codUser`='.$_SESSION['id'].'';
    $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style

    if(empty(FormatName($_POST['search_client'])))
    {
        $complete_nameErr = "Name is empty";
    }
    if(empty(FormatName($_POST['search_phone'])))
    {
        $phone_numberErr = "Phone is empty";
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", FormatName($_POST['search_client'])))
    {
        $complete_nameErr = 'Only letters and white space allowed';
    }
    if (!preg_match("/^(?:(?:(?:00\s?|\+)40\s?|0)(?:7\d{2}\s?\d{3}\s?\d{3}|(21|31)\d{1}\s?\d{3}\s?\d{3}|((2|3)[3-7]\d{1})\s?\d{3}\s?\d{3}|(8|9)0\d{1}\s?\d{3}\s?\d{3}))$/", trim($_POST['search_phone'])))
    {
        $phone_numberErr = 'Only 10 digit numbers are allowed !';
    }
    if(empty($complete_nameErr) and empty($complete_phoneErr) and empty($generalErr))
    {
        $result = $mysqli->query($sql);

        if (!$result->num_rows)
            $generalErr = 'Name or telephone doesn\'t exist or order doesn\'t belong to you !';

        else
        {
            $i=0;
            while ($obj = $result->fetch_object())
            {
                echo'<table class="table table-dark">
                                      <thead class="thead-dark">
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">numeClient</th>
                                          <th scope="col">telefonClient</th>
                                          <th scope="col">emailClient</th>
                                          <th scope="col">pretComanda</th>
                                          <th scope="col">adresaComanda</th>
                                          <th scope="col">statusComanda</th>
                                          <th scope="col">dataPlasareComanda</th>
                                        </tr>
                                      </thead>
                                ';
                echo'
                                      <tbody>
                                        <tr>
                                          <th scope="row">' .$i. '</th>
                                          <td>' .$obj->numeClient. '</td>
                                          <td>' .$obj->telefonClient. '</td>
                                          <td>' .$obj->emailClient. '</td>
                                          <td>' .$obj->pretComanda. '</td>
                                          <td>' .$obj->adresaComanda. '</td>
                                          <td>' .$obj->statusComanda. '</td>
                                          <td>' .$obj->dataPlasareComanda. '</td>
                                        </tr>
                                     </tbody>
                                    </table>
                                ';
                $i++;
            }
        }
        $result->close();
        $mysqli->close();
    }
}

if(isset($_POST['CreateClient'])){
    CreateClient();
}
if(isset($_POST['UpdateUser'])){
    UpdateUser();
}
if(isset($_POST['SearchClient'])){
    SearchClient();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: #ff8900
        }

        h1
        {
            position: relative;
            left: 600px;
            color:white;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ff8900
        }

        .exit-button {
            background: rgb(0, 0, 0);
            box-shadow: none;
            border: none
            position: relative;
            left: 600px;
        }

        .exit-button:hover {
            background: #ff8900
        }

        .exit-button:focus {
            background: #ff8900;
            box-shadow: none
        }

        .exit-button:active {
            background: #ff8900;
            box-shadow: none
        }

        .profile-button {
            background: #ff8900;
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #ff8900
        }

        .profile-button:focus {
            background: #ff8900;
            box-shadow: none
        }

        .profile-button:active {
            background: #ff8900;
            box-shadow: none
        }

        .back:hover {
            color: #ff8900;
            cursor: pointer
        }

        .labels {
            font-size: 18px
        }

        .add-experience:hover {
            background: #ff8900;
            color: #fff;
            cursor: pointer;
            border: solid 1px #ff8900
        }
    </style>
</head>
<body>
<div class="container rounded bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?php echo $_SESSION['username'];?></span><span class="text-black-50"> <?php echo (!empty($generalErr)) ? ' is-invalid' : ''; ?> <?php echo '<b>Created at</b>:<br/>'.$_SESSION['created_at']?></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right <?php echo (!empty($generalErr)) ? ' is-invalid' : ''; ?>">Profile Settings</h4>
                    <br/>
                    <span class="invalid-feedback"><?php echo $generalErr; ?></span>

                </div>
                <h4 class="text-right">Update client</h4>
                <form method="post" autocomplete="off">
                    <div class="form-outline mb-4">
                        <label for="username_client" class="labels col-md-6"><b>Current username:</b></label>
                        <input type="text" class="form-control" name="username_client" id="username_client" value="<?php echo $_SESSION['username'];?>" readonly>

                        <label for="username_client" class="labels col-md-6"><b>New username:</b></label>
                        <input type="text" name="username_client_nou" class="form-control<?php echo (!empty($usernameErr)) ? ' is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $usernameErr; ?></span>
                        <br/>
                        <input type="submit" name="UpdateUser" value="Update" class="btn btn-primary profile-button">
                        <br/>

                        <h4 class="text-right ">Adauga client</h4>
                        <label class="labels col-md-6" for="nume"><b>Nume:</label>
                        <input type="text" class="form-control <?php echo (!empty($nameErr)) ? ' is-invalid' : ''; ?>" name="create_client" id="create_client"/>
                        <span class="invalid-feedback"><?php echo $nameErr; ?></span>

                        <label class="labels col-md-6" for="nume"><b>Telefon:</label>
                        <input type="text" class="form-control <?php echo (!empty($phoneErr)) ? ' is-invalid' : ''; ?>" name="create_phone" id="create_phone"/>
                        <span class="invalid-feedback"><?php echo $phoneErr; ?></span>

                        <label class="labels col-md-6" for="nume"><b>Email:</label>
                        <input type="text" class="form-control <?php echo (!empty($emailErr)) ? ' is-invalid' : ''; ?>" name="create_email" id="create_email"/>
                        <span class="invalid-feedback"><?php echo $emailErr; ?></span>

                        <br/>
                        <input type="submit" name="CreateClient" value="Add" class="btn btn-primary profile-button">
                        <br/>

                        <h4 class="text-right">Cauta comanda</h4>
                        <form method="post" autocomplete="off">
                            <p>
                                <label class="labels col-md-6" for="search_client"><b>Nume complet:</label>
                                <input type="text" class="form-control <?php echo (!empty($complete_nameErr)) ? ' is-invalid' : ''; ?>" name="search_client" id="search_client" style="width: 250px;"/>
                                <span class="invalid-feedback"><?php echo $complete_nameErr; ?></span>

                                <label class="labels col-md-6" for="search_phone"><b>Nr. telefon:</label>
                                <input type="text" class="form-control <?php echo (!empty($phone_numberErr)) ? ' is-invalid' : ''; ?>" name="search_phone" id="search_phone" style="width: 250px;">
                                <span class="invalid-feedback"><?php echo $phone_numberErr; ?></span>

                            </p>
                            <br/>
                            <input type="submit" name="SearchClient" value="Cauta" class="btn btn-primary profile-button"/>
                            <br/><br/>
                            <a href="reset-password.php" class="btn btn-primary exit-button" style="position: relative; left:10px">Reset Your Password</a>
                            <a href="logout.php" class="btn btn-primary exit-button" style="position: relative; left:30px">Sign Out of Your Account</a>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>