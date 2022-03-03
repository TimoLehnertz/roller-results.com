<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$country = getCountry($_GET["id"]);
if(!$country){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>let country = JSON.parse(`". json_encode($country) ."`);</script>";
// echo "<script>const id = JSON.parse('". $_GET["id"] ."');</script>";

?>
<main class="main country">
    <script>
        const profile = countryToProfile(country, Profile.MAX);
        profile.update();
    </script>
</main>
<?php
include_once "../footer.php";
?>