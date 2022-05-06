<!doctype html>

<?php
session_start();
$path = "assets/";

// Random colors
function getRanColor($username) {
    $hash = md5($username);
    return array(
        hexdec(substr($hash, 0, 2)), // r
        hexdec(substr($hash, 2, 2)), // g
        hexdec(substr($hash, 4, 2))  // b
    );
}

if (isset($_GET["loginBtn"]) && isset($_GET["user"])) {
    $input_username = $_GET["user"];
    // Check the username for length, characters and numbers
    if (strlen($input_username) >= 3 and strlen($input_username) <= 15 and !is_numeric($input_username) and !preg_match("/([%\$#\*]+)/", $input_username)) {
        // Get the usernames already taken
        $usernames = array();
        $index = 0;

        $handle = fopen($path . "users.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $usernames[$index] = trim(explode(";", $line)[0]);
                $index++;
            }
            fclose($handle);
        }

        // check if they match with the input username
        $is_taken = false;

        foreach($usernames as $key => $username) {
            if (strcmp($username, $input_username) === 0) {                
                $is_taken = true;
            }
        }

        if (!$is_taken) {
            
            // Write user in 'users' file
            $color = getRanColor($input_username);
            $fp = fopen($path . 'users.txt', 'a');
            fwrite($fp, $input_username . ";" . $color[0] . "," . $color[1] . "," . $color[2] . "\n");  
            fclose($fp);
            //Go over to the chatroom
            $_SESSION["user"] = $input_username;
            header("Location: chatroom.php");
        } else {
            echo "<script type='text/javascript'>alert('Username already exists');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Invalid username');</script>";
    }
}

?>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta content="Bootstrap V4.6.0 Template für IMS Frauenfeld" name="description">
    <meta content="Jean-Pierre Mouret" name="author">

    <title>ChatRoom</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Playfair Display' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="css/custom-stylesheet.css?<?filemtime('css/custom-stylesheet.css')?>" type="text/css">

</head>

<body>
    <main>
        <div class="center">
            <div class="item">
                <form method="get" action="index.php">
                    <label for="user"><p>Enter your Username to enter the session</p></label>
                    <div class="input-group mb-3">
                        <input type="text" name="user" id="user"  class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-dark" name="loginBtn">Login</button>
                        </div>
                    </div>
                </form> 
            </div>
            <div class="end">
                <script src="https://tryhackme.com/badge/474898"></script>
            </div>
        </div>
    </main>
</body>
</html>
