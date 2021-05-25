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
        <h1 class="title">All countries</h1>
        <h4 class="loading-message align center margin top triple">Loading countries...<div class="amount"></div> countries</h4>
        <div class="loading circle"></div>
        <div class="all-countries grid three"></div>
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

        // anime({
        //     targets: ".amount",
        //     innerText: [countryAmount * 0.75, countryAmount],
        //     easing: "easeOutQuad",
        //     round: true,
        //     duration: 2500,
        //     update: function(a) {
        //         const value = a.animations[0].currentValue;
        //         document.querySelectorAll(".amount").innerHTML = value;
        //     }
        // });

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
            // get("countryScores").receive((succsess, countries) => {
            //     $(() => {
            //         $(".country-compare").find(".loading").remove();
            //         countryCompareElemAt($(".country-compare"), countries);
            //     });
            // });

            /**
             * setup
             */
            $(".all-countries").removeClass("hidden");
            console.log(skateCountries);

            for (const country of skateCountries) {
                const profile = countryToProfile(country, Profile.MIN);
                profile.appendTo(".all-countries");
            }
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>