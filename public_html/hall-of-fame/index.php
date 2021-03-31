<?php
include_once "../includes/error.php";
/**
 * Setup
 */
include_once "../api/index.php";

// $bestSkaters = getBestSkaters();

include_once "../header.php";

echo "<script>let athletesAmount = ". getAthleteAmount() .";</script>";

echoRandWallpaper();

?>
<main class="main country">
    <div class="athletes">
        <h1 class="title">Hall of fame</h1>
        <h4 class="loading-message align center margin top triple">Selecting the best between <div class="amount"></div> skaters</h4>
        <div class="loading circle"></div>
        <div class="rest1 hidden">
            <h3 class="top">Top 10 skaters</h3>
            <div class="slideshow best"></div>

            <h3 class="top">Top 10 sprinters</h3>
            <div class="slideshow sprinters"></div>

            <h3 class="top">Top 10 longdistance skaters</h3>
            <div class="slideshow long"></div>
        </div>
    </div>
    <script>
        scoreCallbacks.push(update);


        initGet();

        function initGet(){
            get("hallOfFame").receive((succsess, bestSkaters) => {
                console.log(bestSkaters);
                if(succsess){
                    clear();
                    init(bestSkaters);
                } else{
                    alert("An error occoured :/");
                }
            });
        }

        anime({
            targets: ".amount",
            innerText: [athletesAmount - 100, athletesAmount],
            easing: "easeOutQuad",
            round: true,
            duration: 2500,
            update: function(a) {
                const value = a.animations[0].currentValue;
                document.querySelectorAll(".amount").innerHTML = value;
            }
        });

        function update(){
            initGet();
        }

        let slideshows = [];
        
        function clear(){
            for (const slideshow of slideshows) {
                slideshow.remove();
            }
            slideshows = [];
        }

        function init(bestSkaters){
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();
            $(".rest1").removeClass("hidden");
            const topAmount = 10

            sortArray(bestSkaters, "score");
            for (let i = 0; i < topAmount; i++) {
                const athlete = bestSkaters[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.appendTo(".slideshow.best");
            }
            slideshows.push(new Slideshow($(".slideshow.best")));
            sortArray(bestSkaters, "scoreShort");

            for (let i = 0; i < topAmount; i++) {
                const athlete = bestSkaters[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.appendTo(".slideshow.sprinters");
            }
            slideshows.push(new Slideshow($(".slideshow.sprinters")));

            sortArray(bestSkaters, "scoreLong");

            for (let i = 0; i < topAmount; i++) {
                const athlete = bestSkaters[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.appendTo(".slideshow.long");
            }
            slideshows.push(new Slideshow($(".slideshow.long")));
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>