<?php
    session_start();
    
    if(!isset($_SESSION['session_user_id'])) {
        header('Location: login.php');
        exit;
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
        <script src="javascript/cerca_img.js" defer="true"></script>
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
            <form autocomplete="off">
                <label>Cerca tra migliaia foto di auto</label>
                <p>powered by <a href="https://unsplash.com">Unsplash</a></p>
                <input type='text' name="cerca">
                <input type="submit" value="CERCA">
            </form>
        </section>

        <div id="modal" class="hidden">
        </div>

        <section id="results">
            <div id='album'></div>
        </section>

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