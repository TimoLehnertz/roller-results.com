<?php
include_once "../header.php";
include_once "../api/index.php";
?>
<label for="aliasGroup">Alias group: </label>
<select id="aliasGroup">
<?php
    $groups = getAliasGroups();
    if(sizeof($groups) === 0) {
        echo "<option value='NOPE123'>You dont have any alias groups Yet!</option>";
    } else {
        echo "<option value='NOPE123'>Select</option>";
    }
    foreach ($groups as $group) {
        echo "<option value='$group'>$group</option>";
    }
?>
</select>
<textarea class="input" id="" cols="30" rows="10" placeholder="[001,002,...]">["001", "002"]</textarea>
<button class="go">Go</button>

<div class="result">

</div>

<script>
$(".go").click(() => {
    let aliases = $(".input").val();
    if(aliases.length == 0) {
        alert("Please fill in JSON array of aliases");
        return;
    }
    if(!isJson(aliases)) {
        alert("invalid JSON");
        return;
    }
    if(!Array.isArray(JSON.parse(aliases))) {
        alert("Invalid JSON array");
        return;
    }
    aliasGroup = $("#aliasGroup").val();
    if(aliasGroup === "NOPE123") {
        alert("Please choose Alias Group!");
        return;
    }
    aliases = JSON.parse(aliases);
    $(".result").empty();
    post("aliasIds", {aliasGroup, aliases}).receive((succsess, athletes) => {
        console.log(athletes);
        for (const athlete of athletes) {
            const profile = athleteToProfile(athlete, Profile.MIN);
            profile.update();
            profile.appendTo($(".result"));
        }
    });
});
</script>

<?php
    include_once "../footer.php";
?>