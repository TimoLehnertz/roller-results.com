<?php
include_once "../api/index.php";
include_once "../includes/error.php";
if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/performance");
}
if(!isset($_POST["id"])) {
    throwError($INVALID_ARGUMENTS, "/performance");
}
$performance = getPerformanceCategory($_POST["id"]);

if(!$performance) {
    throwError($INVALID_ARGUMENTS, "/performance");
}

$error = "";

if(isset($_POST["delete"]) && $_POST["delete"] == "delete") {
    if(!deletePerformanceCategory($_POST["id"])) {
        $error = "<p class='font color red'>Unable to delete \"".$performance["name"]."\". Are you the owner of this group?</p><br>";
    } else {
        header("location: /performance?deleteSuccsess=1");
    }
}

include "../head.php";
?>
<main class="performance font color white flex" style="height: 110vh">
    <form action="#" method="POST" style="max-width: 30rem">
        <?=$error?>
        <h1 class="align center">Are you sure to <span class="font color red">permanently delete</span>  the performance group "<?=$performance["name"]?>"?</h1>
        <input type="text" name="id" value="<?=$_POST["id"]?>" hidden>
        <div class="flex justify-space-evenly gap">
            <a href="performance.php?id=<?=$_POST["id"]?>" class="btn create green no-underline">Don't delete</a>
            <button type="submit" name="delete" value="delete" class="btn create red">Yes, delete</button>
        </div>
    </form>
</main>
<script>
</script>
<?php
    // include_once "../footer.php";
?>