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

$team = getTeam($_GET["id"]);
if(!$team){
    throwError($ERROR_INVALID_ID);
}
$teamName = $team["name"];
$teamImage = $team["image"];
$description = $team["description"];
$instagram = $team["instagram"];
$facebook = $team["facebook"];
$youtube = $team["youtube"];
$website = $team["website"];


include_once "../header.php";
echo "<script>const team = ". json_encode($team) .";</script>";
?>
<div class="rand-wallpaper">
    <img src="<?=$teamImage?>" alt="Image">
</div>
<div class="top-site" style="min-height: 50vh;"></div>
<main class="main">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <section class="section light no-shadow">
        <h1 class="align center margin top triple font size bigger"><?=$teamName?></h1>
        <p><?=$description?></p>
        <br>
        <?php if($website) { ?>
            <a class="font size bigger-medium" target="_blank" rel="noopener noreferrer" href="<?=$website?>">Official <?=$teamName?> website<i class="fa fa-link"></i></a>
        <?php } ?>
        <a href=""></a>
    </section>
    <section class="section dark">
        <div class="team-members">
            <div class="index-card">
                <h2>Team members</h2>
                <ul>
                    <li>All Athletes that have been racing with <?=$teamName?></li>
                    <li class="top-five">Members<i class="fas fa-angle-double-right arrow-right" aria-hidden="true"></i></li>
                    <li class="mobile-only margin top">Swipe left to reveal skaters</li>
                </ul>
            </div>
        </div>
    </section>
    <script>
        const slideShow = new Slideshow($(".team-members"));
        for (const memberId of team.members.split(",")) {
            const profile = athleteToProfile({id: memberId}, Profile.CARD);
            profile.appendTo(".team-members");
            profile.update();
        }
    </script>
        <section class="section light">
            <div class="flex mobile justify-center">
                <p class="font size big bold">Follow <?=$teamName?>:</p>
                <div class="flex row social-media margin left">
                    <?php if($instagram) { ?>
                        <a target="_blank" rel="noopener noreferrer" href="<?=$instagram?>" class="no-underline"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <?php }?>
                    <?php if($youtube) { ?>
                        <a target="_blank" rel="noopener noreferrer" href="<?=$youtube?>" class="no-underline"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                    <?php }?>
                    <?php if($facebook) { ?>
                        <a target="_blank" rel="noopener noreferrer" href="<?=$facebook?>" class="no-underline"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                    <?php }?>
                </div>
            </div>
        </section>
</main>
<?php
include_once "../footer.php";
?>