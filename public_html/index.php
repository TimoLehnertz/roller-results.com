<?php
include_once "api/index.php";
include_once "header.php";

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

?>
<main class="main index">
    <div class="amounts">
        <div class="amounts__country">
        <div class="amount"><?=$amountCountry?></div>
            <div class="type">Countries</div>
        </div>
        <div class="amounts__athlete">
            <div class="amount"><?=$amountAthlete?></div>
            <div class="type">Athletes</div>
        </div>
        <div class="amounts__results">
        <div class="amount"><?=$amountResult?></div>
            <div class="type">Results</div>
        </div>
        <div class="amounts__race">
        <div class="amount"><?=$amountRace?></div>
            <div class="type">Races</div>
        </div>
        <div class="amounts__competition">
        <div class="amount"><?=$amountCompetition?></div>
            <div class="type">Competitions</div>
        </div>
    </div>
    <h2>Yours, to explore, forever</h2>
    <a href="/hall-of-fame/"><h2>Hall of fame</h2></a>
    <div class="table-test"></div>
</main>
<script>
$(initIndex);
/**
 * index page
 */
function initIndex(){
    const drop = 0.6;
    const data = [
        {class: 'amounts__country', val: amountCountry},
        {class: 'amounts__athlete', val: amountAthlete},
        {class: 'amounts__results', val: amountResult},
        {class: 'amounts__race', val: amountRace},
        {class: 'amounts__competition', val: amountCompetition},
    ]
    for (const obj of data) {
        numberAnimate({
            targets: "." + obj.class + " .amount",
            from: obj.val  * drop,
            to: obj.val,
            duration: 4000,
            easing: "easeOutExpo"
        });
    }
}
</script>
<?php
    include_once "footer.php";
?>