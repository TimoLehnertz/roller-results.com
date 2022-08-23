<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../api/userAPI.php";

if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING);
}

$username = $_SESSION["username"];
$iduser = $_SESSION["iduser"];

// print_r($_POST);
$user = getUser($iduser);

if(isset($_POST["remove-athlete"])) {
    $removeAthleteSuccsess = removeAthleteProfile();
    unset($_POST["remove-athlete"]);
    header("location: /profile");
    exit();
}

$user = getUser($iduser);

if($user["athlete"] == NULL && isset($_POST["idLinkAthlete"])) {
    $setAthleteSuccsess = setAthleteProfile(intval($_POST["idLinkAthlete"]));
    unset($_POST["idLinkAthlete"]);
    header("location: /profile");
    exit();
}

$user = getUser($iduser);

include_once "../header.php";
echoRandWallpaper();
?>
<div class="absolute">
    <div class="img-display"></div>
</div>
<main class="main competition-page analytics race-flow">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest"><?=$username ?><i class="fa fa-solid fa-user margin left"></i></h1>
        <p class="align center font size big color light margin top double">
            Your <span class="font color orange">Roller</span> profile
        </p>
    </div>
    <div class="section light">
        <?php
// Messages
        if(isset($removeAthleteSuccsess)) {
            if(!$removeAthleteSuccsess) {
                echo "<p class='font color red'>An error occoured while removing your athlete profile please try again<?p>";
            } else {
                echo "<p class='font color green'>Your Athlete profile has removed</p>";
            }
        }
        if(isset($setAthleteSuccsess)) {
            if(!$setAthleteSuccsess) {
                echo "<p class='font color red'>An error occoured while setting your athlete profile please try again</p>";
            } else {
                echo "<p class='font color green'>Your Athlete profile has been updated succsessfully</p>";
            }
        }
        // echo "moin<br>";
        if($user["athlete"] == NULL) { ?>
            <form action="#" method="POST" onsubmit="return validateMyForm()">
                <h2>Who are you?</h2>
                <p class="align center">Link your athletes profile to your own profile</p>
                <div class="search-area"></div>
                <div class="link-athlete flex mobile"></div>
                <input id="idLinkAthlete" type="hidden" name="idLinkAthlete">
            </form>
            <?php } else { ?>
                <h2>Your <span class="font code color c">athlete profile</span></h2>
                <div class="flex column">
                    <div class="flex mobile justify-space-evenly" style="width: 100%">
                        <p>Your athlete profile on <span class="font code color b">Roller results</span></p>
                        <div class="your-athlete"></div>
                    </div>
                    <form action="#" method="POST">
                        <label for="remove-athlete">Not you?</label>
                        <input type="submit" class="btn slide style-1" id="remove-athlete" name="remove-athlete" value="Remove link">
                    </form>
                </div>
        <?php } ?>
    </div>
    <div class="section dark">
        <h2>Your content on Roller results</h2>
        <h3>Your competitions</h3>
        <div class="flex column">
            <?php
            $comps = getUsersCompetitions();
            if(sizeof($comps) == 0) {
                echo "<p>You didnt create any competitins yet</p>";
            }
            foreach ($comps as $comp) {
                echo "<a href='/competition?id=".$comp["idCompetition"]."'>".$comp["location"]." ".$comp["raceYear"]." ".$comp["type"]." </a>";
            }
            ?>
        </div>
        <br><br>
        <h3>Your <a href="/analytics">Analytics</a></h3>
        <div class="flex">
            <div class="flex column align-start gap">
                <?php
                $analytics = getUsersAnalytics();
                if(sizeof($analytics) == 0) {
                    echo "<p>create your own analytics a href='/analytics'>here</a></p>";
                }
                foreach ($analytics as $analytic) {
                    $public = "<span class='code margin right padding left'>".($analytic["public"] == "1" ? "public" : "private")."</span>";
                    echo "<p>$public".$analytic["name"]."</p>";
                }
                ?>
            </div>
        </div>
    </div>
</main>
<script>

let existingLinkId = <?php 
    if($user["athlete"] != NULL) {
        echo $user["athlete"];
    } else {
        echo "-1";
    }
?>;
let linkId = -1;

function validateMyForm() {
    return linkId >= 0;
}

const athleteSearch = new SearchBarSmall(["Athlete"], false, (option) => {
    linkId = option.id;
    $("#idLinkAthlete").val(option.id);
    $(".link-athlete").empty();
    const profile = new Profile(athleteDataToProfileData({idAthlete: option.id}));
    profile.update();
    $(".link-athlete").append("<p>Is this you?</p>");
    profile.appendTo($(".link-athlete"));
    $(".link-athlete").append("<input type='submit' name='setLinkAthlete' class='btn slide style-1' value='Yes save'>");
});
$(".search-area").append(athleteSearch.elem);

function loadExistingUser() {
    const profile = new Profile(athleteDataToProfileData({idAthlete: existingLinkId}), Profile.CARD);
    profile.update();
    profile.appendTo($(".your-athlete"));
}
if(existingLinkId >= 0) {
    loadExistingUser();
}

</script>
<?php
include_once "../footer.php";
?>