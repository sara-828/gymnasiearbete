<?php
require_once 'assets/functions.php';
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (login($username, $password)) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header('Location: menu.php');
        exit();
    } else {
        echo "invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <h2>Login</h2>
    <div class="form-container">
        
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>
        
    </div>
    <p> <a href="signup.php">Saknar du konto?</a></p>
</body>

</html>