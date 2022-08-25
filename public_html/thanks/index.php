<?php
include_once "../header.php";
include_once "../api/index.php";

$logs = getAllDevLogs();

echoRandWallpaper();
?>
<main class="main competitions-page">
    <div class="top-site"></div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="light section dark no-shadow">
        <h1>Thank you very much!💗</h1>
        <p class="align center">Your donation means a lot to us and will keep the project Growing</p>
        <p class="align center font color gray margin top">#rollerresults</p>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg)" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
</main>
<?php
include_once "../footer.php";
?>