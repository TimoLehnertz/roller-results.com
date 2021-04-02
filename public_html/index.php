<?php
include_once "api/index.php";
// $indexPage = 1;
include_once "header.php";
include_once "api/imgAPI.php";

$amountCountry = getCountryAmount();
$amountAthlete = getAthleteAmount();
$amountResult = getResultAmount();
$amountRace = getRaceAmount();
$amountCompetition = getCompetitionAmount();

echo "<script>
    const amountCountry = $amountCountry;
    const amountAthlete = $amountAthlete;
    const amountResult = $amountResult;
    const amountRace = $amountRace;
    const amountCompetition = $amountCompetition;
</script>";
// echoRandWallpaper();

?>
<!-- geoInterpolate() -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.2.2/d3.min.js"></script>

<!-- <script type="text/javascript" src="/js/globe/third-party/Detector.js"></script> -->
<!-- <script type="text/javascript" src="/js/globe/third-party/three.min.js"></script> -->
<!-- <script type="module" src="/js/globe/third-party/Tween.js"></script> -->
<script type="module" src="/js/globe/globe.js"></script>
<main class="main index">
    <div id="container">

    </div>
</main>
<script type="module">
    import { DAT } from "/js/globe/globe.js";

    var container = document.getElementById( 'container' );
    var globe = new DAT.Globe( container );

    // const controller = globe.trajectoryFromTo(50.800209, 6.764670, 0, 0, {color: 0xff44aa});

    // controller.animate("in", "forewards", 2000).onComplete(() => {
    //     controller.animate("out", "backwards", 2000).onComplete(() => {
    //         controller.animate("in", "forewards", 2000);
    //     })
    // });

    // globe.highlightAt(50.800209, 6.764670, {type: "ring", color: 0xff44aa, effects: [{
    //     type: "translateUp",
    //     direction: "alternate",
    //     easing: "easeInQuad",
    // }, {
    //     type: "scaleUp",
    //     direction: "alternate",
    //     easing: "easeInQuad",
    // }, {
    //     type: "fade",
    //     direction: "alternate",
    //     easing: "easeInQuad",
    // }]});
    // for (let lat = 0; lat < 90; lat+= 10) {
    //     for (let lng = 0; lng < 90; lng+= 10) {
    //         globe.highlightAt(lat, lng, {color: 0xff44aa});
    //     }
    // }
    globe.initPopulationDots();
    globe.animate();

    get("worldMovement").receive((succsess, data) => {
        console.log(data);
        for (const movement of data) {
            const randomX = Math.random() * 3 - 1.5;
            const randomY = Math.random() * 3 - 1.5;
            globe.trajectoryFromTo(movement.compLatitude + randomX, movement.compLongitude + randomY, movement.athleteLatitude, movement.athleteLongitude, {color: 0xff5544 + Math.random() * 2000}).animate("in", "forewards", 5000 * (Math.random() / 2 + 1));
        }
    });

</script>
<?php
    include_once "footer.php";
?>