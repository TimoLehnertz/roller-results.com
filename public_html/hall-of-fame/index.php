<?php
include_once "../includes/error.php";
/**
 * Setup
 */
include_once "../api/index.php";

$bestSkaters = getBestSkaters();

include_once "../header.php";

echo "<script>let bestSkaters = ". json_encode($bestSkaters) .";</script>";

?>
<main class="main country">
    <div class="athletes">
        <h1 class="align center margin top triple">Hall of fame</h1>
        <h2 class="top">Top 10 skaters</h2>
        <div class="slideshow best"></div>

        <h2 class="top">Top 10 sprinters</h2>
        <div class="slideshow sprinters"></div>

        <h2 class="top">Top 10 longdistance skaters</h2>
        <div class="slideshow long"></div>
    </div>
    <script>
        console.log(bestSkaters);
        const topAmount = 10

        for (let i = 0; i < topAmount; i++) {
            const athlete = bestSkaters[i];
            const profile = athleteToProfile(athlete, Profile.CARD);
            profile.appendTo(".slideshow.best");
        }
        new Slideshow($(".slideshow.best"));

        bestSkaters.sort((a, b) => {
            if(a.scoreShort < b.scoreShort){
                return 1;
            } else if(a.scoreShort > b.scoreShort){
                return -1;
            } else{
                return 0
            }
        })

        for (let i = 0; i < topAmount; i++) {
            const athlete = bestSkaters[i];
            const profile = athleteToProfile(athlete, Profile.CARD);
            profile.appendTo(".slideshow.sprinters");
        }
        new Slideshow($(".slideshow.sprinters"));

        bestSkaters.sort((a, b) => {
            if(a.scoreShort < b.scoreShort){
                return -1;
            } else if(a.scoreShort > b.scoreShort){
                return 1;
            } else{
                return 0
            }
        })

        for (let i = 0; i < topAmount; i++) {
            const athlete = bestSkaters[i];
            const profile = athleteToProfile(athlete, Profile.CARD);
            profile.appendTo(".slideshow.long");
        }
        new Slideshow($(".slideshow.long"));

    </script>
</main>
<?php
include_once "../footer.php";
?>