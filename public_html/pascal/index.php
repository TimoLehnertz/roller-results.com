<?php
include_once "../api/index.php";
if(!canISeePascalPage()) {
  header("location: /index.php");
  exit();
}

if(isset($_POST["update-membership"])) {
  updatePascalMembership($_POST["id"], $_POST["lat"], $_POST["long"], $_POST["name"], $_POST["contact"], $_POST["email"], $_POST["phoneNumber"], $_POST["website"], $_POST["level"]);
  header("location: /pascal#".$_POST["id"]);
  return;
}

if(isset($_POST["delete-membership"])) {
  deletePascalMembership($_POST["id"]);
  header("location: /pascal");
  return;
}

if(isset($_POST["add-membership"])) {
  $id = addPascalMembership($_POST["lat"], $_POST["long"], $_POST["name"], $_POST["contact"], $_POST["email"], $_POST["phoneNumber"], $_POST["website"], $_POST["level"]);
  header("location: /pascal#".$id);
  return;
}

$memberships = getPascalMembershipsWithCode();

$noHeaderSearchBar = true;
include_once "../header.php";
include_once "../includes/error.php";
$user = ["image" => defaultProfileImgPath("m")];
if(isLoggedIn()) {
    $user = getUser($_SESSION["iduser"]);
}
?>
<main class="performance">
    <h1 class="align center">Manage memberships on map</h1>
    <div class="margin top left right double">
      <div class="flex column">
        <h2>Add membership</h2>
        <br>
        <form action="#" method="POST" class='form' style="max-width: 30rem">
          <label for='name'>Name</label><input required id='name' type='text' name='name' placeholder="Name">
          <br>
          <br>
          <label for="level" class="margin right">Level</label>
          <select name="level" id="level">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <br>
          <br>
          <label for='contact'>Contact</label><input id='contact' type='text' name='contact' placeholder="Contact">
          <label for='email'>Email</label><input id='email' type='email' name='email' placeholder="Email">
          <label for='phoneNumber'>Phone number</label><input id='phoneNumber' type='text' name='phoneNumber' placeholder="Phone number">
          <label for='website'>Website</label><input id='website' type='text' name='website' placeholder="Website">
          <br>
          <br>
          <div class="flex gap">
            <div class="flex column">
              <label for='lat'>Latitude</label><input id='lat' type='number' step='0.00000001' name='lat' value="0" onchange="checkCoords()">
            </div>
            <div class="flex column" style="margin-top: 0; padding-top: 0">
              <label for='long'>Longitude</label><input id='long' type='number' step='0.00000001' name='long' value="0" onchange="checkCoords()">
            </div>
          </div>
          <br>
          <script>
            function checkCoords() {
              const lat = document.getElementById('lat').value;
              const long = document.getElementById('long').value;
              if(lat == 0 || long == 0) {
                document.getElementById('coord-notice-1').classList.remove("hidden");
                document.getElementById('coord-notice-2').classList.add("hidden");
              } else {
                document.getElementById('coord-notice-1').classList.add("hidden");
                document.getElementById('coord-notice-2').classList.remove("hidden");
              }
            }
          </script>
          <p id="coord-notice-1" class="font color light"><b>Note:</b> Will only get displayed on the map after lat and long are set by you or the user himself.</p>
          <p id="coord-notice-2" class="hidden font color green">Will be displayed on the map</p>
          <br>
          <button class='btn blender alone' name='add-membership' type='submit'>Add membership</button>
        </form>
      </div>
      <br>
      <br>
      <br>
      <h3>Manage existing memberships</h3>
      <br>
      <br>
      <div class="grid three gap">
        <?php
          foreach ($memberships as $membership) {
            echo "<form action='#' method='POST' class='form' style='max-width: 40rem' id='".$membership["id"]."'>";
            $membershipData = [
              "name" => $membership["name"],
              "contact" => $membership["contact"],
              "email" => $membership["email"],
              "phoneNumber" => $membership["phoneNumber"],
              "website" => $membership["website"]
            ];
            $id = $membership["id"];
              echo "<p>#$id</p><br>";
              echo "<input type='number' value='$id' style='display: none;' name='id'>";
              echo "<label for='$id-level' class='m,margin right'>Level</label><select id='$id-level' name='level'>";
              echo "<option ".($membership['level'] == 1 ? 'selected="selected"' : '')." value='1'>1</option>";
              echo "<option ".($membership['level'] == 2 ? 'selected="selected"' : '')." value='2'>2</option>";
              echo "<option ".($membership['level'] == 3 ? 'selected="selected"' : '')." value='3'>3</option>";
              echo "</select><br><br>";
              foreach ($membershipData as $key => $value) {
                echo "<label for='$id-$key'>$key</label>";
                echo "<input id='$id-$key' name='$key' placeholder='$key' value='$value' maxlength='200'>";
              }
              echo "<br><br><div class='flex gap'><div class='flex column'>";
              echo "<label for='$id-lat'>Latitude</label><input required id='$id-lat' type='number' step='0.00000001' name='lat' value='".$membership["lat"]."'>";
              echo "</div> <div class='flex column' style='margin-top: 0; padding-top: 0'>";
              echo "<label for='$id-long'>Longitude</label><input required id='$id-long' type='number' step='0.00000001' name='long' value='".$membership["long"]."'>";
              echo "</div></div>";
              if($membership["lat"] == 0 || $membership["long"] == 0) {
                echo "<br><p>Will not be displayed be displayed on the map until the coordinates are set</p>";
              }
              echo "<br><p>Access code: <span class='font color orange'>".($membership['customer_id'])."</span></p>";
              echo "<br>";
              echo "<button class='btn blender alone' name='update-membership' type='submit'>Edit membership</button>";
              echo "<br>";
              echo "<button class='btn blender alone red' name='delete-membership' type='submit'>Delete membership</button>";
              echo "</form>";
            }
          ?>
        </div>
    </div>
</main>
<script>
    
</script>
<?php
    include_once "../footer.php";
?>