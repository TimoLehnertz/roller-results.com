<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <title>Sign up</title>
    <link rel="stylesheet" href="/styles/signup.css">
</head>
<body>
    <h1>Create an account</h1>
    <p>It's quick and easy</p>
    <?php
        include_once "../includes/utils.php";
        echo ip_info("Visitor", "Address");
    ?>
    <form action="signup.php" method="POST">
        <input type="email" placeholder="email" id="email" name="email" required>
        <br>
        <input type="text" placeholder="username" id="username" name="username" required>
        <p>
            <input type="password" placeholder="Password" id="password1" name="password1" required>
            <input type="password" placeholder="Confirm" id="password2" name="password1" required>
        </p>
        <button type="submit"><i class="fas fa-lock"></i>Create account</button>
    </form>
</body>
</html>