<?php
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../api/imgAPI.php";

/**
 * Setup
 */
if(!isset($_GET["id"])) {
    throwError($ERROR_NO_ID);
}
$id = $_GET["id"];

$athlete = getAthlete($id);
// if(sizeof($athlete) == 0) {
//     throwError($ERROR_INVALID_ID);
//     exit();
// }

include_once "../header.php";


// echo "<script>const person = ". json_encode($person) ."; const id=".$_GET["id"]."</script>";
// echo "<script>const id=$id</script>";
// echo "<script>const athlete=".getAthlete($id)."</script>";
?>
<script>
    const athlete = <?=json_encode($athlete)?>;
    const id = <?=$id?>;
</script>
<main class="main">
    <h1><?=$athlete["firstname"]." ".$athlete["lastname"]?>'s Athlete profile</h1>
    <h2><?=$athlete["firstname"]." ".$athlete["lastname"]?> - See all his results and images</h2>
    <p>Results back from 1937</p>
</main>
<script>
    // const placeholder = athleteToProfile({}, Profile.MAX);
    // get("athlete", id).receive((succsess, athlete) => {
    //     console.log(athlete)
    //     if(!succsess) {
    //         window.location.href = "/index.php";
    //     }
        const profile = athleteToProfile(athlete, Profile.MAX);
    //     profile.update();
    // });
</script>
<?php
include_once "../footer.php";
?>