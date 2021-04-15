<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$race = getRace($_GET["id"]);
if(!$race){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>const race = ". json_encode($race) .";</script>";

?>
<main class="main">
    <!-- <div class="loading circle"></div> -->
    <script>
        getRaceTable($("main"), race);
    </script>
    <iframe src="https://www.facebook.com/media/set/?set=a.2385945671518972&type=3" frameborder="0"></iframe>
</main>
<?php
include_once "../footer.php";//s
?>