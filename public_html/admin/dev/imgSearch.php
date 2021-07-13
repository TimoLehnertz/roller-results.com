<?php
include_once "../../includes/roles.php";
include_once "../../includes/error.php";

if(!canI("managePermissions")){
    throwError($ERROR_NO_PERMISSION);
}
include_once "../../api/index.php";

$athletes = getAllAthletes();
// print_r($athletes);
echo "<script>const athletes = ".json_encode($athletes).";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="/js/jquery-3.5.1.js"></script>
    <script src="js/imgSearch.js"></script>
    <title>img google search</title>
</head>
<body>
    <h1>img search</h1>
    <div class="worker"></div>
</body>
</html>
<?php
include_once "../../footer.php";
?>