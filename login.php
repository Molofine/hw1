<?php
    session_start();
    
    if(isset($_SESSION['session_user_id'])) {
        header('Location: home.php');
        exit;
    }

    $misses = array();
    $invalid = array();

    $refresh = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $conn = mysqli_connect("localhost", "root", "", "db") or die(mysqli_error($conn));

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $query = "SELECT * FROM users WHERE username = '".$username."'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        
        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {
                $_SESSION['session_username'] = $entry['username'];
                $_SESSION['session_user_id'] = $entry['id'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            } else array_push($invalid, "password");
        } else array_push($invalid, "username");

    } else {
        if($refresh == true && empty($_POST["username"])) array_push($misses, "username");
        if($refresh == true && empty($_POST["password"])) array_push($misses, "password");
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carinterest - Login</title>
        <link rel='stylesheet' href='style/login.css'>
        <script src="javascript/login.js" defer='true'></script>
        <link rel='stylesheet' href='style/checkbox.css'>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div id='left-side'>
            <img id='side-image' src="https://www.theaa.com/~/media/the-aa/article-summaries/driving-advice/car-buyers-guide/car-tyres.jpg">
        </div>

        <div id='right-side'>
            <main>
                <img id='logo' src="img/logo.png">
                <h2>Carinterest</h2>
                <h5>Benvenuto! Accedi inserendo le credenziali</h5>

                <form method='post'>

                    <label>Nome Utente<input type='text' name='username'
                    <?php 
                        if(isset($_POST["username"])) {
                            echo "value=".$_POST["username"];
                        } 
                    ?>></label>

                    <p id='username_error'>
                        <?php 
                            if(in_array("username", $misses)) echo "• Devi inserire il tuo nome utente";
                            if(in_array("username", $invalid)) echo "• Username non corretto";
                        ?>
                    </p>

                    <label>Password<input type='password' name='password'
                    <?php 
                        if(isset($_POST["password"])) {
                            echo "value=".$_POST["password"];
                        } 
                    ?>></label>

                    <p id='password_error'>
                        <?php 
                            if(in_array("password", $misses)) echo "• Devi inserire la tua password";
                            if(in_array("password", $invalid)) echo "• Password non valida";
                        ?>
                    </p>
                    
                    <label class="container">
                        <input type='checkbox' name='show_password'>
                        <span class="checkmark"></span>
                        <span>Mostra Password</span>
                    </label>

                    <label id='submit'><input type='submit' value="ACCEDI"></label>
                </form>
                <div id='signup'>Sei nuovo? <a href="signup.php">Registrati</a></div>
            </main>
        </div>  
    </body>
</html>