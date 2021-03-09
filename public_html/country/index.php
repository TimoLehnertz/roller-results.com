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
    // throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>let country = ". json_encode($country) .";</script>";

?>
<main class="main country">
    <h2 class="countryName"><?php echo $country["country"]?></h2>
    <div class="athletes">
    </div>
    <script>
        $(".countryName").prepend(getCountryFlag(findGetParameter("id"), 64));
        const profile = countryToProfile(country, Profile.MAX);
        profile.appendTo($(".athletes"));

        scoreCallbacks.push(() => {
            profile.update();
        });

    </script>
</main>
<?php
include_once "../footer.php";
?>