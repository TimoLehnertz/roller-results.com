<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PW Hash gen</title>
</head>
<body>
    <form action="#" method="post">
        <label for="pw">Input password</label>
        <input type="text" id="pw" name="pw">
        <label for="decode">Decode urlencoded</label>
        <input type="text" id="decode" name="decode">
        <input type="submit">
    </form>
    <?php
    if(isset($_POST["pw"])) {
        echo "Generated hash: ".password_hash($_POST["pw"], PASSWORD_DEFAULT)."<br>";
    }
    if(isset($_POST["decode"])) {
        echo "Decoded URI: ".urldecode($_POST["decode"]);
    }
    ?>
</body>
</html>