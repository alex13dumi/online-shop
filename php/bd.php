<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .error {color: #FF0000;}
    </style>
    <title>
        BD
    </title>
</head>

<body>
<?php
    $nameErr = $emailErr = $phoneErr = "";
    $name = $phone = $email = "";

    if (empty($name))
    {
        $nameErr = "Name is required";
    }
    else
    {
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name))
        {
            $nameErr = "Only characters allowed !";
        }
    }
    if (empty($email))
    {
        $emailErr = "Email is required";
    }
    else
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $emailErr = "Invalid email format";
        }
    }
?>

    <hr>
    <p style="text-align: center;"><b>Sterge client</p>
    <form method="post" autocomplete="off">
        <p>
            <label for="delete_client"><b>Nume complet:</label>
            <input type="text" name="delete_client" id="delete_client" style="width: 250px;">
            <br><br>
        </p>
        <input type="submit" name="DeleteClient" value="Sterge">
    </form>
    <hr>
    


<?php
    require "functions.php";

    function DeleteClient()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

                $sql = 'DELETE FROM `tblClienti` WHERE `numeClient`=\'' . FormatName($_POST['delete_client']) . '\'';
                $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style

                if (!is_null($mysqli)) {
                    echo 'Success.....' . $mysqli->host_info;
                    echo '<br></br>';
                    echo 'Connected !\nClient library version: ' . $mysqli->client_info;
                    echo '<br ></br >';
                    echo 'Server' . $mysqli->server_info;
                } else {
                    echo "\nCouldn\'t connect to $mysqli->host_info\n";
                }

                $stmt = $mysqli->prepare($sql);
                $stmt->execute();

                if (!$stmt->affected_rows) {
                    throw new Exception('Username doesn\'t belong to this DB !');
                }
                echo 'Deleted user: ', FormatName($_POST['delete_client']);
                $stmt->close();
                $mysqli->close();
            } catch (Exception $e) {
                echo '<br></br>';
                echo 'Caught exception: ' . $e->getMessage();
                exit();
            }
        }
    }
    




    if (isset($_POST['DeleteClient'])){
        DeleteClient();
    }


?>

</body>
</html>

