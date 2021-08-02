<?php
/**
 * Setup
 */
include_once "../api/index.php";

include_once "../header.php";

// echo "<script> let skateCountries = ".json_encode(getCountries())."</script>";

$countryAmount = getCountryAmount();

echo "<script>let countryAmount = $countryAmount;</script>";

echoRandWallpaper();

?>
<main class="main country">
    <div class="countries">
        <h1 class="title">Countries</h1>
        <h4 class="loading-message align center margin top triple">Selecting the best between <div class="amount"></div> countries</h4>
        <div class="loading circle"></div>
        <div class="rest1 hidden">
            <h3 class="top">Top 10 countries overall</h3>
            <div class="slideshow best"></div>

            <div class="country-compare"><div class="loading"></div></div>

            <h3 class="top">Top 10 sprint countries</h3>
            <div class="slideshow sprinters"></div>

            <h3 class="top">Top 10 longdistance countries</h3>
            <div class="slideshow long"></div>
            <!-- <h3 class="top">All Countries</h3>
            <div class="all-list"></div> -->
        </div>
    </div>
    <script>
        // $(() => {init(skateCountries);});// got echoed from php
        scoreCallbacks.push(update);

        initGet();

        function initGet(){
            get("countries").receive((succsess, bestCountries) => {
                // console.log(bestCountries);
                if(succsess){
                    countryAmount = bestCountries.length;
                    clear();
                    init(bestCountries);
                } else{
                    alert("An error occoured :/");
                }
            });
        }

        anime({
            targets: ".amount",
            innerText: [countryAmount * 0.75, countryAmount],
            easing: "easeOutQuad",
            round: true,
            duration: 2500,
            update: function(a) {
                const value = a.animations[0].currentValue;
                document.querySelectorAll(".amount").innerHTML = value;
            }
        });

        let slideshows = [];
        function clear(){
            for (const slideshow of slideshows) {
                slideshow.remove();
            }
            slideshows = [];
            $(".country-compare").empty();
        }

        function update(){
            initGet();
            return true;
        }

        function init(skateCountries){
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();
            /**
             * country graph
             */
            get("countryScores").receive((succsess, countries) => {
                $(() => {
                    $(".country-compare").find(".loading").remove();
                    countryCompareElemAt($(".country-compare"), countries);
                })
            });

            /**
             * setup
             */
            $(".loading-message").addClass("scaleAway");
            $(".loading").remove();
            $(".rest1").removeClass("hidden");
            const topAmount = 10;

            /**
             * slideshows
             */
            /**
             * over all
             */
            // console.log(skateCountries);
            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD, true, i + 1);
                profile.appendTo(".slideshow.best");
            }
            slideshows.push(new Slideshow($(".slideshow.best")));
            /**
             * sprint
             */
            sortArray(skateCountries, "scoreShort");
            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD, true, i + 1);
                profile.appendTo(".slideshow.sprinters");
            }
            slideshows.push(new Slideshow($(".slideshow.sprinters")));

            sortArray(skateCountries, "scoreLong");

            for (let i = 0; i < Math.min(topAmount, skateCountries.length); i++) {
                const profile = countryToProfile(skateCountries[i], Profile.CARD, true, i + 1);
                profile.appendTo(".slideshow.long");
            }
            slideshows.push(new Slideshow($(".slideshow.long")));
            // window.setTimeout(function() {
            for (const country of skateCountries) {
                if(country.score == undefined){
                    country.score = 0;
                }
            }
            // sortArray(skateCountries, "score");
            // let i = 0;
            // for (const country of skateCountries) {
            //     const profile = countryToProfile(country, Profile.MIN, true, i + 1);
            //     profile.appendTo($(".all-list"));
            //     i++;
            // }
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>