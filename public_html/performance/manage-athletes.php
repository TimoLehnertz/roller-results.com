<?php
include_once "../api/index.php";
include_once "../includes/error.php";
if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/performance");
}

if(!isset($_GET["id"])) {
    throwError($INVALID_ARGUMENTS, "/performance");
}

$performance = getPerformanceCategory($_GET["id"]);
if(!$performance) {
    throwError($INVALID_ARGUMENTS, "/performance");
}

$groupMembers = getPerformanceCategoryUsers($_GET["id"]);
foreach ($groupMembers as &$user1) {
    if($user1["image"] == NULL) {
        $user1["image"] = defaultProfileImgPath($user1["gender"]);
    }
}

$noHeaderSearchBar = true;
include_once "../header.php";
?>
<script>
    const idPerformanceCategory = <?=$_GET["id"]?>;
    const existingUsers = <?=json_encode($groupMembers)?>;
    const thisUser = <?=$_SESSION["iduser"]?>;
    const isAdmin = <?=amIAdminInPerformanceCategory($_GET["id"]) ? "true" : "false"?>;
    const isCreator = <?=doIOwnPerformanceCategory($_GET["id"]) ? "true" : "false"?>;
</script>
<main class="performance">
    <h1 class="align center"><?=$performance["name"]?></h1>
    <div class="flex-mobile">
        <div>
            <h2 class="align center">Group members</h2>
            <br>
            <p>Manage members and permissions</p>
            <br>
            <a href="performance.php?id=<?=$_GET["id"]?>"><h3 class="btn round default no-border">< Back</h2></a>
            <br>
        </div>
        <div class="group-members"></div>
    </div>
</main>
<script>
const config = new PerformanceGroupUserConfig(idPerformanceCategory, existingUsers, thisUser, isAdmin, isCreator);
$(".group-members").append(config.elem);
</script>
<?php
    include_once "../footer.php";
?>