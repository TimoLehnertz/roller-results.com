<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../api/imgAPI.php";
include_once "../api/userAPI.php";

if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING);
}

$username = $_SESSION["username"];
$iduser = $_SESSION["iduser"];

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

if($user["athlete"] != NULL) {
    $linkedAthlete = getAthlete($user["athlete"]);
}
if($user["athlete"] != NULL && $user["athleteChecked"] == "1") {
    if(isset($_POST["submit-athlete"]) && isset($_POST["instagram"]) && isset($_POST["facebook"]) && isset($_POST["website"]) && isset($_POST["description"]) && isset($_POST["team"]) && isset($_POST["club"]) && isset($_POST["country"])) {
        $img = NULL;
        // var_dump($_FILES);
        if(isset($_FILES["image"]) && strlen($_FILES["image"]["tmp_name"]) > 0){
            // echo "image";
            $img = uploadImg($_FILES["image"], "athlete-".$linkedAthlete["firstname"]."-".$linkedAthlete["lastname"]."-");
            // echo $img;
        }
        $updateAthleteSuccsess = updateAthleteInfo($linkedAthlete["id"], $_POST["instagram"], $_POST["facebook"], $_POST["website"], $_POST["description"], $_POST["team"], $_POST["club"], $img, $_POST["country"]);
        if(!$updateAthleteSuccsess) {
            throwError($ERROR_UPDATING_ATHLETE, "/profile");
        }
        header("location: /profile");
        exit();
        $linkedAthlete = getAthlete($user["athlete"]);
    }
}

function echoCountrySelect($preselect) {
    $countries = getAllCountries();
    echo "<select id='country' name='country'>";
    foreach ($countries as $country) {
        $selected = "";
        if($preselect == $country["country"]) $selected = " selected";
        echo "<option value='".$country["country"]."'$selected>".$country["country"]."</option>";
    }
    echo "</select>";
}

include_once "../header.php";
echoRandWallpaper();
?>
<div class="absolute">
    <div class="img-display"></div>
</div>
<main class="main competition-page user-profile">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <?php if(isset($_GET["ev"])) { ?>
        <div class="padding top bottom flex mobile justify-center gap" style="background: #444">
            <p class="font color orange font size big">Your email has been verified 📧 </p>
            <?php if($user["athlete"] == NULL) { ?>
                <br>
                <div class="flex">
                    <p>Finish your profile by linking it to your athlete profile.<br>When linked send us a mail at <a>roller.results@gmail.com</a>.<br>We will unlock your profile so you can edit all your athletes data.</p>
                </div>
        <?php }echo "</div>";} ?>
        <h1 class="font size biggest"><?=$username ?></h1>
        <p class="align center font size big color light margin top double">
            Your <span class="font color orange">Roller results</span> profile
        </p>
    </div>
    <div class="section light">
        <?php
//      Messages
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
                <div class="link-athlete flex mobile justify-center gap"></div>
                <input id="idLinkAthlete" type="hidden" name="idLinkAthlete">
            </form>
            <?php } else { ?>
                <h2>Your <span class="font code color c">athlete profile</span></h2>
                <div class="flex column">
                    <div class="flex mobile justify-space-evenly" style="width: 100%">
                        <div>
                        <?php if($user["athleteChecked"] == "1") { ?>
                            <form action="#" class="form" style="background: #ccc" method="POST" enctype="multipart/form-data">
                                <h3>Update your athlete profile</h3>
                                <div class="img-area">
                                    <label class="img-label" for="image">
                                    <?php if(!empty($linkedAthlete["image"])) { ?>
                                        <img class="update-athlete-img" src="/img/uploads/<?=$linkedAthlete["image"] ?>" alt="profile image">
                                    <?php } else if($linkedAthlete["gender"] == "m") {?>
                                        <img class="update-athlete-img"  src="/img/profile-men.png" alt="profile image">
                                    <?php } else { ?>
                                        <img class="update-athlete-img"  src="/img/profile-female.png" alt="profile image">
                                    <?php } ?>
                                    </label>
                                    <input type="file" id="image" name="image" value="Upload" class="btn blender alone">
                                </div>
                                <div>
                                    <label for="country">Country</label>
                                    <?php echoCountrySelect($linkedAthlete["country"]); ?>
                                </div>
                                <div>
                                    <label for="instagram">Instagram(link to profile):</label>
                                    <input type="text" id="instagram" name="instagram" value="<?php echo $linkedAthlete["instagram"]; ?>">
                                </div>
                                <div>
                                    <label for="facebook">Facebook(link to profile):</label>
                                    <input type="text" name="facebook" id="facebook" value="<?php echo $linkedAthlete["facebook"]; ?>">
                                </div>
                                <div>
                                    <label for="website">Website:</label>
                                    <input type="text" name="website" id="website" value="<?php echo $linkedAthlete["website"]; ?>">
                                </div>
                                <div>
                                    <label for="team">Team / Sponsor:</label>
                                    <input type="text" name="team" id="team" value="<?php echo $linkedAthlete["team"]; ?>">
                                </div>
                                <div>
                                    <label for="club">Club:</label>
                                    <input type="text" name="club" id="club" value="<?php echo $linkedAthlete["club"]; ?>">
                                </div>
                                <div class="flex column">
                                    <label for="description">Short description about yourself:</label>
                                    <br>
                                    <textarea style="background: #ddd; resize: vertical;" name="description" id="description" cols="30" rows="10" ><?php echo $linkedAthlete["description"]; ?></textarea>
                                </div>
                                <img src="">
                                <br>
                                <input class="btn" type="submit" name="submit-athlete" value="Save changes">
                            </form>
                        <?php } else { ?>
                            <!-- <h3>Your athlete profile on <span class="font code color b">Roller results</span></h3><br> -->
                            <p>Your profile isn't verified yet.<br>Contact us on any platfotm to verify that this is you.<br>We do this to ensure nobody can publish false information about you.</p>
                            <br>
                            <p>Contact us here</p>
                            <ul>
                                <li><a href="https://www.instagram.com/roller_results/"><i class="fab fa-instagram font color black margin right"></i>Instagram</a></li>
                                <li><a href="https://www.facebook.com/RollerResults"><i class="fab fa-facebook font color black margin right"></i>Facebook</a></li>
                                <li>Email: <a>roller.results@gmail.com</a></li>
                            </ul>
                            <br>
                            <br>
                            <br>
                            <form action="#" method="POST">
                                <details>
                                    <summary>Not you?</summary>
                                    <br>
                                    <input type="submit" class="btn create red" id="remove-athlete" name="remove-athlete" value="Remove link">
                                </details>
                            </form>
                            <?php }?>
                        </div>
                        <div class="your-athlete"></div>
                    </div>
                </div>
        <?php } ?>
    </div>
    <div class="section dark">
        <h2>Your content on Roller results</h2>
        <h3>Your performance</h3>
        <div class="flex">
            <a href="/performance" class="btn create no-underline">Check your performance page</a>
        </div>
        <br>
        <br>
        <br>
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
        <h3>Your analytics</h3>
        <div class="flex">
            <div class="flex column align-start gap">
                <?php
                $analytics = getUsersAnalytics();
                if(sizeof($analytics) == 0) {
                    echo "<p>create your own analytics <a href='/analytics'>here</a></p>";
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

let existingAthlete = <?php 
    if(isset($linkedAthlete)) {
        echo json_encode($linkedAthlete);
    } else {
        echo "undefined";
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
    $(".link-athlete").append("<input type='submit' name='setLinkAthlete' class='btn create' value='Yes save'>");
    profile.appendTo($(".link-athlete"));
});
$(".search-area").append(athleteSearch.elem);

function loadExistingUser() {
    const profile = new Profile(athleteDataToProfileData(existingAthlete), Profile.CARD);
    profile.update();
    profile.appendTo($(".your-athlete"));
}
if(existingAthlete !== undefined) {
    loadExistingUser();
}

</script>
<?php
include_once "../footer.php";
?>