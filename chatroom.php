<!doctype html>

<html lang="de">
<?php 
$path = "assets/";

session_start();

if (isset($_GET["btn"])) {
    if (isset($_GET["input"])) {
        $text = $_GET["input"];
        $user = $_SESSION["user"];
        
        $fp = fopen($path . 'chat.txt', 'a');
        fwrite($fp, $user . ";" . $text . "\n");  
        fclose($fp);
        
        unset($_GET["input"]); unset($_GET["btn"]);
        header("Location: chatroom.php");
    }
}

header( 'refresh: 5; url=chatroom.php' );

?>

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Bootstrap V4.6.0 Template für IMS Frauenfeld" name="description">
    <meta content="Jean-Pierre Mouret" name="author">

    <title>ChatRoom</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style>

        header {
            border-bottom: 2px solid black;
        }

        footer {
            position: fixed;
            bottom: 0px;
            width: 78%;
        }

        .container {
            margin-left: auto;
            margin-right: auto;
            width: 80%
        }
    </style>
</head>

<body>
<div class="container">
    <header>
        <h1>ChatRoom</h1>
    </header>
    <main>
        <?php
        
        $colors = array();

        $handle = fopen($path . "users.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $split = explode(";", $line);
                $user = $split[0];
                $rgb = $split[1];
                $colors[$user] = $rgb;
                
            }
            fclose($handle);
        }

        $handle = fopen($path . "chat.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $split = explode(";", $line);
                $user = $split[0];
                $msg = $split[1];
                
                echo "<p style=\"color:rgb(" . $colors[$user] . ");\">&#60;" . $user . "&#62;" . $msg . "</p>";
            }
            fclose($handle);
        }
        ?>
    </main>
    <footer>
        <form method="get" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Message..." name="input" id="input">
                <div class="input-group-append">    
                    <input class="btn btn-outline-secondary" type="submit" name="btn" id="btn">
                </div>
            </div>
        </form>
    </footer>
</div>
</body>
</html>
