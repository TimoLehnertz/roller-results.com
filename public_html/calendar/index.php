<?php
include_once "../header.php";
include_once $_SERVER["DOCUMENT_ROOT"]."/api/index.php";

$comps = getAllCompetitions();

echoRandWallpaper();
?>
<main class="main competitions-page">
<iframe id="open-web-calendar" 
    style="background:url('https://raw.githubusercontent.com/niccokunzmann/open-web-calendar/master/static/img/loaders/circular-loader.gif') center center no-repeat;"
    src="https://open-web-calendar.herokuapp.com/calendar.html?url=https%3A%2F%2Fcalendar.google.com%2Fcalendar%2Fical%2Fq1pj0ferd2biqsbj3i105rjhuo%2540group.calendar.google.com%2Fpublic%2Fbasic.ics&amp;language=en"
    sandbox="allow-scripts allow-same-origin allow-top-navigation"
    allowTransparency="true" scrolling="no" 
    frameborder="0" height="600px" width="100%"></iframe>
</main>
<?php
include_once "../footer.php";
?>