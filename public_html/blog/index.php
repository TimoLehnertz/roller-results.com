<?php
include_once "../api/index.php";

if(isset($_POST["feature-request"]) && isset($_POST["title"]) && isset($_POST["description"])) {
    $requestFeatueSuccsess = requestFeatue($_POST["title"], $_POST["description"]);
    unset($_POST["feature-request"]);
}
$logs = getAllDevLogs();

include_once "../header.php";
echoRandWallpaper();
?>
<script>
    if (window.history.replaceState) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<main class="main competitions-page">
    <div class="top-site"></div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="section dark no-shadow">
        <h1><i class="fas fa-gavel margin right"></i>Developer blog</h1>
        <h4 style="font-size: 1.5rem; margin-bottom: 4rem;">Stay up to date with new features and bug fixes</h4>
        <div class="flex mobile align-start reversed">
            <div class="blogs" style="position: sticky; top: 10rem">
            <?php
                foreach ($logs as $log) {
                    $statusColor = "green";
                    if($log["status"] == "working") {
                        $statusColor = "yellow";
                    }
                    if($log["status"] == "planned") {
                        $statusColor = "orange";
                    }
                    if($log["status"] == "Requested") {
                        $statusColor = "red";
                    }
                    echo "<div class='dev-log'>";
                    echo "<p class='font size big margin bottom'>".$log["title"]." <span class='padding left right code font color $statusColor'>".$log["status"]."</span></p>";
                    echo "<p>".$log["rowCreated"]."</p><br>";
                    echo "<p>".$log["description"]."</p>";
                    if($log["image"] != NULL) {
                        echo "<br><img style='max-width: 100%' src='".$log["image"]."'>";
                    }
                    echo "</div><br><hr><br>";
                }
                // print_r($logs);
            ?>
            </div>
            <div style="height: 100%">
            <h1>Request a feature</h1>
            <?php if(isLoggedIn()) { ?>
                <form class="form" action="#" method="POST">
                    <?php
                        if(isset($requestFeatueSuccsess)) {
                            if(!$requestFeatueSuccsess) echo "<p class='font color red margin top bottom'>This request exists already</p>";
                            else echo "<p class='font color green margin top bottom'>Your feature got requested</p>";
                        }
                    ?>
                    <div>
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="title" required>
                    </div>
                    <div>
                        <label for="description">Description</label><br>
                        <textarea rows="7" cols="30" style="resize: vertical" type="text" name="description" id="description" placeholder="description" required></textarea>
                    </div>
                    <br>
                    <input class="btn blender alone" type="submit" name="feature-request" value="Request feature">
                </form>
                <?php } else { ?>
                    <p>You need to be logged in to request features</p>
                <?php } ?>
            </div>
        </div>
</main>
<?php
include_once "../footer.php";
?>