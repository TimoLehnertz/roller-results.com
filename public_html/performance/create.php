<?php
$noHeaderSearchBar = true;
include_once "../api/index.php";
include_once "../includes/error.php";


if(!isLoggedIn()) {
    throwError($ERROR_LOGIN_MISSING, "/performance");
}

$error = false;
if(isset($_POST["submit"])) { // submit
    if(validateObjectProperties($_POST, [
        [
            "property" => "name",
            "type" => "string",
            "minLength" => 1,
            "maxLength" => 50,
        ], [
            "property" => "description",
            "type" => "string",
            "maxLength" => 200,
        ], [
            "property" => "type",
            "type" => "string",
            "minLength" => 1
        ], [
            "property" => "users",
            "type" => "string",
        ],
    ], false)) {
        $users = json_decode($_POST["users"]);
        $idPerformanceCategory = createPerformanceCategory($_POST["name"], $_POST["description"], $_POST["type"], $users);
        if($idPerformanceCategory != false) {
            if(isset($_GET["upl"])) {
                header("location: upload.php?pid=$idPerformanceCategory");
            } else {
                header("location: /performance/performance.php?id=$idPerformanceCategory&createSuccsess=1");
            }
        } else {
            $error = true;
        }
    }
}

$user = getUser($_SESSION["iduser"]);

$jsUser = [
    "id" => $user["iduser"],
    "image" => $user["image"],
    "name" => "You"
];
include_once "../header.php";
?>
<script>const user = <?=json_encode($jsUser)?>;</script>
<main class="performance">
    <h1 class="align center font size bigger margin left right double">Create Performance Category</h1>
    <?php if($error) {
        echo "<p class='font color red'>We are sorry an error occoured :( please try again</p>";
    } ?>
    <form action="#" method="POST" id="myForm" class="form-performance" autocomplete="off">
        <label for="name">Name</label>
        <input autocomplete="false" type="text" name="name" id="name" maxlength="50" required>
        <label for="description">Description</label>
        <textarea autocomplete="false" type="text" name="description" id="description" maxlength="200"></textarea>
        <label>Type</label>
        <div class="flex align-stretch gap margin bottom wrap">
            <input type="radio" name="type" id="time" value="time" checked>
            <label for="time">Time</label>
            <input type="radio" name="type" id="bpm" value="bpm">
            <label for="bpm">Heart-rate</label>
            <input type="radio" name="type" id="distance" value="distance">
            <label for="distance">Distace</label>
            <input type="radio" name="type" id="weight" value="weight">
            <label for="weight">Weight</label>
            <input type="radio" name="type" id="other" value="">
            <label for="other">Other</label>
        </div>
        <div class="other-area" hidden>
            <label for="other-input">Other dimension</label>
            <input type="text" id="other-input" placeholder="Enter your dimension">
        </div>
        <br>
        <label>Invite users</label>
        <div class="athlete-search"></div>
        <br><br>
        <input type="text" name="users" id="users" value="" hidden>
        <div class="flex justify-center gap">
            <a href="/performance" class="btn create gray no-underline">Back</a>
            <input class="btn create" type="submit" name="submit" value="Create">
        </div>
    </form>
</main>
<script>
    const config = new PerformanceGroupUserConfig(0, [], user.id, true, true, false);
    user.isCreator = true;
    config.addUser(user, false);
    $("#users").val(`[${config.getUserIds()}]`);
    $(".athlete-search").append(config.elem);
    config.onchange = () => {
        $(`#users`).val(`[${config.getUserIds()}]`);
    }

    document.getElementById("myForm").onkeypress = function(e) {
        let key = e.charCode || e.keyCode || 0;
        if (key == 13) {
            e.preventDefault();
        }
    }

    $("input[name=type]").change(() => {
        $(".other-area").toggle($("#other").is(":checked"));
        $("#other-input").attr("required", $("#other").is(":checked"));
    })

    $("#other-input").on("input", function() {
        $("#other").val($(this).val());
    });
</script>
<?php
    include_once "../footer.php";
?>