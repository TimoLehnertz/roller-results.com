<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";

$aliases = getAliasGroups();
if(isset($_GET["alias"])) {
    $athletes = getAliasAthletes($_GET["alias"]);
    echo "<script>const athletes=".json_encode($athletes)."</script>";
}
?>
<main class="main">
    <form action="#" method="get" class="form">
        <select name="alias" id="aliasSelect">
            <option value="-1">Select</option>
            <?php
            foreach ($aliases as $alias) {
                echo "<option value='".$alias["aliasGroup"]."'>".$alias["aliasGroup"]." (".$alias["count"].")</option>";
            }?>
        </select>
        <button type="submit">Go</button>
    </form>

    <div class="athletes">
    </div>
</main>
<script>
    if(athletes != undefined) {
        for (const athlete of athletes) {
            const profile = new Profile(athleteDataToProfileData(athlete, false), Profile.MIN);
            console.log(profile);
            profile.appendTo($(".athletes"));
        }
    }
</script>
<?php
    include_once "../footer.php";
?>