<?php 
    session_start();
        
    if(!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit;
    }

    header('Content-Type: application/json');

    cercaDB();

    function cercaDB() {
        $q = ($_GET["q"]);        
        
        $conn = mysqli_connect("localhost", "root", "", "db");
        $query = "SELECT * FROM uploads WHERE descrip LIKE '%$q%' OR alt_desc LIKE '%$q%'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $rows = array();

        while($r = mysqli_fetch_assoc($res)) {
            $rows[] = $r;
        }
        print json_encode($rows);
    }
?>