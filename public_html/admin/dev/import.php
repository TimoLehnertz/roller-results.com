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
    <title>Importer</title>
    <script src="/js/jquery-3.5.1.js"></script>
    <script src="/js/ajaxAPI.js"></script>
    <script src="/js/lib.js"></script>
    <script src="js/import.js"></script>
</head>
<body>
    <button onclick="checkAthletes()">Add ids on existing athletes</button>
    <button onclick="convertToCsv()">Convert to csv</button>
    <div class="out">Output values will be here</div>
</body>
</html>