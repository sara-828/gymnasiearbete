<?php
require_once 'assets/functions.php';
session_start();

$records = getArtists();

if ($records->rowCount() > 0) {
    $row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC);
}


$error = false;


if (isset($_POST['submit'])) {
    if (
        isset($_POST['artistname'])
        && isset($_POST['genre'])
        && ($_POST["artistname"] != "")
        && ($_POST["genre"] != "")
        //&& ($_POST["image"] != "") 
        && ($_FILES['image']['error'] === 0)
    ) {

        $artistname = filter_input(INPUT_POST, "artistname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $genre = filter_input(INPUT_POST, "genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //$image = filter_input(INPUT_POST, "image", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);

        $data = [
            'artistname' => $artistname,
            'genre' => $genre,
            'image' => $image
        ];


        if (addArtist($data)) {
            $_SESSION['artistname'] = $artistname;
            $_SESSION['genre'] = $genre;
            $_SESSION['image'] = $image;
            header("Location: " . $_SERVER['PHP_SELF']);
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}


if (isset($_POST['delete'])) {

    $artist_id = filter_input(INPUT_POST, "artist_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (deleteArtist($artist_id)) {
        header("Location: artists.php");
    } else {
        $error = true;
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
    <?php
    if ($error)
        echo "<p> Kontrollera dina uppgifter</p>";
    ?>
    <nav>
        <ul>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="artists.php">Artists</a></li>
            <li><a href="event.php">Events</a></li>
            <li><a href="trip.php">Trips</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <H2>Artists</H2>
    <div class="form-container">
        <form method="post" action="" enctype="multipart/form-data">
            <label for="artistname">artistname:</label>
            <input type="text" id="artistname" name="artistname" required>
            <br>
            <label for="genre">genre:</label>
            <input type="text" id="genre" name="genre" required>
            <br>
            <label for="image">image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>
    </div>

    <?php do { ?>
        <table>
            <tr>
                <input type="hidden" name="artist_id" value="<?php echo $row_Recordset1['artist_id']; ?>">
                <td><?php echo $row_Recordset1['artistname']; ?></td>
            </tr>
            <tr>
                <td><?php echo nl2br($row_Recordset1['genre']); ?></td>
            </tr>
            <tr>
                <td><img src="uploads/<?php echo htmlspecialchars($row_Recordset1['image']); ?>"
                        width="100"
                        height="100"
                        alt="Artistbild"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="delete" id="delete" value="delete"></td>
            </tr>
        </table>
    <?php } while ($row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC)); ?>


</body>

</html>