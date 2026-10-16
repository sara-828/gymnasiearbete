<?php
require_once 'assets/functions.php';

$records = getUsers();

if($records->rowCount() >0){
$row_Recordset1=$records->fetch(PDO::FETCH_ASSOC);    
}
?>


    <?php
require_once 'assets/functions.php';
session_start();
$error=false;
if(isset($_POST['submit'])){
    if(isset($_POST['username'])
        && isset($_POST['name'])
        && isset($_POST['email'])
        && isset($_POST['password'])
        && ($_POST["username"] != "") 
        && ($_POST["name"] != "") 
        && ($_POST["email"] != "") 
        && ($_POST["password"] != "") ){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        //$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password
        ];


            if(addUser($data)){
                $_SESSION['username']= $username;
                $_SESSION['name']= $name;
                $_SESSION['email']= $email;
                //$_SESSION['password']= $password;
                header("Location: index.php");
            }
            else {
                $error=true;
            }
        } else {
            $error=true;
        }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Users</h2>

    <?php
    if($error)
        echo "<p> Kontrollera dina uppgifter</p>";
    ?>
     <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>
        <p><a href="login.php">Har du redan ett konto?</a></p>

    <?php do { ?>
                <tr>
                    <td><?php echo $row_Recordset1['username']; ?></td>
                    <td><?php echo $row_Recordset1['firstname']; ?></td>
                    <td><?php echo $row_Recordset1['lastname']; ?></td>
                </tr>
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>
</body>
</html>