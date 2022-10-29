<?php
include_once "../api/index.php";
include_once "../includes/error.php";
if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/performance");
}

if(!isset($_GET["id"])) {
    throwError($INVALID_ARGUMENTS, "/performance");
}

$goalError = "";
$editError = "";

if(isset($_POST["submit"])) {
    if(validateObjectProperties($_POST, [
        [
            "property" => "set-goal",
            "value" => "1"
        ],[
            "property" => "new-goal",
            "type" => "number",
        ]
    ], false)) {
        if(!updateGoalOnGroup($_GET["id"], $_POST["new-goal"])) {
            $goalError = "<span class='font color red'>Could not update Goal</span>";
        }
    }

    if(validateObjectProperties($_POST, [
        [
            "property" => "name",
            "type" => "string",
            "maxLength" => 50
        ],[
            "property" => "description",
            "type" => "string",
            "maxLength" => 200
        ]
    ], true)) {
        if(!editPerformanceCategory($_GET["id"], $_POST["name"], $_POST["description"])) {
            $editError = "<span class='font color red'>Could not edit performance category :(</span>";
        } else { // succsess
            header("location: /performance/performance.php?id=".$_GET["id"]);
        }
    }
}

$performance = getFullperformanceCategory($_GET["id"]);
if(!$performance) {
    throwError($ERROR_NO_PERMISSION, "/performance");
}
$recordsText = "no records yet";
if(sizeof($performance["records"]) == 1) {
    $recordsText = "1 record";
}
if(sizeof($performance["records"]) > 1) {
    $recordsText = sizeof($performance["records"])." records";
}

$admin = amIAdminInPerformanceCategory($_GET["id"]);
$creator = doIOwnPerformanceCategory($_GET["id"]);

$noHeaderSearchBar = true;
include_once "../header.php";
?>
<script>
    const oldGoal = <?=$performance["goal"] | 0?>;
    const records = <?=json_encode($performance["records"])?>;
    const idPerformanceCategory = <?=json_encode($performance["idPerformanceCategory"])?>;
</script>
<main class="performance">
    <h1 class="align center"><?=$performance["name"]?></h1>
    <a href="/performance"><h2 class="align center font color white">< See all</h2></a>
    <br>
    <div class="flex-mobile">
        <div>
            <?=$editError?>
            <form action="#" method="POST" autocomplete="off">
                <div class="flex justify-space-between">
                    <p></p>
                    <p class="records-amount"><?=$recordsText?></p>
                </div>
                <br>
                <div class="flex justify-space-between">
                    <div class="flex justify-start wrap">
                        <?php if($admin) { ?>
                        <input autocomplete="false" type="text" name="name" id="name" maxlength="50" class="editable-input" value="<?=$performance["name"] ?>">
                        <label for="name"><img class="edit-img" src="/img/edit.png" alt="edit"></label>
                        <?php } else { ?>
                        <p class="name"><?=$performance["name"] ?></p>
                        <?php } ?>
                    </div>
                </div>
                <br>
                <?php if($admin) { ?>
                <!-- <label for="description"><img class="edit-img" src="/img/edit.png" alt="edit"></label> -->
                <textarea autocomplete="false" style="resize: none" name="description" id="description" cols="30" rows="5" class="editable-textarea description" placeholder="Add a description to this category"><?=$performance["description"]?></textarea>
                <?php } else { ?>
                <p class="name"><?=$performance["description"] ?></p>
                <?php } ?>
                <div class="flex">
                    <?php
                $personalRecord = getPersonalRecordFromPerformanceCategory($performance);
                // if($personalRecord) {
                //     echo "<a href='upload.php?pid=".$performance["idPerformanceCategory"]."&gop=1' class='btn create margin top no-underline'>Upload now</a>";
                // }
                ?>
                </div>
                <br>
                <div class="flex row justify-space-evenly gap your-record align-center">
                    <p class="align center">Personal best</p>
                    <div class="flex row">
                    <?php
                    if(!$personalRecord) {
                        echo "<a href='upload.php?pid=".$performance["idPerformanceCategory"]."&gop=1' class='btn create no-underline'>Upload now</a>";
                    } else {
                        echo "<p class='record'>$personalRecord</p>";
                    }
                    ?>
                    </div>
                </div>
                <br>
                <?=$goalError?>
                <?php if($performance["goal"] != NULL) { ?>
                <div class="flex row justify-space-evenly gap your-record align-center">
                    <p class="align center">Your Goal</p>
                    <p class="your-goal"><?=$performance["goal"].getPerformanceGroupTypeShort($performance["type"])?></p>
                </div>
                <br>
                <?php echoProgress($performance);} ?>
                <br>
                <div class="flex gap align-center">
                    <div class="new-goal">
                        <label for="new-goal" class="performance-label">New goal (<?=getPerformanceGroupTypeMetricLong($performance["type"])?>)</label>
                        <input type="number" name="new-goal" id="new-goal" class="performance-input">
                        <input type="text" name="set-goal" id="set-goal" hidden value="0">
                    </div>
                    <button type="button" class="set-goal-btn btn create gray" onclick="toggleGoal()">Set a <?php if($performance["goal"] != NULL) echo "new";?> goal</button>
                </div>
                <br>
                <div class="flex gap justify-center">
                <a href="manage-athletes.php?id=<?=$_GET["id"]?>" class="no-underline btn create gray">See members</a>
                <?php if($personalRecord) { ?>
                    <a href='upload.php?pid=<?=$performance["idPerformanceCategory"]?>"&gop=1' class='btn create no-underline'>Upload</a>
                    <?php } ?>
                </div>
                <br>
                <div class="flex justify-center gap">
                    <a href="/performance/performance.php?id=<?=$_GET["id"]?>" class="no-underline btn create gray">Reset</a>
                    <button name="submit" type="submit" class="btn create ">Save</button>
                </div>
            </form>
            <br>
            <?php if($creator) { ?>
            <div class="pc-only">
                <br>
                <br>
                <br>
                <form action="delete-performance.php" method="POST">
                    <div class="flex">
                        <input type="text" name="id" value="<?=$performance["idPerformanceCategory"]?>" hidden>
                        <button type="submit" name="submit" class="btn create red">Delete this group</button>
                    </div>
                </form>
            </div>
            <?php } ?>
            </div>
        <div>
            <h2 class="">Results</h2>
            <br>
            <div class="results-options">
                <input type="radio" id="table" name="graph-table" value="graph" checked hidden>
                <label for="table">Graph</label>
                <input type="radio" id="graph" name="graph-table" value="table" hidden>
                <label for="graph">Table</label>

                <input type="radio" id="you" name="you-all" value="you" hidden>
                <label for="you">You</label>
                <input type="radio" id="all" name="you-all" value="all" checked hidden>
                <label for="all">All</label>
            </div>
            <br>
            <br>
            <div class="graph">
                
            </div>
            <div class="table flex column">
                <?php
                function formatMysqlDate($mysqlDate) {
                    $phpdate = strtotime($mysqlDate);
                    return date('D d.m.Y', $phpdate);
                }

                function echoDate($date) {
                    echo "<p>$date</p>";
                }

                function canIEditRecord($record) {
                    global $admin;
                    if($record["user"] == $_SESSION["iduser"]) return true;
                    return $admin;
                }

                function echoRecord($record) {
                    global $performance;
                    $idRecord = $record["idPerformanceRecord"];
                    $username = $record["username"];
                    $comment = $record["comment"];
                    if(strlen($comment) > 0) $comment = "Comment: $comment";
                    $value = $record["value"].getPerformanceGroupTypeShort($performance["type"]);
                    $editSection = "";
                    if(canIEditRecord($record)) {
                        $editSection .= "<button onclick='deleteRecord($idRecord)' class='btn create red'>Delete</button>";
                    }
                    $youClass = "not-you";
                    if($record["user"] == $_SESSION["iduser"]) $youClass = "you";
                    echo "<div class='tabel-record $idRecord $youClass'>
                            <div class='top'>
                                <p>$username</p>
                                <p>$value</p>
                            </div>
                            <div class='bottom' hidden>
                                <p class='comment'>$comment</p>
                                <div class='flex justify-space-evenly'>
                                    $editSection
                                </div>
                            </div>
                        </div>";
                }

                if(sizeof($performance["records"]) > 0) {
                    $lastDate = formatMysqlDate($performance["records"][0]["date"]);
                    echoDate($lastDate);
                    foreach ($performance["records"] as $record) {
                        $newDate = formatMysqlDate($record["date"]);
                        if($newDate != $lastDate) {
                            $lastDate = $newDate;
                            echoDate($newDate);
                        }
                        echoRecord($record);
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php if($creator) { ?>
    <div class="mobile-only">
        <br>
        <br>
        <br>
        <br>
        <form action="delete-performance.php" method="POST">
            <div class="flex">
                <input type="text" name="id" value="<?=$performance["idPerformanceCategory"]?>" hidden>
                <button type="submit" name="submit" class="btn create red">Delete this group</button>
            </div>
        </form>
    </div>
    <?php } ?>
</main>
<script>
$(".editable-input").on("input", resizeInput);
$(".editable-input").each(function() {
    resizeInput.call(this);
});

$(".new-goal").hide();

function toggleGoal() {
    if($(".new-goal").is(":visible")) {
        $("#new-goal").val(oldGoal);
    } else {
        $(".set-goal-btn").hide();
        $(".new-goal").show();
        $("#set-goal").val("1");
    }
}

function resizeInput() {
  this.style.width = this.value.length + "ch";
}

$(".tabel-record .top").click(function() {
    $(this).next().toggle();
});

function deleteRecord(idRecord) {
    $(".tabel-record." + idRecord + " .delete-btn").append(`<p class="loading cirlce"></p>`);
    set("deletePerformanceRecord", {idPerformanceRecord: idRecord}).receive((res) => {
        if(res == "succsess") {
            $(".tabel-record." + idRecord).remove();
        } else {
            alert(res);
        }
        reloadChart();
    });
}

reloadChart();
let chart;
function reloadChart() {
    $(".graph").empty();
    $(".graph").append(`<canvas id="line-chart" width="800" height="400"></canvas>`);
    get("performanceRecords", idPerformanceCategory).receive((succsess, records) => {
        console.log(succsess);
        if(!succsess) return;
        chart = initPerformanceChart(records, document.getElementById("line-chart"));
    });
}


$(".table").hide();
$("input[name='graph-table']").click(function(){
    let radioValue = $("input[name='graph-table']:checked").val();
    if(radioValue == "table") {
        $(".table").show();
        $(".graph").hide();
    } else {
        $(".table").hide();
        $(".graph").show();
    }
});

$("input[name='you-all']").click(function(){
    let radioValue = $("input[name='you-all']:checked").val();
    if(radioValue == "you"){
        chart.data.datasets.forEach(function(ds) {
            ds.hidden = ds.idUser != phpUser.iduser;
            $(".tabel-record.not-you").hide();
        });
    } else {
        chart.data.datasets.forEach(function(ds) {
            ds.hidden = false;
            $(".tabel-record").show();
        });
    }
    chart.update();
});
</script>
<?php
    include_once "../footer.php";
?>