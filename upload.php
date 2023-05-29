<?php
    session_start();
    
    if(!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit;
    }

    $invalid = array();
    $misses = array();
    $error = array();

    $refresh = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

    if (isset($_FILES) && !empty($_POST["description"])) {
        $check = false;
         
        $file = $_FILES["foto"];
        $type = exif_imagetype($file['tmp_name']);
        $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg');
        if (isset($allowedExt[$type])) {
            if ($file['error'] === 0) {
                $fileNameNew = uniqid('', true).".".$allowedExt[$type];
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($file['tmp_name'], $fileDestination);
            } else {
               array_push($error, "foto");
               $check = true;
            }
        } else {
            array_push($invalid, "foto");
            $check = true;
        }

        if ($check == false) {

            $conn = mysqli_connect("localhost", "root", "", "db");

            $username = $_SESSION['session_username'];
            $username = mysqli_real_escape_string($conn, $username);
            $root = mysqli_real_escape_string($conn, $fileDestination);
            $desc = mysqli_real_escape_string($conn, $_POST['description']);
            $alt_desc = mysqli_real_escape_string($conn, $_POST['alt_description']);
            $created = date("Y-m-d");

            $query = "INSERT INTO uploads(username, destination, descrip, alt_desc, created) VALUES('$username','$root', '$desc','$alt_desc', '$created')";
            $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
            header('Location: home.php');
        }

    } else {
        if($refresh == true && !isset($_FILES)) array_push($misses, "foto");
        if($refresh == true && empty($_POST["description"])) array_push($misses, "description");
    }
?>    

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Carinterest - Cerca Immagini</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/home.css">
        <link rel="stylesheet" href="style/search.css">
        <script src="javascript/upload.js" defer="true"></script>
        <script src="javascript/sidebar.js" defer="true"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
    <nav>
            <div>
                <img id='logo' src="img/logo.png">
                <h2>Carinterest</h2>    
            </div>

            <div id='menù'>
                <a href="home.php">HOME</a>
                <a href="upload.php">POST</a>
                <a href="profilo.php">
                    <?php                        
                        echo strtoupper($_SESSION['session_username']);
                    ?> 
                </a>
                <a href="logout.php">LOGOUT</a>
            </div>
            
            <img id='sidebar-icon'class='hidden' src="img/sidebar.png">

        </nav>

        <div id="sidebar" class="hidden">
            <a href="home.php">HOME</a>
            <a href="upload.php">POST</a>
            <a href="profilo.php">
                <?php                        
                    echo strtoupper($_SESSION['session_username']);
                ?> 
            </a>
            <a href="logout.php">LOGOUT</a>
        </div>

        <header>
            <h1>Come Pinterest ma pensato per gli amanti delle auto</h1>
            <div id='overlay'></div>
        </header>

        <section>
            <form method='post' enctype="multipart/form-data" autocomplete="off">
                <p>Carica la tua foto di auto</p>

                <label for='foto'>Carica la tua foto nei formati PNG o JPG</label>
                <input type="file" name="foto">

                <p class='error' id='file_error'>
                    <?php
                        if(in_array("foto", $misses)) echo "• Devi caricare una foto";
                        if(in_array("foto", $invalid)) echo "• Il formato non è corretto";
                        if(in_array("foto", $error)) echo "• Errore nel caricamento del file"
                    ?>
                </p>

                <div id='preview-box' class='hidden'>
                    <img id='preview' src="img/preview.png">
                </div>

                <label for='description'>Aggiungi una descrizione</label>
                <input type='text' name="description"
                    <?php 
                        if(isset($_POST["description"])) {
                            echo "value=".$_POST["description"];
                        } 
                    ?>>
                <p class='error' id='desc_error'>
                    <?php 
                        if(in_array("description", $misses)) echo "• Devi inserire una descrizione";
                    ?>
                </p>

                <label for='alt_description'>Aggiungi una sotto descrizione</label>
                <input type='text' name="alt_description"
                    <?php 
                        if(isset($_POST["alt_description"])) {
                            echo "value=".$_POST["alt_description"];
                        } 
                    ?>>
                <p></p>
                <input type="submit" value="CONDIVIDI">
            </form>
        </section>

        <?php 
            if(in_array("foto", $error)) echo "<h4>Errore nel caricamento della foto</h4>";
            else if(in_array("foto", $invalid)) echo "<h4>Formato della foto non valido</h4>";
            else if(in_array("foto", $misses)) echo "<h4>Foto mancante</h4>";
            else if(in_array("description", $misses)) echo "<h4>Descrizione mancante</h4>";
        ?>

        <footer>
            <div>
                <img src="https://images.squarespace-cdn.com/content/v1/60056c48dfad4a3649200fc0/1612524418763-3HFOBMTU3MLA65DWOGA3/Logo+UniCT?format=1000w">
            </div>
            <div id='info'>
                <span>Sviluppato da: <br> Piergiorgio Benenato <br> 1000015488</span>
            </div>
            <div id='contatti'>
                <span><a href="https://github.com/molofine">Github</a></span>
                <span><a href="https://www.youtube.com/@molofine">Youtube</a></span>
            </div>
        </footer>
    </body>
</html>