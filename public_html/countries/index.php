<?php
/**
 * Setup
 */
include_once "../api/index.php";

include_once "../header.php";

echo "<script> let skateCountries = ".json_encode(getCountries())."</script>";

// echo json_encode(getCountries());

?>
<main class="main country">
    <div class="countries">
        <h1 class="align center margin top triple">Countries</h1>
        <div class="rest1 hidden">
            <h3 class="top">Top 10 countries overall</h3>
            <div class="slideshow best"></div>

            <h3 class="top">Top 10 sprint countries</h3>
            <div class="slideshow sprinters"></div>

            <h3 class="top">Top 10 longdistance countries</h3>
            <div class="slideshow long"></div>
            <h3 class="top">All Countries</h3>
            <div class="all-list"></div>
        </div>
    </div>
    <script>
        console.log(skateCountries);
        $(() => {
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();
            $(".rest1").removeClass("hidden");
            const topAmount = 10

            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD);
                profile.appendTo(".slideshow.best");
            }
            new Slideshow($(".slideshow.best"));
            sortArray(skateCountries, "scoreShort");

            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD);
                profile.appendTo(".slideshow.sprinters");
            }
            new Slideshow($(".slideshow.sprinters"));

            sortArray(skateCountries, "scoreLong");

            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD);
                profile.appendTo(".slideshow.long");
            }
            new Slideshow($(".slideshow.long"));
            // window.setTimeout(function() {
                sortArray(skateCountries, "score");
                for (const country of skateCountries) {
                    const profile = countryToProfile(country, Profile.MIN);
                    profile.appendTo($(".all-list"));
                }
            // }, 200);
            
        });
    </script>
</main>
<?php
include_once "../footer.php";
?>