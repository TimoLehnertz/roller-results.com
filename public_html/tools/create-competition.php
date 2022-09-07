<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";

$amIAllowed = isLoggedIn();

if(isset($_POST["submit"])) {
    if(!$amIAllowed) {
        throwError($ERROR_NO_PERMISSION, "/tools/index.php");
        exit(0);
    }
    $succsess = addCompetition($_POST["name"], $_POST["city"], $_POST["country"], $_POST["latitude"] ?? NULL, $_POST["longitude"] ?? NULL, $_POST["type"], $_POST["startDate"], $_POST["endDate"] ?? $_POST["startDate"], $_POST["description"]);
    if($succsess) {
        echo "<h2>".$_POST["name"]." has been added succsessfully</h2>";
    } else {
        echo "An error occured";
    }
}

include_once "../header.php";
?>
<div class="flex">
    <form class="form" action="#" method="post">
        <h1>Create roller competition</h1>
        <p>
            <label for="name">Name*</label>
            <input type="text" name="name" id="name" placeholder="name" required>
        </p>
        <br>
        <p>
            <label for="city">City*</label>
            <input type="text" name="city" id="city"  placeholder="city" required>
        </p>
        <br>
        <p>
            <label for="country">Country*</label>
            <input type="text" name="country" id="country"  placeholder="country" required>
        </p>
        <br>
        <p>
            <label for="latitude">Latitude (Empty or Number; example: 50.804421)</label>
            <input step="0.000001" type="number" name="latitude" id="latitude"  placeholder="latitude">
        </p>
        <br>
        <p>
            <label for="longitude">Longitude (Empty or Number; example: 50.804421)</label>
            <input step="0.000001" type="number" name="longitude" id="longitude"  placeholder="longitude">
        </p>
        <br>
        <p>
            <label for="type">Competition type*</label>
            <input step="0.000001" type="text" name="type" id="type"  placeholder="type" required>
        </p>
        <p>
            <label for="startDate">Start date*</label>
            <input type="date" name="startDate" id="startDate"  placeholder="startDate" required>
        </p>
        <br>
        <p>
            <label for="endDate">End date / none if same as start date</label>
            <input type="date" name="endDate" id="endDate"  placeholder="endDate">
        </p>
        <br>
        <p>
            <label for="description">Description</label>
            <input type="text" name="description" id="description"  placeholder="description">
        </p>
        <br>
        <?php if($amIAllowed) { ?>
            <input type="submit" value="Create" name="submit" class="btn default">
        <?php } else { ?>
            <p><a target="blank" href="/login">Login</a> to create competitions</p>
            <!-- <p>Contact us at <span class="code padding left right">roller.results@gmail.com</span> to get accsess to this tool</p> -->
        <?php }?>
    </form>
</div>

<?php
    include_once "../footer.php";
?>