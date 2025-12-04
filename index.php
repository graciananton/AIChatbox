<html>
    <head>
        <title>AI Chatbox | Home</title>
            <link 
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
                rel="stylesheet" 
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
                crossorigin="anonymous"
            >
            <script 
                src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                crossorigin="anonymous"
            >
            </script>
            <script src="https://www.google.com/recaptcha/api.js"></script>
    </head>
    <body style='border:1px solid green;'>
        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $files = array_diff(scandir("classes"), array('.', '..'));
            foreach ($files as $file) {
                require_once "classes/{$file}";
            }
            $_REQUEST['req'] = $_REQUEST['req'] ?? "home";
            $Controller = new HomeController($_REQUEST);
            $Controller->process();
        ?>
    </body>
</html>