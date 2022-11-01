<?php
include_once "../includes/error.php";
session_start();
if(isset($_GET["r"])){
    if($_GET["r"] != "3.1415"){
        returnHome();
    }
} else{
    returnHome();
}
if(!isset($_SESSION["username"])){
    returnHome();
}
$username = $_SESSION["username"];
include_once "../head.php";
?>
<body class="body login">
    <main class="main">
        <div class="center">
            <div class="welcome margin">
                <div class="flex">
                    <img src="/img/logo/rr.png" alt="Roller results" style="width: 4rem">
                </div>
                <h1>Welcome <?=$username?>!</h1>
                <h2>Good to have you onboard roller results!</h2>
                <br>
                <p>We send an email to <a><?=$_SESSION["email"]?></a> with instructions on how to complete your account on roller results.</p>
                <br>
                <!-- <p>You may want to</p> -->
                <!-- <p>Finish your profile setup or return home</p> -->
                <!-- <br> -->
                <!-- <br> -->
                <div class="flex justify-center gap">
                    <a href="/profile" class="btn create no-underline">Finish setup</a>
                    <a href="/index.php" class="btn create gray no-underline">Skip for now</a>
                </div>
            </div>
            <div class="mobile-only">
                <br>
                <br>
                <hr>
            </div>
            <div class="form margin left right double">
                <h2>Whats next?</h2>
                <br>
                <!-- <p>You will now have access to the following features:</p>
                <br> -->
                <br>
                <br>
                <a href="/performance" target="blank" class="btn create no-underline">Track your training progress</a>
                <br>
                <br>
                <p>Track and analyze your traingsprogress. Made to work well with big groups of athletes.</p>
                <br>
                <br>
                <a href="/analytics" target="blank" class="btn create yellow no-underline">Advanced results analytics</a>
                <br>
                <br>
                <p>Gain full accsess to our database using the power of visual database querying. Your account allows you to save and manage an unlimited amount of analytic projects.</p>
                <br>
                <br>
                <a href="/tools/import-project.php" target="blank" class="btn create green no-underline">Upload results</a>
                <br>
                <br>
                <p>Help the inline-speedskating comunity by uploading results using our simplified form. We put many hours into uploading results and have perfected the process of doing so. Now we made the tools that we use for uploading available to anybody. Go check it out!</p>
            </div>
        </div>
    </main>
</body>
</html>