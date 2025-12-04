<?php
session_start();

if(!isset($_SESSION['emailaddress']) || !isset($_SESSION['password_hash'])){
    header("Location: login.php");
    exit;
}

?>
<html>
    <head>
        <title>AI Chatbox | Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <!--<a href='logout.php'>Logout</a>-->
        <?php
            $files = array_diff(scandir("../classes"), array('.', '..'));

            foreach ($files as $file) {
                require_once "../classes/{$file}";
            }

            $_REQUEST['req'] = $_REQUEST['req'] ?? "basic";
            $_REQUEST['uid'] = $_SESSION['uid'];

            $Controller = new DashboardController($_REQUEST);
            $Controller->process();

        ?>
    </body>
</html>