<?php
include_once "../api/index.php";
include_once "../header.php";
echoRandWallpaper();
function echoTrainings() {
    if(!isLoggedIn()) {
        echo '<div class="flex mobile justify-center gap"><p>Please log in te enable this feature</p><br>
            <form action="/login/index.php" method="POST">
                <input type="text" name="returnTo" value="'.$_SERVER["REQUEST_URI"].'" hidden></input>
                <button type="submit" name="submit" class="btn create">Log in</button>
            </form></div>';
        return;
    }
    $trainings = getRollerTrainings();
    if(empty($trainings)) {
        echo "<p>You didnt upload any results yet</p>";
    } else {
        echo "<h2>Your trainings</h2>";
    }
    echo "<div class='flex column align center'>";
    foreach ($trainings as &$training) {
        $date=date_create($training["uploadDate"]);
        $dateStr = date_format($date,'Y.m.d');
        echo "
        <a class='flex justify-start gap' href='training.php?session={$training["session"]}'>
        <p>{$training["session"]}</p>
        <p>({$training["triggers"]}) Records</p>
        <p> uploaded at {$dateStr}</p>
        </a>";
    }
    echo "</div>";
}
?>
<main class="main competition-page">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest"><i class="fas fa-binoculars margin right"></i>Roller timing</h1>
        <p class="align center font size big color light margin top double">Your training laps in one place</p>
    </div>
    <div class="light section">
        <div>
            <?php
                echoTrainings();
            ?>
        </div>
    </div>
</main>
<?php
include_once "../footer.php";
?>