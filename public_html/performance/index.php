<?php

/**
 * Index page of performance feature
 * 
 * Displays an overview of the logged in profile showing all reached goals and a list of all performance categories
 * When not logged in this site will only show a mark up and redirect to login as performance groups are only to be used with a valid account
 */

$noHeaderSearchBar = true;
// Include the header file for the page
include_once "../header.php";
// Include necessary API and error handling files
include_once "../api/index.php";
include_once "../includes/error.php";

// retrieve current user from DB if logged in
// Initialize an array to store the user's information
// If the user is logged in, retrieve their information from the database
// Otherwise, use default values for the user's image and name
$user = ["image" => defaultProfileImgPath("m")];
if(isLoggedIn()) {
    $user = getUser($_SESSION["iduser"]);
}

// Retrieve all performance categories from the database
$categories = getPerformanceCategories();

// Initialize variables to keep track of the number of goals and reached goals
$goals = 0;
$reached = 0;

// Iterate through the performance categories to count the number of goals and reached goals
foreach ($categories as $category) {
    if($category["goal"] != NULL && $category["goal"] != 0) $goals++;
    if($category["progress"] != NULL && $category["progress"] >= 1) $reached++;
}

// Initialize a variable to determine whether to show activities for the first performance category
$showActivities = false;
$firstCategory;

// If the user is logged in and there are performance categories available, get the full information for the first category
if(isLoggedIn() && sizeof($categories) > 0) {
    $firstCategory = getFullperformanceCategory($categories[0]["idPerformanceCategory"]);
    foreach ($firstCategory["records"] as $record) {
        if($record["user"] == $_SESSION["iduser"]) {
            $showActivities = true;
            break;
        }
    }
}

// If there are records for the user in the first performance category, output a JavaScript variable containing the records
if($showActivities) {
?>
<script>
    // Output the records for the first performance category as a JavaScript variable
    const records = <?=json_encode($firstCategory["records"])?>;
</script>
<?php } ?>
<main class="performance">
    <h1 class="align center">Your performance</h1>
    <div class="flex-mobile">
        <div class="upper-section">
            <div class="profile-img">
                <img src="<?=$user["image"] ?>" alt="Profile picture">
            </div>
            <div class="mobile-upload">
                <?php if(isLoggedIn()) { ?>
                <a class="btn create no-underline" href="upload.php">Upload</a>
                <?php } ?>
            </div>
            <!-- User's name and login form (if not logged in) -->
            <div>
                <div>
                    <?php if(isLoggedIn()) { ?>
                    <p class="username"><?=$user["username"]?></p>
                    <p class="realname"><?=$user["firstname"] ?? ""?> <?=$user["lastname"] ?? ""?></p>
                    <?php } else { ?>
                    <!-- Redirect back to this page after logging in -->
                    <form action="/login/index.php" method="POST">
                        <input type="text" name="returnTo" value="<?=$_SERVER["REQUEST_URI"]?>" hidden></input>
                        <button type="submit" name="submit" class="btn create">Log in</button>
                    </form>
                    <?php } ?>
                </div>
            </div>
            <!-- Number of goals reached -->
            <div class="goals-wrapper">
                <div class="goals">
                    <p><span class="number"><?=$reached?> / <?=$goals?></span> Personal goals reached</p>
                </div>
            </div>
            <!-- Link to upload page, displayed on desktop devices -->
            <div class="pc-upload">
                <a class="btn default round no-underline no-border" href="upload.php">Upload new data</a>
            </div>
        </div>
        <div class="lower-section">
             <!-- List of performance categories -->
            <div class="list">
                <?php
                foreach ($categories as $category) {
                    echo "<a href='performance.php?id=".$category["idPerformanceCategory"]."' class='flex gap no-underline category-wrapper'>";
                    echoPerformanceCategory($category);
                    echo "<div class='btn plus'><img src=\"/img/arrow-right.png\" alt='>'></div>";
                    echo "</a>";
                }
                ?>
            </div>
            <div class="show-more flex"></div>
            <br>
            <br>
            <div class="align center">
                <?php if(isLoggedIn()) { ?>
                <a class="btn default round no-underline no-border" href="create.php">+ Create Category</a>
                <?php } else { ?>
                <p class="font size big margin bottom double">Login to use the free performance tracking features of roller results.</p>
                <p class="">Here you can Upload your trainings progress, analize and compare to other athletes.</p>
                <?php } ?>
            </div>
            <br>
            <br>
        </div>
    </div>
    <div class="margin top left right double">
        <h2 class="align center">Latest uploads</h2>
        <br>
        <?php if($showActivities) { ?>
        <h3><?=$firstCategory["name"]?></h3>
        <div class="graph">
            <canvas id="line-chart" width="800" height="200"></canvas>
        </div>
        <br>
        <br>
        <br>
        <div>
            <h3 class="align center">Last uploads</h3>
            <?php
                $lastUploads = getLastPerformanceUploads();

                // print_r($lastUploads);

                function formatMysqlDate($mysqlDate) {
                    $phpdate = strtotime($mysqlDate);
                    return date('D d.m.Y', $phpdate);
                }

                $lastDate = "";
                foreach ($lastUploads as $upload) {
                    if($upload["user"] != $_SESSION["iduser"]) continue;
                    $newDate = formatMysqlDate($upload["rowCreated"]);
                    $name = $upload["name"];
                    $value = $upload["value"];
                    $short = getPerformanceGroupTypeShort($upload["type"]);
                    if($lastDate != $newDate) {
                        $lastDate = $newDate;
                        echo "<br><p>$newDate</p>";
                    }
                    echo "<p>You uploaded a new record of $value$short to $name.</p><br>";
                }
            ?>
            <?php } else { ?>
        </div>
        <br>
        <p class="margin left right">As soon as you start uplaoding your performances here you will be presented by an overview of your last activities</p>
        <br>
        <div class="flex">
            <?php if(isLoggedIn()) { ?>
            <a href="upload.php" class="btn create no-underline">Upload now</a>
            <?php } else {?>
            <!-- <a class="btn create no-underline" href="login.php">Upload</a> -->
            <?php } ?>
        </div>
        <br>
        <br>
        <?php } ?>
    </div>
</main>
<script>
    const maxDisplay = isMobile() ? 5 : 15;
    $(".category-wrapper").each(function(i) {
        if(i >= maxDisplay) $(this).hide();
    });
    if($(".category-wrapper").length > maxDisplay) {
        const elem = $(`<button class="btn default round margin no-border top">Show more</button>`);
        elem.click(() => {
            elem.hide();
            $(".category-wrapper").show();
        })
        $(".show-more").append(elem);
    }
    <?php if($showActivities) { ?>
    const chart = initPerformanceChart(records, document.getElementById("line-chart"));
    chart.data.datasets.forEach(function(ds) {
        ds.hidden = ds.idUser != phpUser.iduser;
    });
    <?php } ?>
</script>
<?php
    include_once "../footer.php";
?>