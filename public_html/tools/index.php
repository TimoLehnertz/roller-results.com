<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";
?>
<main class="main">
    <h1 class="align center margin top double">Roller Tools</h1>
    <ul class="align center font size big margin top triple">
        <li><a href="raceflow.php">Edit race flow</a></li>
        <li><a href="view-raceflow.php"> View race flow</a></li>
        <li><a href="import.php">Import script</a></li>
        <li><a href="list-alias.php">List alias</a></li>
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