<?php
include_once "../api/index.php"; // include api functions
include_once "../includes/error.php"; // include error handling functions

if(!isLoggedIn()) { // check if user is logged in
    throwError($ERROR_LOGIN_MISSING, "/performance"); // throw error if not logged in
}

if(!isset($_POST["id"])) { // check if id is set in POST request
    throwError($INVALID_ARGUMENTS, "/performance"); // throw error if id is not set
}

$performance = getPerformanceCategory($_POST["id"]); // get performance category with given id

if(!$performance) { // check if performance category exists
    throwError($INVALID_ARGUMENTS, "/performance"); // throw error if performance category does not exist
}

$error = ""; // initialize error message

if(isset($_POST["delete"]) && $_POST["delete"] == "delete") { // check if delete button was clicked
    if(!deletePerformanceCategory($_POST["id"])) { // try deleting the performance category
        $error = "<p class='font color red'>Unable to delete \"".$performance["name"]."\". Are you the owner of this group?</p><br>"; // set error message if delete was unsuccessful
    } else {
        header("location: /performance?deleteSuccsess=1"); // redirect to performance page if delete was successful
    }
}

include "../head.php"; // include head of html document
?>
<main class="performance font color white flex" style="height: 110vh">
    <form action="#" method="POST" style="max-width: 30rem">
        <?=$error?> <!-- display error message -->
        <h1 class="align center">Are you sure to <span class="font color red">permanently delete</span>  the performance group "<?=$performance["name"]?>"?</h1>
        <input type="text" name="id" value="<?=$_POST["id"]?>" hidden> <!-- set id value to be sent in POST request -->
        <div class="flex justify-space-evenly gap">
            <a href="performance.php?id=<?=$_POST["id"]?>" class="btn create green no-underline">Don't delete</a> <!-- cancel delete and go back to performance page -->
            <button type="submit" name="delete" value="delete" class="btn create red">Yes, delete</button> <!-- confirm delete -->
        </div>
    </form>
</main>