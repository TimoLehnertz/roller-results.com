<?php
// include the api and error functions
include_once "../api/index.php";
include_once "../includes/error.php";

// if the user is not logged in, throw an error
if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/performance");
}

// if the "id" parameter is not set in the URL, throw an error
if(!isset($_GET["id"])) {
    throwError($INVALID_ARGUMENTS, "/performance");
}

// get the performance category with the specified id
$performance = getPerformanceCategory($_GET["id"]);

// if the performance category does not exist, throw an error
if(!$performance) {
    throwError($INVALID_ARGUMENTS, "/performance");
}

// get an array of all the users in the performance category
$groupMembers = getPerformanceCategoryUsers($_GET["id"]);

// loop through the users and set their default profile image if they don't have one
foreach ($groupMembers as &$user1) {
    if($user1["image"] == NULL) {
        $user1["image"] = defaultProfileImgPath($user1["gender"]);
    }
}

// set the $noHeaderSearchBar variable to true so the search bar is not included in the header
$noHeaderSearchBar = true;

// include the header
include_once "../header.php";
?>
<script>
    // set variables for the id of the performance category, the existing users, the current user's id, whether the current user is an admin in the category, and whether the current user is the creator of the category
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
// create a new PerformanceGroupUserConfig object with the previously set variables
const config = new PerformanceGroupUserConfig(idPerformanceCategory, existingUsers, thisUser, isAdmin, isCreator);

// append the element to the group-members div
$(".group-members").append(config.elem);
</script>
<?php
    // include the footer
    include_once "../footer.php";
?>