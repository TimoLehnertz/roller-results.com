<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
include_once "../api/index.php";
include_once "../header.php";

if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/tools/index.php");
}
if(isset($_POST["submit"])) {
    $succsess = addCompetition($_POST["name"], $_POST["city"], $_POST["country"], $_POST["latitude"], $_POST["longitude"], $_POST["type"], $_POST["startDate"], $_POST["endDate"], $_POST["description"]);
    if($succsess) {
        echo "<h2>".$_POST["name"]." has been added succsessfully</h2>";
    } else {
        echo "An error occured";
    }
}
?>
<div class="flex">
    <form class="form" action="#" method="post">
        <h1>Create roller competition</h1>
        <p>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="name" required>
        </p>
        <br>
        <p>
            <label for="city">City</label>
            <input type="text" name="city" id="city"  placeholder="city" required>
        </p>
        <br>
        <p>
            <label for="country">Country</label>
            <input type="text" name="country" id="country"  placeholder="country" required>
        </p>
        <br>
        <p>
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude"  placeholder="latitude" required>
        </p>
        <br>
        <p>
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude"  placeholder="longitude" required>
        </p>
        <br>
        <p>
            <label for="type">Competition type</label>
            <input type="text" name="type" id="type"  placeholder="type" required>
        </p>
        <p>
            <label for="startDate">Start date</label>
            <input type="date" name="startDate" id="startDate"  placeholder="startDate" required>
        </p>
        <br>
        <p>
            <label for="endDate">End date</label>
            <input type="date" name="endDate" id="endDate"  placeholder="endDate">
        </p>
        <br>
        <p>
            <label for="description">Description</label>
            <input type="text" name="description" id="description"  placeholder="description">
        </p>
        <br>
        <input type="submit" value="Create" name="submit" class="btn default">
    </form>
</div>

<?php
    include_once "../footer.php";
?>