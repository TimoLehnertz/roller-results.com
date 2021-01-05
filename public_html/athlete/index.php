<?php
include_once "../includes/error.php";
/**
 * Setup
 */
if(!isset($_GET["id"])){
    throwError($ERROR_NO_ID);
}
include_once "../api/index.php";
include_once "../api/imgAPI.php";

$person = getPerson($_GET["id"]);
$firstName = $person["firstName"];
$sureName = $person["sureName"];
$country = $person["country"];
$gender = $person["gender"];
$club = $person["club"];
$team = $person["team"];
$birthYear = $person["birthYear"];

if($birthYear < 1800 || !is_numeric($birthYear)){
    unset($birthYear);
}
if(empty($club)){
    unset($club);
}
if(empty($team)){
    unset($team);
}

if(!$person){
    throwError($ERROR_INVALID_ID);
}

include_once "../header.php";

echo "<script>const person = ". json_encode($person) .";</script>";
?>
<main class="main">
    
</main>
<script>
    const profile = new Profile(athleteToProfile(person));
    profile.appendTo($("main"));
</script>
<?php
include_once "../footer.php";
?>