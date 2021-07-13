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
    <script src="/admin/dev/js/extractorScript.js"></script>
    <title>Extractor</title>
</head>
<body>
    <p>
        <label for="start">Start url</label>
        <input type="text" id="start" placeholder="Url..." value="https://www.the-sports.org/inline-skating-events-list-s22-c0-b0-g299-p2.html">
    </p>
    <p>
        <button onclick="go()">Go!</button>
    </p>
    <h1>Worker</h1>
    <hr>
    <div class="worker__wrapper"></div>
</body>
</html>