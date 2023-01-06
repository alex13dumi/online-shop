<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Locker Control</title>
    <div style="min-height: 80px">
        <table style="min-width: 100%;"><tr>
                <td><form method="post" style="text-align: right;"><input type="submit" name="start_refresh" value="Vestiare" onclick="switchTo_vestiare();" /></form></td>
                <td style="height: 20;"><form method="post" style="text-align: left;"><input type="submit" name="stop_refresh" value="Manager clienti" onclick="switchTo_manager_clienti();" /></form></td>
            </tr></table>


        <table style="min-width: 20%; float: right;"><tr>
                <td><form method="post" style="text-align: right;"><input type="submit" name="aloca_bratara_provizorie" value="Aloca" onclick="aloca_bratara_provizorie();" /><br><input style="width: 120px; text-align: center;" type="text" name="aloca_bratara_provizorie" id="aloca_bratara_provizorie" value="COD BRATARA" onClick="SelectAll('aloca_bratara_provizorie')">
                    </form></td>

                <td style="height: 20;"><form method="post" style="text-align: left;"><input type="submit" name="sterge_bratara_provizorie" value="Sterge" onclick="sterge_bratara_provizorie();" /><br><input style="width: 120px; text-align: center;" type="text" name="sterge_bratara_provizorie" id="sterge_bratara_provizorie" value="COD BRATARA" onClick="SelectAll('sterge_bratara_provizorie')"></form></td>

                <td style="height: 20;"><form method="post" style="text-align: left;"><input type="submit" name="gaseste_bratara_provizorie" value="Cauta" onclick="gaseste_bratara_provizorie();" /><br><input style="width: 120px; text-align: center;" type="text" name="gaseste_bratara_provizorie" id="gaseste_bratara_provizorie" value="COD BRATARA" onClick="SelectAll('gaseste_bratara_provizorie')"></form></td>
            </tr></table>
    </div>
    <br>
    <?php
    // REFRESH
    header("Refresh: 15");
    // DATE
    setlocale(LC_TIME, array('ro.utf-8', 'ro_RO.UTF-8', 'ro_RO.utf-8', 'ro', 'ro_RO', 'ro_RO.ISO8859-2'));
    date_default_timezone_set('Europe/Bucharest');
    echo '<div style="text-align: center; min-width: 100%;">Ultimul update: ' . strftime('%d %B %Y %H:%M',time()) . '</div><br>';
    // OPEN ALL
    function open_all(){
        $message=shell_exec("sudo -S python open_script.py -1 2>&1");
        print_r($message);
    }
    function free_all(){
        $sql = "UPDATE `vestiare` SET `end_timestamp`=0, `state`=0, `id_client`=NULL";
        // Create connection
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        // Check connection
        if ($conn->connect_error) {
            die("Connecarea la baza de date a esuat: " . $conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarele eliberate cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul eliberarii: " . $conn->error;
        }
        $conn->close();
    }
    // OPEN ONE
    function open_specific(){
        $message=shell_exec('sudo -S python open_script.py ' . preg_replace('/\D/', '',$_POST['open_specific']) );
        print_r($message);
    }
    function free_specific(){
        $sql = "UPDATE `vestiare` SET `end_timestamp`=0, `state`=0, `id_client`=NULL WHERE `id_vestiar`=" . preg_replace('/\D/', '',$_POST['free_specific']);
        // Create connection
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        // Check connection
        if ($conn->connect_error) {
            die("Connecarea la baza de date a esuat: " . $conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarul ". preg_replace('/\D/', '',$_POST['free_specific']) ." eliberat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul eliberarii: " . $conn->error;
        }
        $conn->close();
    }
    // ALLOCATE ONE
    function alloc_specific(){
        // COUNTER
        $end_timestamp = strtotime('+4 hours', time());
        // DB
        verificare($_POST['id_client']);
        $sql = "UPDATE `vestiare` SET `end_timestamp`=" . $end_timestamp . ", `state`=1, id_client='".$_POST['id_client']."' WHERE `id_vestiar`=" . preg_replace('/\D/', '',$_POST['alloc_specific']) ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->connect_error) {
            die("Connecarea la baza de date a esuat: " . $conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarul " . preg_replace('/\D/', '',$_POST['alloc_specific']) . " alocat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul alocarii: " . $conn->error;
        }
        $conn->close();
    }
    function alloc_permanent_specific(){
        // DB
        $sql = "UPDATE `vestiare` SET `end_timestamp`=9999999999, `state`=2 WHERE `id_vestiar`=" . preg_replace('/\D/', '',$_POST['alloc_permanent_specific']) ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->connect_error) {
            die("Connecarea la baza de date a esuat: " . $conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarul " . preg_replace('/\D/', '',$_POST['alloc_permanent_specific']) . " alocat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul alocarii: " . $conn->error;
        }
        $conn->close();
    }
    //BLOCK OOS
    function block_oos_specific(){
        // DB
        $sql = "UPDATE `vestiare` SET `end_timestamp`= 0, `state`=3 WHERE `id_vestiar`=" . preg_replace('/\D/', '',$_POST['block_oos_specific']) ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->connect_error) {
            die("Connecarea la baza de date a esuat: " . $conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarul " . preg_replace('/\D/', '',$_POST['alloc_specific']) . " blocat permanent cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul blocarii: " . $conn->error;
        }
        $conn->close();
    }
    function start_refresh(){
        header("Refresh: 15");
    }
    function stop_refresh(){
        header("Refresh: 86400");
    }
    function aloca_bratara_provizorie(){
        $data_sfarsit_abonament = strtotime('+12 hours', time());
        $sql = 'INSERT INTO `clienti` (`id_client`, `nume`, `data_sfarsit_abonament`) VALUES ("'. $_POST['aloca_bratara_provizorie'] .'","Provizoriu",'. $data_sfarsit_abonament .')';
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Bratara provizorie adaugata cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul adaugarii: " . $conn->error;
        }
        $conn->close();
    }
    function gaseste_bratara_provizorie(){
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        $sql = 'SELECT `id_vestiar` FROM `vestiare` WHERE `id_client`=\''. $_POST['gaseste_bratara_provizorie'].'\'';
        $result = mysqli_fetch_array($conn->query($sql));
        $conn->close();
        $vestiar_gasit = $result['id_vestiar'];
        echo "Vestiarul ".$vestiar_gasit." este alocat bratarii!";
    }
    function sterge_bratara_provizorie(){
        //Gasete vestiarul
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        $sql = 'SELECT id_vestiar FROM vestiare WHERE id_client=\''. $_POST['sterge_bratara_provizorie'].'\'' ;
        $result = mysqli_fetch_array($conn->query($sql));
        $conn->close();
        $vestiar_gasit = $result["id_vestiar"];

        $sql = "UPDATE `vestiare` SET `end_timestamp`=0, `state`=0, `id_client`=NULL WHERE `id_vestiar`=".$vestiar_gasit;
        // Create connection
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        // Check connection
        if ($conn->connect_error) {
            die("Connecarea la baza de date a esuat: " . $conn->connect_error);
        }
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarul ".$vestiar_gasit." eliberat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul eliberarii: " . $conn->error;
        }
        $conn->close();

        $sql = 'DELETE FROM `clienti` WHERE `id_client`=\''. $_POST['sterge_bratara_provizorie'].'\'' ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Bratara provizorie stearsa cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul stergerii: " . $conn->error;
        }
        $conn->close();
    }
    function new_client(){
        header("Refresh: 86400");
        $data_sfarsit_abonament = strtotime('+'.$_POST['abonament'].' months', time());
        $sql = 'INSERT INTO `clienti` (`id_client`, `nume`, `data_sfarsit_abonament`) VALUES ("'. $_POST['id_client'] .'","'. $_POST['nume'] .'",'. $data_sfarsit_abonament .')';
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Clientul " . $_POST['nume'] . " adaugat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul adaugarii: " . $conn->error;
        }
        $conn->close();
    }
    function update_client_nume(){
        header("Refresh: 86400");
        $sql = 'UPDATE `clienti` SET `nume`=\''. $_POST['nume'] .'\' WHERE `id_client`=\''. $_POST['id_client'].'\'' ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Numele clientului " . $_POST['nume'] . " modificat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul modificarii numelui: " . $conn->error;
        }
        $conn->close();
    }
    function update_client_id(){
        header("Refresh: 86400");
        $sql = 'UPDATE `clienti` SET `id_client`=\''. $_POST['id_client'] .'\' WHERE `nume`=\''. $_POST['nume'].'\'' ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Bratara clientului " . $_POST['nume'] . " modificata cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul modificarii ID-ului: " . $conn->error;
        }
        $conn->close();

    }
    function update_client_data(){
        header("Refresh: 86400");
        $sql = 'UPDATE `clienti` SET `data_sfarsit_abonament`='. strtotime($_POST['data_sfarsit_abonament']) .' WHERE `id_client`=\''. $_POST['id_client'].'\'' ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Abonamentul clientului " . $_POST['nume'] . " a fost modificat cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul modificarii abonamentului: " . $conn->error;
        }
        $conn->close();
    }
    function sterge_client(){
        header("Refresh: 86400");
        $sql = 'DELETE FROM `clienti` WHERE `id_client`=\''. $_POST['id_client'].'\'' ;
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Clientul " . $_POST['nume'] . " sters cu succes!";
        }
        else {
            echo "Eroare aparuta in timpul stergerii: " . $conn->error;
        }
        $conn->close();
    }
    function search(){
        header("Refresh: 86400");
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if($_POST['search_term'] == ''){
            $sql = 'SELECT * FROM `clienti`';
        }
        else{
            $sql = 'SELECT * FROM `clienti` WHERE `nume`  LIKE \'%'.$_POST['search_term'].'%\' OR `id_client` LIKE \'%'.$_POST['search_term'].'%\'';
        }
        $result = mysqli_fetch_array($conn->query($sql));
        echo '<table class="clienti" border="1" style="min-width: 100%;">
        <tr><td><b>ID Bratara</td><td><b>Nume</td><td><b>Abonament pana la</td></tr>';
        if ($result = $conn->query($sql)) {
            $x = 1;
            while ($row = $result->fetch_assoc()) {
                echo '<form method="post" autocomplete="off"><tr><td>
            <input type="text" name="id_client" id="id_client" style="width: 90%; text-align: center;" value="'.$row["id_client"].'"><input type="submit" style="width: 10%;" name="update_client_id" value="Modifica" default /></td><td><input type="text" name="nume" id="nume" style="width: 90%; text-align: center;" value="'.$row["nume"].'"><input type="submit" style="width: 10%;" name="update_client_nume" value="Modifica"></td><td><input type="text" name="data_sfarsit_abonament" id="data_sfarsit_abonament" style="width: 80%; text-align: center;" value="'.date("j.m.Y", $row["data_sfarsit_abonament"]).'"><input type="submit" style="width: 10%;" name="update_client_data" value="Modifica"><input type="submit" style="width: 10%;" name="sterge_client" value="Sterge"></td></tr></form>';
                $x++;
            }
        }
        echo '</table>';
        $conn->close();
    }
    function verificare($id_client){
        $sql = "SELECT COUNT(`id_client`) AS count FROM `clienti` WHERE `id_client`='".$id_client."'";
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        $result = mysqli_fetch_array($conn->query($sql));
        $count = $result['count'];
        if($count == '0'){
            exit("Bratara nu figureaza in baza de date! ");
        }
        if($count == '1'){
            echo "Verificat cu succes! ";
        }
        $conn->close();
    }
    function insert_60($x){
        $sql = 'INSERT INTO `vestiare` (`id_vestiar`, `state`, `end_timestamp`, `client`) VALUES ("'. $x .'", NULL, NULL, NULL)';
        $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
        if ($conn->query($sql) === TRUE) {
            echo "Vestiarul " . '$x' . " inserat cu succes!";
        }
        $conn->close();
    }
    if (isset($_POST['start_refresh'])){
        start_refresh();
    }
    if (isset($_POST['stop_refresh'])){
        stop_refresh();
    }
    if (isset($_POST['open_all'])){
        open_all();
    }
    if (isset($_POST['free_all'])){
        free_all();
    }
    if (isset($_POST['open_specific'])){
        open_specific();
    }
    if (isset($_POST['free_specific'])){
        free_specific();
    }
    if (isset($_POST['alloc_specific'])){
        alloc_specific();
    }
    if (isset($_POST['alloc_permanent_specific'])){
        alloc_permanent_specific();
    }
    if (isset($_POST['block_oos_specific'])){
        block_oos_specific();
    }
    if (isset($_POST['aloca_bratara_provizorie'])){
        aloca_bratara_provizorie();
    }
    if (isset($_POST['gaseste_bratara_provizorie'])){
        gaseste_bratara_provizorie();
    }
    if (isset($_POST['sterge_bratara_provizorie'])){
        sterge_bratara_provizorie();
    }
    if (isset($_POST['new_client'])){
        new_client();
    }
    if (isset($_POST['update_client_nume'])){
        update_client_nume();
    }
    if (isset($_POST['update_client_id'])){
        update_client_id();
    }
    if (isset($_POST['update_client_data'])){
        update_client_data();
    }
    if (isset($_POST['sterge_client'])){
        sterge_client();
    }
    if (isset($_POST['search'])){
        search();
    }

    ?>
    <script type="text/javascript">
        function switchTo_manager_clienti() {
            var vestiare = document.getElementById("vestiare");
            var manager_clienti = document.getElementById("manager_clienti");
            vestiare.style.display = "none";
            manager_clienti.style.display = "block";
            localStorage.setItem('activeDiv', 'manager_clienti');
            localStorage.setItem('inactiveDiv', 'vestiare');
        }

        function switchTo_vestiare() {
            var vestiare = document.getElementById("vestiare");
            var manager_clienti = document.getElementById("manager_clienti");
            manager_clienti.style.display = "none";
            vestiare.style.display = "block";
            localStorage.setItem('activeDiv', 'vestiare');
            localStorage.setItem('inactiveDiv', 'manager_clienti');
        }

        function SelectAll(id){
            document.getElementById(id).focus();
            document.getElementById(id).select();
        }

        $(document).ready(function(){
            if(localStorage && localStorage.getItem('activeDiv')){
                document.getElementById(localStorage.getItem('activeDiv')).style.display = "block";
                document.getElementById(localStorage.getItem('inactiveDiv')).style.display = "none";
            }
        });
    </script>
</head>
<body>
<div class="show" id="vestiare">
    <table class="vestiare" border="1" style="min-width: 100%;">
        <?php
        for ($x=1; $x <= 62; $x++){
            if($x%10 ==1) {
                echo '<tr>';
            }
            $conn = new mysqli('localhost', 'phproot', 'Vestiar3!#', 'maindb');
            $sql = "SELECT end_timestamp, state, nume FROM vestiare LEFT JOIN clienti ON vestiare.id_client=clienti.id_client WHERE id_vestiar=" . $x;
            $result = mysqli_fetch_array($conn->query($sql));
            $conn->close();
            $nume = $result['nume'];
            $end_timestamp = $result['end_timestamp'];
            $state = $result['state'];
            $difference = $end_timestamp - time();
            if($state == 0){
                echo '<td bgcolor="limegreen">';
            }
            if($state == 1 and $difference > 600){
                echo '<td bgcolor="yellow">';
            }
            if($state == 1 and $difference < 600 and $difference > 0){
                echo '<td bgcolor="orange">';
            }
            if($state == 1 and $difference < 0){
                echo '<td bgcolor="red">';
            }
            if($state == 2){
                echo '<td bgcolor="dodgerblue">';
            }
            if($state == 3){
                echo '<td bgcolor="lightgrey">';
            }
            if($state == 0){
                echo '<p>'.$x.'</p>';
            }
            if($state == 3){
                echo '<p>'.$x.'</p>';
            }
            if($state == 2){
                echo '<p>'.$x.'</p> '. $nume;
            }
            if($state == 1 and $difference <= 0){
                echo '<p>'.$x.'</p> '. $nume;
            }
            if($state == 1 and $difference > 0){
                echo '<p>'.$x.'</p> '. $nume .'<br> ' . date("H:i", strtotime('-2 hours', $difference));
            }
            echo '<div class="buttons"><br>
            <form method="post"><input type="submit" name="free_specific" value="Elibereaza '.$x.'" /></form>
            <form method="post"><input type="submit" name="open_specific" value="Deschide '.$x.'" /></form>
            <form method="post">
              <input type="text" name="id_client" id="id_client'.$x.'" style="width: 95%; text-align: center;" value="COD BRATARA" onClick="SelectAll(\'id_client'.$x.'\');"><br><input type="submit" name="alloc_specific" value="Aloca '.$x.'" /></form>
            <form method="post"><input type="submit" name="alloc_permanent_specific" value="Aloca '.$x.' permanent" /></form>
            <form method="post"><input type="submit" name="block_oos_specific" value="Blocheaza '.$x.' permanent" /></form>
            </div></td>';
            if($x%10 ==0) {
                echo '</tr>';
            }
        }
        ?>
    </table>
    <table>
        <td align="center"><p>Deschidere de urgenta<p>
            <form method="post"><input type="submit" name="open_all" value="Deschide toate" /></form>
            <form method="post"><input type="submit" name="free_all" value="Elibereaza toate" /></form>
    </table>
</div>

<div class="show" id="manager_clienti" style="display: none;">

    <div style="text-align: center;align-content: center; min-width: 100%;"><form method="post" autocomplete="off">
            <br>
            <label for="search_term"><b>Cauta:</label>
            <input type="text" name="search_term" id="search_term" style="width: 250px;"><input type="submit" name="search" value="Cauta">
        </form></div>
    <hr>
    <p style="text-align: center;"><b>Adauga client</p>
    <form method="post" autocomplete="off">
        <p>
            <label for="nume"><b>Nume complet:</label>
            <input type="text" name="nume" id="nume" style="width: 250px;">
            <label for="abonament"><b>Abonament:</label>
            <input type="radio" name="abonament" class="radio" value="1" checked>1 luna
            <input type="radio" name="abonament" class="radio" value="3" >3 luni
            <input type="radio" name="abonament" class="radio" value="6" >6 luni
            <input type="radio" name="abonament" class="radio" value="12" >12 luni
            <label for="id_client"><b>Bratara:</label>
            <input type="text" name="id_client" id="id_client" style="width: 350px;">
        </p>
        <input type="submit" name="new_client" value="Adauga">
    </form>
    <hr>
</div>
</body>
</html>
