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

echo "<script>const persons = ". json_encode($persons) .";</script>";

?>
<main class="main">
    <h2>Country <?php echo $persons[0]["country"]?></h2>
    <div class="person-table"></div>
    <div class="persons"></div>
    <script>
        console.log(persons)
        let i = 0;
        for (const person of persons) {
            if(i > 100){
                break;
            }
            const profile = new Profile(athleteToProfile(person));
            profile.appendTo($(".persons"));
            i++
        }
    </script>
</main>
<?php
include_once "../footer.php";
?>