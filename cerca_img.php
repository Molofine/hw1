<?php 
    session_start();
        
    if(!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit;
    }

    header('Content-Type: application/json');

    cercaImmagine();

    function cercaImmagine() {

        $query = urlencode($_GET["q"]);
        $url = 'https://api.unsplash.com/search/photos?client_id=8lJOUF8-QsePqUO7aWtF9xMoxdHiN_tiffc9bDsurTk&query='.$query.'&page=1&per_page=30';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($curl);
        curl_close($curl);
        echo $res;
    }
?>