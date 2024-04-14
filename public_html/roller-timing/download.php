<?php
include_once "../api/index.php";
include_once "../header.php";
echoRandWallpaper();

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
        <div class="flex">
            <div style="max-width: 45rem">
                <h1>What is Roller Timing?</h1>
                <p>Roller Timing is an all-in-one solution for timing your trainings, from simple laps to starts, checkpoints, parcours and much more.</p>
                <p>If you are interested in purchasing one, please contact me at timolehnertz1@gmail.com or DM me on the Roller Results Instagram page.</p>
            </div>
        </div>
    </div>
    <div class="dark section">
        <div class="flex">
            <div style="max-width: 45rem">
                <h1>Download</h1>
                <p>All devices with version 2.0 or higher support over-the-air software updates. This is the place to download the latest software.</p>
                <p>Software versions with the same major release are compatible with each other. For example, 2.1 is compatible with 2.0 but not with 1.0.</p>
                <p>Instructions for the firmware update process can be found on the update page of your device.</p>
                <br>
                <hr>
                <br>
                <h2>Versions</h2>
                <div>
                    <p class="font size big">3.1 <span class="font color light-green">(latest)</span> <a href="firmware/v3.1.zip" download>download</a></p>
                    <br>
                    <p class="font size big">Changelog</p>
                    <br>
                    <br>
                    <p><b>Improvements</b></p>
                    <br>
                    <ul>
                        <li>Improved LED brightness on stations</li>
                    </ul>
                    <br>
                    <p><b>Fixes</b></p>
                    <br>
                    <ul>
                        <li>Fixed Display and station appearing on the same WiFi name. Stations are now called Roller Timing station and displays are called Roller Timing (can be changed by the user)</li>
                    </ul>
                </div>
                <div>
                    <p class="font size big">3.0 <a href="firmware/v3.0.zip" download>download</a></p>
                    <br>
                    <p class="font size big">Changelog</p>
                    <br>
                    <p><b>New Features</b></p>
                    <br>
                    <ul>
                        <li>Added Parcour mode</li>
                    </ul>
                    <br>
                    <p><b>Improvements</b></p>
                    <br>
                    <ul>
                        <li>Improved web interface</li>
                        <li>Added popup to warn of incompatible software versions</li>
                    </ul>
                    <br>
                    <p><b>Fixes</b></p>
                    <br>
                    <ul>
                        <li>Fixed Display changing to station mode after factory reset or software update</li>
                    </ul>
                </div>
                <br>
                <hr>
                <br>
                <div>
                    <p class="font size big">2.1<a href="firmware/v2.1.zip" download>download</a></p>
                    <br>
                    <p class="font size big">Changelog</p>
                    <br>
                    <p><b>Improvements</b></p>
                    <br>
                    <ul>
                        <li>Added timout to station LEDs of 3 seconds to increase battery life</li>
                    </ul>
                </div>
                <br>
                <hr>
                <br>
                <div>
                    <p class="font size big">2.0 <a href="firmware/v2.0.zip" download>download</a></p>
                    <br>
                    <p class="font size big">Changelog</p>
                    <br>
                    <p><b>New Features</b></p>
                    <br>
                    <ul>
                        <li>Over-the-air updates</li>
                        <li>Increased maximum size of training</li>
                        <li>Added speed display</li>
                        <li>Added Bluetooth latency removal</li>
                        <li>Added the ability to change the device name and password</li>
                        <li>Added WiFi to laser stations</li>
                    </ul>
                    <br>
                    <p><b>Improvements</b></p>
                    <br>
                    <ul>
                        <li>Improved user interface</li>
                        <li>Increased live viewer speed</li>
                    </ul>
                    <br>
                    <p><b>Fixes</b></p>
                    <br>
                    <ul>
                        <li>Fixed reboot after a long training session</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include_once "../footer.php";
?>