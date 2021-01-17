<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";

$persons = getCountry($_GET["id"]);
if(!$persons){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>let athletes = ". json_encode($persons) .";</script>";

?>
<main class="main country">
    <h2 class="countryName"><?php echo $persons[0]["country"]?></h2>
    <div class="athletes">
        <h2 class="top">Top 5 athletes</h2>
        <div class="slideshow"></div>
        <div class="rest"></div>
    </div>
    <script>
        $(".countryName").prepend(getCountryFlag(findGetParameter("id"), 64));
        let start = 0;
        let max = 100;
        const topAmount = 5
        const increment = 300;

        athletes = sortAthletes(athletes);

        for (let i = 0; i < topAmount; i++) {
            const athlete = athletes[i];
            if(!(athlete.score > 0)){
                if(i === 0){
                    $(".top").remove();
                }
                break;
            }
            const profile = athleteToProfile(athlete, Profile.CARD);
            profile.appendTo(".slideshow");
            start++;
        }

        new Slideshow($(".slideshow"));

        for (let i = start; i < Math.min(athletes.length, max); i++) {
            const profile = athleteToProfile(athletes[i]);
            profile.appendTo($(".rest"));
        }

        if(max < athletes.length){
            const btn = $(`<button class="btn default slide vertical">Load more</button>`);
            btn.click(() => {
                const start = max;
                max += increment;
                for (let i = start; i < Math.min(athletes.length, max); i++) {
                    const profile = athleteToProfile(athletes[i]);
                    profile.insertBefore(btn);
                }
            });
            if(max > athletes.length){
                btn.remove();
            }
            $(".athletes").append(btn);
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>