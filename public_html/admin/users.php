<?php
// exit();
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("managePermissions")) {
    throwError($ERROR_NO_PERMISSION);
}

$users = getAllUsers();

/**
 * Affenformular
 */

if(isset($_POST["submit-users"])){
    unset($_POST["submit-users"]);
    $newUsers = [];
    foreach ($_POST as $key => $value) {
        $split = explode("-", $key);
        $iduser = intval($split[0]);
        $prop = $split[1];
        if(array_key_exists($iduser, $users)){
            if(!array_key_exists($iduser, $newUsers)){
                $newUsers[$iduser] = ["iduser" => $iduser];
            }
            $newUsers[$iduser][$prop] = $value;
        }
    }
    if(updateUsers($newUsers)) {
        header("location: /admin/users.php");
        exit();
    }
    // $users = getAllUsers();//update for gui
}

include_once "../header.php";
?>
<main class="main">
    <h1>Manage Users</h1>
    <table>
        <?php
                echo "<tr><td>id</td><td>username</td><td>email</td><td>registerCountry</td><td>role</td><tr>";
                if(sizeof($users) > 0){
                    foreach ($users as $key => $user) {
                        echo "<form action='#' method='POST'>";
                        $userData = [
                            "username" => $user["username"],
                            "email" => $user["email"],
                            "registerCountry" => $user["registerCountry"]
                        ];
                        $userRole = $user["idRole"];
                        $iduser = $user["iduser"];
                        echo "<tr>";
                            echo "<td>$iduser</td>";
                            foreach ($userData as $key => $value) {
                                echo "<td><input name='$iduser-$key' placeholder='$key' value='$value' maxlength='200'></td>";
                            }
                            echo "<td>";
                                echo "<select name='$iduser-idRole'>";
                                foreach ($defaultPermissions as $idRole => $permission) {
                                    $selected = "";
                                    if($idRole == $userRole){
                                        $selected = " selected";
                                    }
                                    echo "<option$selected value='$idRole'>$idRole => $permission</option>";
                                }
                                echo "</select>";
                            echo "</td>";
                            echo "<td>";
                            echo "<button class='btn slide vertical default' name='submit-users' type='submit'>Submit change</button>";
                            echo "</td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                }
            ?>
        </table>
</main>
<?php
include_once "../footer.php";
?>