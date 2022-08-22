<?php
include_once "../api/index.php";
include_once "../header.php";
echoRandWallpaper();
?>
<main class="main">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="flex mobile font size biggest">Music</h1>
        <p class="align center font size big color light margin top double">
            Comunity spotify playlists
        </p>
    </div>
    <div class="light section">
        <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/28xsMoErMAb4Fhl1YXi4x4?utm_source=generator" width="100%" height="380" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
    </div>
</main>
<?php
include_once "../footer.php";
?>