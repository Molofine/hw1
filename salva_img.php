<?php
    session_start();
    
    if(!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit;
    }

    salvaImmagine();

    function salvaImmagine() {

        $user_id = $_SESSION['session_user_id'];

        $conn = mysqli_connect("localhost", "root", "", "db");
        
        $userid = mysqli_real_escape_string($conn, $user_id);
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $alt_desc = mysqli_real_escape_string($conn, $_POST['alt_description']);
        $created = mysqli_real_escape_string($conn, $_POST['created']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $image = mysqli_real_escape_string($conn, $_POST['image']);

        $query = "SELECT * FROM img WHERE userid = '$userid' AND imgid = '$id'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if(mysqli_num_rows($res) > 0) {

            $query = "DELETE FROM img WHERE userid = '$userid' AND imgid = '$id'";
            mysqli_query($conn, $query) or die(mysqli_error($conn));
            echo json_encode(array('presente' => true));
        } else {
            $query = "INSERT INTO img(userid, imgid, info) VALUES('$userid','$id', JSON_OBJECT('id', '$id', 'description', '$desc', 'alt_description', '$alt_desc', 'created', '$created', 'author', '$author', 'image', '$image'))";
            error_log($query);
            mysqli_query($conn, $query) or die(mysqli_error($conn));
            echo json_encode(array('presente' => false));
        }
        mysqli_close($conn);
    }
?> 
