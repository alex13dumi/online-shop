<?php
    session_start();
    require_once "config.php";
    require "functions.php";

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
        header("location: login.php");
        exit;
    }

    function UpdateUser()
    {
        try {
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (empty($_POST['username_client_nou']))
                    throw new Exception('Username can\'t be empty');

                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi
                $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                $sql = 'UPDATE `users` SET `username`=\'' . trim($_POST['username_client_nou']) . '\' WHERE id=' .$_SESSION["id"];
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
        }catch (Exception $e)
        {
            echo '<br></br> Caught exception: '. $e->getMessage();
        }
    }

    function CreateClient()
    {
        try
        {
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                global $name, $phone, $email;
                $name = FormatName($_POST['create_client']);
                $phone = trim($_POST['create_phone']);
                $email = trim($_POST['create_email']);
                $coduser = $_SESSION["id"];

                if (empty($name) or empty($phone) or empty($email)) {
                    throw new Exception('Campul nu trebuie sa fie gol! Va rugam completati cu ceva');
                }
                if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                    throw new Exception('Only letters and white space allowed');
                }
                if (!preg_match("/^(?:(?:(?:00\s?|\+)40\s?|0)(?:7\d{2}\s?\d{3}\s?\d{3}|(21|31)\d{1}\s?\d{3}\s?\d{3}|((2|3)[3-7]\d{1})\s?\d{3}\s?\d{3}|(8|9)0\d{1}\s?\d{3}\s?\d{3}))$/", $phone)) {
                    throw new Exception('Only 10 digit numbers are allowed ! ');
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Invalid email format');
                } else {
                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

                    $sql = 'INSERT INTO `tblClienti` (`numeClient`, `telefonClient`, `emailClient`, `codUser`) VALUES (?,?,?,?)';
                    $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style
                    echo $sql;
                    if (!is_null($mysqli)) {
                        echo 'Success.....' . $mysqli->host_info;
                        echo '<br></br>';
                        echo 'Connected ! Client library version: ' . $mysqli->client_info;
                        echo '<br ></br >';
                        echo 'Server' . $mysqli->server_info;
                    } else {
                        echo "\nCouldn\'t connect to $mysqli->host_info\n";
                    }

                    $stmt = $mysqli->prepare($sql);
                    $stmt->execute([$name, $phone, $email, $coduser]);
                    echo $coduser;

                    if (!$stmt->affected_rows) {
                        throw new Exception('Couldn\'t INSERT into `tblClienti` !');
                    }
                    echo 'Inserted user: ', $name, ' ', $phone, ' ', $email;
                    $stmt->close();
                    $mysqli->close();
                }

            }
        }catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit();
        }
    }

    function SearchClient()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

                $sql = 'SELECT `numeClient`, `telefonClient`, `emailClient`, `pretComanda`, `adresaComanda`, `statusComanda`, `dataPlasareComanda` FROM `tblClienti` JOIN `tblComenzi`' .
                    ' ON `codUser`=`codClient` WHERE `numeClient`=\'' . FormatName($_POST['search_client']) . '\' AND `telefonClient`=\'' . trim($_POST['search_phone']) . '\' AND `codUser`='.$_SESSION['id'].'';

                //`numeClient`=\''.$_POST['search_client'].'\'
                $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style

                if (!is_null($mysqli))
                {
                    echo 'Success.....' . $mysqli->host_info;
                    echo '<br></br>';
                    echo 'Connected !\nClient library version: ' . $mysqli->client_info;
                    echo '<br ></br >';
                    echo 'Server' . $mysqli->server_info;
                } else {
                    echo "\nCouldn\'t connect to $mysqli->host_info\n";
                }

                $result = $mysqli->query($sql);
                if (!$result->num_rows)
                    throw new Exception('Name or telephone doesn\'t exist or order doesn\'t belong to you !');
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
            } catch (Exception $e) {
                echo '<br></br>';
                echo 'Caught exception: ' . $e->getMessage();
                exit();
            }
        }
    }

    if(isset($_POST['CreateClient'])){
        CreateClient();
    }
    if(isset($_POST['UpdateUser']) ){
        UpdateUser();
    }
    if(isset($_POST['SearchClient'])){
        SearchClient();
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
    <h1 class="">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-primary exit-button" style="position: relative; left:700px">Reset Your Password</a>
        <a href="logout.php" class="btn btn-primary exit-button" style="position: relative; left:750px">Sign Out of Your Account</a>
    </p>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?php echo $_SESSION['username'];?></span><span class="text-black-50">edogaru@mail.com.my</span><span> </span></div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>

            <hr>
                <h4 class="text-right">Update client</h4>
                <form method="post" autocomplete="off">
                    <p>
                    <div class="row mt-2">
                        <label for="username_client" class="labels"><b>Current username:</label>
                        <input type="username" class="form-control" name="username_client" id="username_client" value="<?php echo $_SESSION['username'];?>" readonly>
                        <label for="username_client" class="labels"><b>New username:</label>
                        <input type="username" class="form-control" name="username_client_nou" id="username_client_nou" >
                        <br>
                        <div class="text-right">
                            <input type="submit" name="UpdateUser" value="Update" class="btn btn-primary profile-button">
                        </div>
                        </br>
                            <h4 class="text-right">Adauga client</h4>
                            <label class="labels" for="nume"><b>Nume:</label>
                            <input type="username" class="form-control" name="create_client" id="create_client" >
                            <label class="labels" for="nume"><b>Telefon:</label>
                            <input type="username" class="form-control" name="create_phone" id="create_phone" >
                            <label class="labels" for="nume"><b>Email:</label>
                            <input type="username" class="form-control" name="create_email" id="create_email" >
                        <br>
                        <div class="text-right">
                            <input type="submit" name="CreateClient" value="Add" class="btn btn-primary profile-button">
                        </div>
                        </br>

                        <h4 class="text-right">Cauta comanda</h4>
                        <form method="post" autocomplete="off">
                            <p>
                                <label class="labels" for="search_client"><b>Nume complet:</label>
                                <input type="text" class="form-control" name="search_client" id="search_client" style="width: 250px;">
                                <label class="labels" for="search_phone"><b>Nr. telefon:</label>
                                <input type="text" class="form-control" name="search_phone" id="search_phone" style="width: 250px;">
                            </p>
                            <br>
                            <input type="submit" name="SearchClient" value="Cauta" class="btn btn-primary profile-button">
                        </form>
                    </div>
                    <br>
                    </p>
                </form>
            <hr>
            </div>
        </div>
        </div>
        </div>
    </div>
    </div>
    </div>
</body>
</html>

