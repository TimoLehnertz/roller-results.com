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
    <a href="/admin/users.php">Manage Users</a>
    <br>
    <a href="/admin/athletes.php">Manage Athletes</a>
    <br>
    <h2>Dev</h2>
    <hr>
    <a href="/admin/dev/country.php">country staff</a>
    <br>
    <a href="/admin/dev/extractor.php">extractor</a>
    <br>
    <a href="/admin/dev/fbFinder.php">fb stuff</a>
    <br>
    <a href="/admin/dev/import.php">import helper</a>
    <br>
    <a href="/admin/dev/ytSearch.php">ytSearch</a>
    <br>
    <a href="/admin/pwHashGenerator.php">Pw hash generator</a>
</main>
<?php
include_once "../footer.php";
?>