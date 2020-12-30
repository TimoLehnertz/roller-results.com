<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("seeAdminPage")){
    throwError($ERROR_NO_PERMISSION);
}
include_once "../header.php";
?>
<main class="main">
    <h1>Administration</h1>
    <a href="users.php">Manage Users</a>
    <br>
    <a href="athletes.php">Manage Athletes</a>
</main>
<?php
include_once "../footer.php";
?>