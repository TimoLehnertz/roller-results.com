<?php
include_once "../../header.php";
include_once "../../api/index.php";
echoRandWallpaper();
?>
<main class="main competition-page analytics">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest">Speaker desk <i class="margin left fa fa-solid fa-desktop"></i></h1>
        <p class="align center font size big color light margin top double">
            Professional live support for speakers on Inline speedskating events
        </p>
    </div>
    <div class="section light">
        <div class="flex mobile gap">
            <div>
                <div class="flex column gap">
                    <p class="font size big">What?</p>
                    <div>
                        <p>Our speaker desk connects your startlists with the biggest skating database in existance.</p>
                        <p>Starting with a brief overview of every skater you can explore every athletes highs and lows by one simple click.</p>
                    </div>
                </div>
                <br>
                <hr>
                <br>
                <div class="flex column gap">
                    <p class="font size big">Reliable</p>
                    <p>Developed and tested for the Arena geisingen International Live stream the AGI team and we can fully trust the system.</p>
                </div>
                <br>
                <hr>
                <br>
                <div class="flex column gap">
                    <p class="font size big">How does it work?</p>
                    <p>We connect roller-results to your resultservice to get the newest startlists. Later you select the next race per dropdown menu and our server will provide you with all sportlers favorite distances, medals and career data.</p>
                </div>
            </div>
            <img src="/img/speaker.jpg" alt="Speakerdesk" style="max-height: 70vh; width: auto">
        </div>
    </div>
    <section class="section dark">
        <br>
        <h2>Contact us on <span class="code padding left right">roller.results@gmail.com</span> if you are interested</h2>
    </section>
</main>
<?php
include_once "../../footer.php";
?>