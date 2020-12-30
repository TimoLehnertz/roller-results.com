<?php
include_once "../includes/roles.php";
include_once "../includes/error.php";
if(!canI("managePermissions")){
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
    if(updateUsers($newUsers)){
        header("location: /admin/users.php");
        exit();
    }
    // $users = getAllUsers();//update for gui
}

include_once "../header.php";
?>
<main class="main">
    <h1>Manage Users</h1>
    <form action="#" method="POST">
        <table>
            <?php
                echo "<tr><td>id</td><td>username</td><td>email</td><td>registerCountry</td><td>role</td><tr>";
                if(sizeof($users) > 0){
                    foreach ($users as $key => $user) {
                        $userData = [
                            "username" => $user["username"],
                            "email" => $user["email"],
                            "registerCountry" => $user["registerCountry"]
                        ];
                        $userRole = $user["idrole"];
                        $iduser = $user["iduser"];
                        echo "<tr>";
                            echo "<td>$iduser</td>";
                            foreach ($userData as $key => $value) {
                                echo "<td><input name='$iduser-$key' placeholder='$key' value='$value' maxlength='200'></td>";
                            }
                            echo "<td>";
                                echo "<select name='$iduser-idrole'>";
                                foreach ($defaultPermissions as $idrole => $permission) {
                                    $selected = "";
                                    if($idrole == $userRole){
                                        $selected = " selected";
                                    }
                                    echo "<option$selected value='$idrole'>$idrole => $permission</option>";
                                }
                                echo "</select>";
                            echo "</td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
        <button class="btn slide vertical default" name="submit-users" type="submit">Submit changes</button>
    </form>
</main>
<?php
include_once "../footer.php";
?>