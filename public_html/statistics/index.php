<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../api/imgAPI.php";
include_once "../api/userAPI.php";

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
        <h1 class="font size biggest">Statistics</h1>
    </div>
</main>
<script>
</script>
<?php
include_once "../footer.php";
?>