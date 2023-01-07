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
    <p style="text-align: center;"><b>Adauga client</p>
    <form method="post" autocomplete="off">
        <p>
            <label for="create_client"><b>Nume complet:</label>
            <span class="error">* <?php echo $nameErr;?></span>
            <input type="text" name="create_client" id="create_client" style="width: 250px;" value="<?php echo $GLOBALS['name'];?>">
            <br><br>
            <label for="create_phone"><b>Numar telefon:</label>
            <input type="tel" id="create_phone" name="create_phone" value="<?php echo $GLOBALS['phone'];?>">
            <br><br>
            <label for="create_email"><b>Email:</label>
            <span class="error">* <?php echo $emailErr;?></span>
            <input type="text" name="create_email" id="create_email" style="width: 350px;" value="<?php echo $GLOBALS['email'];?>">
            <br><br>
        </p>
        <input type="submit" name="CreateClient" value="Adauga">
    </form>
    <hr>
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
    
    <hr>
    <p style="text-align: center;"><b>Cauta comanda</p>
    <form method="post" autocomplete="off">
        <p>
            <label for="search_client"><b>Nume complet:</label>
            <input type="text" name="search_client" id="search_client" style="width: 250px;">
            <br><br>
            <label for="search_phone"><b>Nr. telefon:</label>
            <input type="text" name="search_phone" id="search_phone" style="width: 250px;">
            <br><br>
        </p>
        <input type="submit" name="SearchClient" value="Cauta">
    </form>
    <hr>

<?php
    require "functions.php";
    function CreateClient()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            global $name, $phone, $email;
            $name = FormatName($_POST['create_client']);
            $phone = trim($_POST['create_phone']);
            $email = trim($_POST['create_email']);

            try {
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

                    $sql = 'INSERT INTO `tblClienti` (`numeClient`, `telefonClient`, `emailClient`) VALUES (?,?,?)';
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
                    $stmt->execute([$name, $phone, $email]);

                    if (!$stmt->affected_rows) {
                        throw new Exception('Couldn\'t INSERT into `tblClienti` !');
                    }
                    echo 'Inserted user: ', $name, ' ', $phone, ' ', $email;
                    $stmt->close();
                    $mysqli->close();
                }

            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";
                exit();
            }
        }
    }
    
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
    
    function SearchClient()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

                $sql = 'SELECT `numeClient`, `telefonClient`, `emailClient`, `pretComanda`, `adresaComanda`, `statusComanda`, `dataPlasareComanda` FROM `tblClienti` JOIN `tblComenzi`' .
                    ' ON `idClient`=`codClient` WHERE `numeClient`=\'' . FormatName($_POST['search_client']) . '\' AND `telefonClient`=\'' . trim($_POST['search_phone']) . '\'';

                //`numeClient`=\''.$_POST['search_client'].'\'
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

                $result = $mysqli->query($sql);
                if (!$result->num_rows)
                    throw new Exception('Name or telephone doesn\'t exist');
                else
                {
                    $i=0;
                    while ($obj = $result->fetch_object())
                    {
		
                        echo'
                        <table class="table table-dark">
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
    
    if (isset($_POST['CreateClient'])){
        CreateClient();
    }
    if (isset($_POST['DeleteClient'])){
        DeleteClient();
    }
    if(isset($_POST['SearchClient'])){
        SearchClient();
    }

?>

</body>
</html>

