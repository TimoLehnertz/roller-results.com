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
</main>
<?php
include_once "../footer.php";//s
?>