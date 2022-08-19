<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";
// echoRandWallpaper();
?>
<main class="main competition-page analytics">
    <!-- <div class="top-site"></div> -->
    <!-- <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg> -->
    <!-- <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg> -->
    <div class="light section">
        <h1 class="flex mobile font size biggest">Roller Toolbox</h1>
        <p class="align center font size big margin top double">
            Tools for trainers, speakers, athletes, organizers and enthusiasts
        </p>
    </div>
    <div class="section dark">
        <ul class="align center font size big margin top triple">
            <p><a href="race-flow">Race flow graphs<i class="fa fa-solid fa-chart-line margin left"></i></a></p>
            <!-- <p><a href="import.php">Import script</a></p> -->
            <!-- <p><a href="list-alias.php">List alias</a></p> -->
            <p><a href='speaker'><span class='code'>New</span>Speaker desk<i class="margin left fa fa-solid fa-desktop"></i></a></p>
            <p><a href='import-project.php'><span class='code'>New</span> Results upload<i class="fa margin left fa-solid fa-upload"></i></a></p>
            <p><a href='timing'>Timing<i class="fa margin left fa-solid fa-clock"></i></a></p>
            <p><a href='start'><span class='code'>New</span> Start gun<i class="fa fa-solid fa-gun"></i></a></p>
        </ul>
    </div>
</main>
<script>
</script>
<?php
    include_once "../footer.php";
?>