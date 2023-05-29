<?php
    session_start();
    
    if(isset($_SESSION['session_user_id'])) {
        header('Location: home.php');
        exit;
    }

    $misses = array();
    $used = array();
    $invalid = array();
    $db_error = "";

    $refresh = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["confirm_email"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"])) {
        $conn = mysqli_connect("localhost", "root", "", "db") or die(mysqli_error($conn));

        $error = false;

        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            array_push($invalid, "username");
            $error = true;
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                array_push($used, "username");
                $error = true;

            }
        }

        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $_POST['password'])) {
            array_push($invalid, "password");
            $error = true;

        } 

        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            array_push($invalid, "confirm_password");
            $error = true;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            array_push($invalid, "email");
            $error = true;
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                array_push($used, "email");
                $error = true;
            }
        }

        if (strcmp($_POST["email"], $_POST["confirm_email"]) != 0) {
            array_push($invalid, "confirm_email");
            $error = true;
        }

        if ($error == false) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users(username, password, name, surname, email) VALUES('$username', '$password', '$name', '$surname', '$email')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["session_username"] = $_POST["username"];
                $_SESSION["session_user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $db_error = "Errore di connessione al database, prego riprova più tardi";
            }
        }
        mysqli_close($conn);
    }
    else {
        if($refresh == true && empty($_POST["username"])) array_push($misses, "username");
        if($refresh == true && empty($_POST["email"])) array_push($misses, "email");
        if($refresh == true && empty($_POST["confirm_email"])) array_push($misses, "confirm_email");
        if($refresh == true && empty($_POST["password"])) array_push($misses, "password");
        if($refresh == true && empty($_POST["confirm_password"])) array_push($misses, "confirm_password");
        if($refresh == true && empty($_POST["allow"])) array_push($misses, "allow");
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Carinterest - Iscriviti</title>
        <link rel='stylesheet' href='style/signup.css'>
        <link rel='stylesheet' href='style/checkbox.css'>
        <script src="javascript/signup.js" defer='true'></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap" rel="stylesheet">
    </head>

    <body>
        <main>
            <img id='logo' src="img/logo.png">
            <h2>Carinterest</h2>
            <h3>Crea un account per accedere. È gratuito!</h3>
            <form method='post' enctype="multipart/form-data" autocomplete="off">
                <label>Nome Utente*<input type='text' name='username' 
                    <?php 
                        if(isset($_POST["username"])) {
                            echo "value=".$_POST["username"];
                        } 
                    ?>></label>
                    
                    <p id='username_error'>
                        <?php 
                            if(in_array("username", $misses)) echo "• Devi inserire il tuo nome utente";
                            if(in_array("username", $invalid)) echo "• Username non valida";
                            if(in_array("username", $used)) echo "• Username già in uso"
                        ?>
                    </p>    

                <label>Email*<input type='text' name='email' 
                    <?php 
                        if(isset($_POST["email"])) {
                            echo "value=".$_POST["email"];
                        } 
                    ?>></label>

                    <p id='email_error'>
                        <?php 
                            if(in_array("email", $misses)) echo "• Devi inserire la tua email";
                            if(in_array("email", $invalid)) echo "• Email non valida";
                            if(in_array("email", $used)) echo "• Email già in uso"
                        ?>
                    </p>

                <label>Conferma Email*<input type='text' name='confirm_email' 
                    <?php 
                        if(isset($_POST["confirm_email"])) {
                            echo "value=".$_POST["confirm_email"];
                        } 
                    ?>></label>

                    <p id='confirm_email_error'>
                        <?php 
                            if(in_array("confirm_email", $misses)) echo "• Devi confermare la tua email";
                            if(in_array("confirm_email", $invalid)) echo "• Le email non coincidono";
                        ?>
                    </p>

                <label>Password*<input type='password' name='password' 
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

                <label>Conferma Password*<input type='password' name='confirm_password' 
                    <?php 
                        if(isset($_POST["confirm_password"])) {
                            echo "value=".$_POST["confirm_password"];
                        } 
                    ?>></label>
                    
                    <p id='confirm_password_error'>
                        <?php 
                            if(in_array("confirm_password", $misses)) echo "• Devi confermare la tua password";
                            if(in_array("confirm_password", $invalid)) echo "• Le password non coincidono";
                        ?>
                    </p>

                    <label class="container">
                        <input type='checkbox' name='show_password'>
                        <span class="checkmark"></span>
                        <span>Mostra Password</span>
                    </label>
                    
                <label>Nome<input type='text' name='name' 
                    <?php 
                        if(isset($_POST["name"])) {
                            echo "value=".$_POST["name"];
                        } 
                    ?>></label>
                    <p></p>

                <label>Cognome<input type='text' name='surname' 
                    <?php 
                        if(isset($_POST["surname"])) {
                            echo "value=".$_POST["surname"];
                        } 
                    ?>></label>

                <em>(*) Campi obbligatori</em>   

            <label id='check' class="container">
                <input type='checkbox' name='allow' value="1" 
                <?php 
                    if(isset($_POST["allow"])){
                        echo $_POST["allow"] ? "checked" : "";
                    } 
                ?>>
                <span class="checkmark"></span>
                <div>Accetto i <a href="terms.php"> Termini e Condizioni d'Uso</a> di Carinterest</div>
            </label>

                <p id='allow_error'>
                        <?php 
                            if(in_array("allow", $misses)) echo "• Devi accettare i Termini e Condizioni";
                        ?>
                    </p>

            <label id='submit'><input type='submit' value="REGISTRATI"></label>
            </form>

                <?php
                    if(!$db_error == "") echo "<p>".$db_error."</p>"
                ?>

            <div>Hai un account? <a href="login.php">Accedi</a></div>
        </main>
    </body>
</html>