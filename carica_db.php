<?php 
    session_start();
        
    if(!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit;
    }

    header('Content-Type: application/json');

    caricaDB();

    function caricaDB() {
        
        $userid = $_SESSION['session_user_id'];
        
        $conn = mysqli_connect("localhost", "root", "", "db");
        $query = "SELECT * FROM img WHERE userid = '$userid'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $rows = array();

        while($r = mysqli_fetch_assoc($res)) {
            $rows[] = array('userid' => $r['userid'],
                            'imgid' => $r['imgid'], 
                            'info' => json_decode($r['info']));;
        }

        print json_encode(array_reverse($rows));
    }
?>