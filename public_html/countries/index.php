<?php
include_once "../api/index.php";
include_once "../header.php";

$countryAmount = getCountryAmount();

echo "<script>let countryAmount = $countryAmount;</script>";

echoRandWallpaper();

?>
<main class="main country">
    <div class="countries">
        <h1 class="title">Countries</h1>
        <div class="rest1">
            <h3 class="top">Top 10 countries overall</h3>
            <div class="slideshow best"></div>

            <!-- <div class="loading"></div> -->
            <div class="country-compare"></div>

            <h3 class="top">Top 10 sprint countries</h3>
            <div class="slideshow sprinters"></div>

            <h3 class="top">Top 10 longdistance countries</h3>
            <div class="slideshow long"></div>
            <!-- <h3 class="top">All Countries</h3>
            <div class="all-list"></div> -->
        </div>
    </div>
    <script>
        addMedalCallback(update);

        const topAmount = 10;

        //Empty profiles
        let slideshows = [];
        slideshows.push(new Slideshow($(".slideshow.best")));
        slideshows.push(new Slideshow($(".slideshow.sprinters")));
        slideshows.push(new Slideshow($(".slideshow.long")));
        for (const slideshow of slideshows) {
            for (let i = 0; i < topAmount; i++) {
                slideshow.elem.append(Profile.getPlaceholder(Profile.CARD));
            }
        }
        initGet();

        function initGet(){
            get("countries").receive((succsess, bestCountries) => {
                console.log(bestCountries);
                if(succsess){
                    countryAmount = bestCountries.length;
                    clear();
                    init(bestCountries);
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

        function update(){
            initGet();
            return true;
        }

        countryCompareElemAt($(".country-compare"), []);

        function init(skateCountries){
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();

            /**
             * country graph
             */
            get("countryScores").receive((succsess, countries) => {
                // $(() => {
                    $(".country-compare").empty();
                    countryCompareElemAt($(".country-compare"), countries);
                // })
            });

            /**
             * setup
             */
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();

            /**
             * over all
             */
            // console.log(skateCountries);
            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.best");
            }
            /**
             * sprint
             */
            sortArray(skateCountries, "medalScoreShort", true, true);
            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.sprinters");
            }

            sortArray(skateCountries, "medalScoreLong", true, true);

            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD, true, i + 1);
                profile.update = function() {this.grayOut = true};
                profile.appendTo(".slideshow.long");
            }
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>