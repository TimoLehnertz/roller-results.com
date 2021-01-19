<?php
include_once "../includes/error.php";
/**
 * Setup
 */
include_once "../api/index.php";

// $bestSkaters = getBestSkaters();

include_once "../header.php";

echo "<script>let athletesAmount = ". getAthleteAmount() .";</script>";

?>
<main class="main country">
    <div class="athletes">
        <h1 class="align center margin top triple">Hall of fame</h1>
        <h4 class="loading-message align center margin top triple">Selecting the best between <span class="amount"></span> skaters</h4>
        <div class="loading circle"></div>
        <div class="rest1 hidden">
            <h2 class="top">Top 10 skaters</h2>
            <div class="slideshow best"></div>

            <h2 class="top">Top 10 sprinters</h2>
            <div class="slideshow sprinters"></div>

            <h2 class="top">Top 10 longdistance skaters</h2>
            <div class="slideshow long"></div>
        </div>
    </div>
    <script>
        anime({
            targets: ".amount",
            innerText: [athletesAmount - 40, athletesAmount],
            easing: "easeOutQuad",
            round: true,
            duration: 1500,
            update: function(a) {
                const value = a.animations[0].currentValue;
                document.querySelectorAll(".amount").innerHTML = value;
            }
        });
        get("bestAthletes").receive((succsess, bestSkaters) => {
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();
            $(".rest1").removeClass("hidden");
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
        });
    </script>
</main>
<?php
include_once "../footer.php";
?>