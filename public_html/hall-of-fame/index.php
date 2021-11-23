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
        <!-- <div class="loading circle"></div> -->
        <div class="rest1">
            <h3 class="top align center">Top 10 skaters</h3>
            <div class="slideshow best"></div>

            <h3 class="top align center">Top 10 women</h3>
            <div class="slideshow best-women"></div>

            <h3 class="top align center">Top 10 men</h3>
            <div class="slideshow best-men"></div>

            <h3 class="top align center">Top 10 sprinters</h3>
            <div class="slideshow sprinters"></div>

            <h3 class="top align center">Top 10 longdistance skaters</h3>
            <div class="slideshow long"></div>
        </div>
    </div>
    <script>
        addMedalCallback(update);

        const topAmount = 10;

        //Empty profiles
        let slideshows = [];
        slideshows.push(new Slideshow($(".slideshow.best")));
        slideshows.push(new Slideshow($(".slideshow.best-women")));
        slideshows.push(new Slideshow($(".slideshow.best-men")));
        slideshows.push(new Slideshow($(".slideshow.sprinters")));
        slideshows.push(new Slideshow($(".slideshow.long")));
        for (const slideshow of slideshows) {
            for (let i = 0; i < topAmount; i++) {
                slideshow.elem.append(Profile.getPlaceholder(Profile.CARD));
            }
        }
        initGet();

        function initGet(){
            get("hallOfFame").receive((succsess, bestSkaters) => {
                if(succsess){
                    clear();
                    init(bestSkaters);
                } else{
                    alert("An error occoured :/");
                }
            });
        }

        function clear(){
            for (const slideshow of slideshows) {
                slideshow.remove();
            }
        }

        function update() {
            initGet();
            return true;
        }

        function init(bestSkaters){
            if(getMedalCount() === 0) {
                $(".rest1").prepend(`<h2 class="margin left hint color hint">Select Competitions in teh settings to compute country rankings</h2>`);
            } else {
                $(".hint").remove();
            }
            for (let i = 0; i < topAmount; i++) {
                if(i >= bestSkaters.length) break;
                const athlete = bestSkaters[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.best");
            }

            /**
             * women
             */
            const women = bestSkaters.filter(skater => skater.gender.toLowerCase() == "w");
            for (let i = 0; i < topAmount; i++) {
                if(i >= women.length) break;
                const athlete = women[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.best-women");
            }

            /**
             * men
             */
            const men = bestSkaters.filter(skater => skater.gender.toLowerCase() == "m");
            for (let i = 0; i < topAmount; i++) {
                if(i >= men.length) break;
                const athlete = men[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.best-men");
            }
            sortArray(bestSkaters, "medalScoreShort", true, true);
            for (let i = 0; i < topAmount; i++) {
                if(i >= bestSkaters.length) break;
                const athlete = bestSkaters[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.sprinters");
            }

            sortArray(bestSkaters, "medalScoreLong", true, true);

            for (let i = 0; i < topAmount; i++) {
                if(i >= bestSkaters.length) break;
                const athlete = bestSkaters[i];
                const profile = athleteToProfile(athlete, Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.long");
            }
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>