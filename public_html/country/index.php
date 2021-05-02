<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

// $country = getCountry($_GET["id"]);
// if(!$country){
//     // throwError($ERROR_INVALID_ID);
// }

include_once "../header.php";

// echo "<script>let country = ". json_encode($country) .";</script>";
echo "<script>const id = '". $_GET["id"] ."';</script>";

?>
<main class="main country">
    <script>
        // $(".countryName").prepend(getCountryFlag(findGetParameter("id"), 64));

        get("country", id).receive((succsess, country) => {
            if(!succsess || country.length === 0) {
                window.location.href = "/index.php";
            }
            const profile = countryToProfile(country, Profile.MAX);
        });

        // const profile = countryToProfile(country, Profile.MAX);
        // profile.appendTo("country");

        // scoreCallbacks.push(() => {
        //     profile.update();
        // });

    </script>
</main>
<?php
include_once "../footer.php";
?>