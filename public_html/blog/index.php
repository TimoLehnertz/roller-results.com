<?php
include_once "../header.php";
include_once "../api/index.php";

$logs = getAllDevLogs();

echoRandWallpaper();
?>
<main class="main competitions-page">
    <div class="top-site"></div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="section dark no-shadow">
        <h1><i class="fas fa-gavel margin right"></i>Developer blog</h1>
        <h4 style="font-size: 1.5rem; margin-bottom: 4rem;">Stay up to date with new features and bug fixes</h4>
        <div class="blogs">
        <?php
            foreach ($logs as $log) {
                $statusColor = "green";
                if($log["status"] == "working") {
                    $statusColor = "yellow";
                }
                if($log["status"] == "planned") {
                    $statusColor = "red";
                }
                echo "<div class='dev-log'>";
                echo "<p class='font size big margin bottom'>".$log["title"]." <span class='padding left right code font color $statusColor'>".$log["status"]."</span></p>";
                echo "<p>".$log["rowCreated"]." | </p><br>";
                echo "<p>".$log["description"]."</p>";
                if($log["image"] != NULL) {
                    echo "<br><img style='width: 90vw' src='".$log["image"]."'>";
                }
                echo "</div><br><hr><br>";
            }
            // print_r($logs);
        ?>
    </div>
</main>
<?php
include_once "../footer.php";
?>