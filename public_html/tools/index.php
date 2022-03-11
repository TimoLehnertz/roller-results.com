<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("configureAthletes")){
    throwError($ERROR_NO_PERMISSION, "/index.php");
} 
include_once "../api/index.php";
include_once "../header.php";
?>
<main class="main">
    <h1 class="align center margin top double">Roller Tools</h1>
    <ul class="align center font size big margin top triple">
        <li><a href="import.php">Import script</a></li>
        <?php
            if(canI("speaker")){
                echo "<li><a href='speaker.php'>Speaker tools 💪</a></li>";
            }
        ?>
    </ul>
</main>
<script>
</script>
<?php
    include_once "../footer.php";
?>