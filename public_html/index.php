<?php
include_once "api/index.php";
$indexPage = 1;
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
echoRandWallpaper();

include_once "../data/dbh.php";

// echo getAthleteAmount();
// echo "hello world"

?>
<main class="main index">
    <div class="amounts">
        <div class="amounts__competition">
            <div class="amount"><?=$amountCompetition?></div>
            <div class="type">Events</div>
        </div>
    
        <div class="amounts__athlete">
            <div class="amount"><?=$amountAthlete?></div>
            <div class="type">Athletes</div>
        </div>
        <div class="amounts__result">
            <div class="amount"><?=$amountResult?></div>
            <div class="type">Results</div>
        </div>
        <div class="amounts__race">
            <div class="amount"><?=$amountRace?></div>
            <div class="type">Races</div>
        </div>
        <div class="amounts__country">
            <div class="amount"><?=$amountCountry?></div>
            <div class="type">Countries</div>
        </div>
    </div>
    <div class="headline">
        <div>Inline Data</div>
    </div>
    <?php
        include "logo.html";
    ?>
    
    <div class="subtitle">
        <span class="text">
            Yours, to explore, forever
        </span>
    </div>
    <div class="content">
        <a href="/hall-of-fame/"><h2>Hall of fame</h2></a>
        <div class="table-test"></div>
    </div>
</main>
<script>
$(initIndex);
/**
 * index page
 */
function initIndex(){
    const drop = 0.8;
    const data = [
        {class: 'amounts__competition', val: amountCompetition},
        {class: 'amounts__result', val: amountResult},
        {class: 'amounts__athlete', val: amountAthlete},
        {class: 'amounts__race', val: amountRace},
        {class: 'amounts__country', val: amountCountry},
        
    ]
    let i = 0;
    for (const obj of data) {
        numberAnimate({
            targets: "." + obj.class + " .amount",
            from: obj.val  * drop,
            to: obj.val,
            duration: 1000 + i * 1700,
            easing: "easeOutExpo"
        });
        i++;
    }
}
</script>
<?php
    include_once "footer.php";
?>