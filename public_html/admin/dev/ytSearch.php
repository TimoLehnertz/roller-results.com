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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yt mass finder</title>
    <script src="/js/jquery-3.5.1.js"></script>
    <script src="/js/ajaxAPI.js"></script>
    <script src="/js/lib.js"></script>
    <script src="js/ytSearch.js"></script>
    <style>
        .video{
            background: rgb(95, 29, 29);
            color: white;
        }

        .video.active {
            background: rgb(55, 109, 55);
            color: white;
        }

        .highlight{
            color: red;
        }
    </style>
</head>
<body>
    <button onclick="start()">start</button>
    <button onclick="getApi()">getAPI</button>
    <button onclick="updateDb()">update db</button>
    <input type="number" value="10" placeholder="maxFetch" class="max">
    <div class="apiRes"></div>
    <div class="result"></div>
</body>
</html>