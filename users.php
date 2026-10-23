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
        && isset($_POST['firstname'])
        && isset($_POST['lastname'])
        && isset($_POST['email'])
        && isset($_POST['password'])
        && ($_POST["username"] != "") 
        && ($_POST["firstname"] != "") 
        && ($_POST["lastname"] != "") 
        && ($_POST["email"] != "") 
        && ($_POST["password"] != "") ){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        //$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $password = $_POST['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hashed_password
        ];


            if(addUser($data)){
                $_SESSION['username']= $username;
                $_SESSION['firstname']= $firstname;
                $_SESSION['lastname']= $lastname;
                $_SESSION['email']= $email;
                //$_SESSION['password']= $password;
            }
            else {
                $error=true;
            }
        } else {
            $error=true;
        }
}
?>
<?php
//require_once 'assets/functions.php';

if(isset($_POST['spara'])){

    if(isset($_POST['username'])
        
        && isset($_POST['firstname'])
        && isset($_POST['lastname'])
        && isset($_POST['email'])
        && isset($_POST['password'])
        && ($_POST["username"] != "") 
        && ($_POST["firstname"] != "")
        && ($_POST["lastname"] != "")
        && ($_POST["email"] != "")
        && ($_POST["password"] != "")
        
        ){
        
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $firstname = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $lastname = filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        //$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;

        $password = $_POST['password'];

          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

         $data = [
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hashed_password
        ];

            if(changeUser($data)){
                $_SESSION['username']= $username;
                $_SESSION['firstname']= $firstname;
                $_SESSION['lastname']= $lastname;
                $_SESSION['email']= $email;
                //$_SESSION['password']= $password;
               // header("Location: profil.php");
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
            <label for="firstname">Firstname:</label>
            <input type="text" id="firstname" name="firstname" required>
            <br>
            <label for="lastname">Lastname:</label>
            <input type="text" id="lastname" name="lastname" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>

    <?php do { ?>
    <form  method="POST">
    <table>
                <tr>
                    <td>Kund ID:</td>
                    <td><?php echo $row_Recordset1['user_id']; ?></td>
                    </tr>
                    <tr>
                    <td><input class="textFiled" name="username" type="text" id="username" value="<?php echo $row_Recordset1['username']; ?>" ></td>
                    <td><input class="textFiled" name="firstname" type="text" id="firstname" value="<?php echo $row_Recordset1['firstname']; ?>" ></td>

                     </tr>
                     <tr>
                    <td><input class="textFiled" name="lastname" type="text" id="lastname" value="<?php echo $row_Recordset1['lastname']; ?>" ></td>
                    <td><input class="textFiled" name="email" type="text" id="email" value="<?php echo $row_Recordset1['email']; ?>" ></td>
                    <td colspan="2"><input type="submit" name="spara" id="spara" value="spara"></td>
                </tr>
                <br>
    </table>
    </form>
    <br>
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>


</body>
</html>