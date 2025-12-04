<?php session_start(); ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<html>
    <head>
        <title>AI Chatbox | Login</title>
          <link 
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
                rel="stylesheet" 
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
                crossorigin="anonymous"
          >
    </head>
    <body>
        <?php
            $files = array_diff(scandir("../classes"), array('.', '..'));

            foreach ($files as $file) {
                require_once "../classes/{$file}";
            }


            $_REQUEST['req'] = $_REQUEST['req'] ?? "login";
            $Controller = new UserController($_REQUEST);
            $Controller->process();
        ?>
    </body>
</html>