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
    if(isset($_POST['artistname'])
        && isset($_POST['genre'])
        && isset($_POST['image'])
        && ($_POST["artistname"] != "") 
        && ($_POST["genre"] != "") 
        && ($_POST["image"] != "") ){

        $artistname = filter_input(INPUT_POST, "artistname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $image = filter_input(INPUT_POST, "image", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        

        $data = [
            'artistname' => $artistname,
            'genre' => $genre,
            'image' => $image
        ];


            if(addArtist($data)){
                $_SESSION['artistname']= $artistname;
                $_SESSION['genre']= $genre;
                $_SESSION['image']= $image;
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
 <?php
    if($error)
        echo "<p> Kontrollera dina uppgifter</p>";
    ?>

     <form method="post" action="">
            <label for="artistname">artistname:</label>
            <input type="text" id="artistname" name="artistname" required>
            <br>
            <label for="genre">genre:</label>
            <input type="text" id="genre" name="genre" required>
            <br>
            <label for="image">image:</label>
            <input type="text" id="image" name="image" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>

        <?php do { ?>
                <tr>
                    <td><?php echo $row_Recordset1['artistname']; ?></td>
                    <td><?php echo nl2br($row_Recordset1['genre']); ?></td>
                    <td><?php echo $row_Recordset1['image']; ?></td>
                </tr>
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>

    
</body>
</html>