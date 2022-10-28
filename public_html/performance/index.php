<?php
$noHeaderSearchBar = true;
include_once "../header.php";
include_once "../api/index.php";
include_once "../includes/error.php";

$loggedIn = isLoggedIn();

if($loggedIn) {
    $idUser = $_SESSION["iduser"];
}

if(isset($_GET["id"]) && $loggedIn) {
    $idUser = $_GET["id"];
}
if(!$user) {
    throwError($ERROR_INVALID_ID, "/performance");
}
$user = getUser($idUser);
$categories = getPerformanceCategories();
// print_r($user);
?>
<main class="performance">
    <h1 class="align center">Performance</h1>
    <div class="upper-section">
        <div class="profile-img">
            <img src="<?=$user["image"] ?>" alt="Profile picture">
        </div>
        <div>
            <a class="btn default round no-underline no-border font size bigger" href="upload.php">Upload</a>
        </div>
        <div>
            <div>
                <p class="username"><?=$user["username"]?></p>
                <p class="realname"><?=$user["firstname"]?> <?=$user["lastname"]?></p>
            </div>
        </div>
        <div class="goals-wrapper">
            <div class="goals">
                <p><span class="number">2 / 10</span> Personal goals reached</p>
            </div>
        </div>
    </div>
    <div class="lower-section">
        <div class="flex column list">
            <?php
            foreach ($categories as $category) {
                echo "<a href='performance.php?id=".$category["idPerformanceCategory"]."' class='flex gap no-underline category-wrapper'>";
                echoPerformanceCategory($category);
                echo "<div class='btn plus'><img src=\"/img/arrow-right.png\" alt='>'></div>";
                echo "</a>";
            }
            ?>
        </div>
        <br>
        <br>
        <div class="align center">
            <a class="btn default round no-underline no-border font size bigger" href="create.php">+ Create Category</a></div>
        </div>
    </div>
</main>
<script>
    const maxDisplay = 5;
    $(".category-wrapper").each(function(i) {
        if(i >= maxDisplay) $(this).hide();
    });
    if($(".category-wrapper").length > maxDisplay) {
        const elem = $(`<button class="btn default margin top font size big">Show more</button>`);
        elem.click(() => {
            elem.hide();
            $(".category-wrapper").show();
        })
        $(".list").append(elem);
    }
</script>
<?php
    include_once "../footer.php";
?>