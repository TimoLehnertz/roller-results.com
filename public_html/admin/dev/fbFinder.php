<?php

include_once "../../includes/roles.php";

if(!canI("managePermissions")){
    header("location: /index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/js/jquery-3.5.1.js"></script>
    <script src="js/fb.js"></script>
    <title>Facebook finder</title>
</head>
<body>
    <button onclick ="start()">Start</button>
    <h1>Worker</h1>
    <hr>
    <div class="worker"></div>
</body>
</html>