<?php
$noHeaderSearchBar = true;
include_once "../header.php";
include_once "../api/index.php";
include_once "../includes/error.php";


$user = ["image" => defaultProfileImgPath("m")];
if(isLoggedIn()) {
    $user = getUser($_SESSION["iduser"]);
}

$categories = getPerformanceCategories();
$goals = 0;
$reached = 0;
foreach ($categories as $category) {
    if($category["goal"] != NULL && $category["goal"] != 0) $goals++;
    if($category["progress"] != NULL && $category["progress"] >= 1) $reached++;
}
// print_r($user);
$showActivities = false;
$firstCategory;
if(isLoggedIn() && sizeof($categories) > 0) {
    $firstCategory = getFullperformanceCategory($categories[0]["idPerformanceCategory"]);
    foreach ($firstCategory["records"] as $record) {
        if($record["user"] == $_SESSION["iduser"]) {
            $showActivities = true;
            break;
        }
    }
}

if($showActivities) {
?>
<script>
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
            <div>
                <div>
                    <p class="username"><?=$user["username"] ?? "<a href='/login' class='btn create no-underline'>Login</a>"?></p>
                    <p class="realname"><?=$user["firstname"] ?? ""?> <?=$user["lastname"] ?? ""?></p>
                </div>
            </div>
            <div class="goals-wrapper">
                <div class="goals">
                    <p><span class="number"><?=$reached?> / <?=$goals?></span> Personal goals reached</p>
                </div>
            </div>
            <div class="pc-upload">
                <a class="btn default round no-underline no-border" href="upload.php">Upload new data</a>
            </div>
        </div>
        <div class="lower-section">
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
        <h2 class="align center">Your last activities</h2>
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