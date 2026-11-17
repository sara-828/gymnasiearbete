<?php
require_once 'assets/functions.php';

$records = getArtists();

if (isset($_GET['user_id'])) {
    $user_id = (int) $_GET['user_id']; // Gör om till heltal för säkerhets skull
} else {
    // Om inget ID skickades med kan du skicka tillbaka användaren
    header("Location: index.php");
    exit;
}


$meddelamde = "";

if (isset($_POST['add'])) {
    $artist_id = filter_input(INPUT_POST, "artist_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_id = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $data = [
        'artist_id' => $artist_id,
        'user_id' => $user_id
    ];

    if (addFavoriteArtist($data)) {
        $meddelamde = "Artist har lagts till i favoriter!";
    } else {
        $meddelamde = "Något gick fel. Försök igen.";
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
    <h3><?php echo $user_id ?></h3>


    <?php do { ?>
        <form method="post" action="">
            <table>
                <tr>
                    <input type="hidden" name="artist_id" value="<?php echo $row_Recordset1['artist_id']; ?>">
                    <td><?php echo $row_Recordset1['artistname']; ?></td>
                    <br>
                    <td><?php echo nl2br($row_Recordset1['genre']); ?></td>

                    <td><img src="uploads/<?php echo htmlspecialchars($row_Recordset1['image']); ?>"
                            width="100"
                            height="100"
                            alt="Artistbild"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="add" id="add" value="add"></td>
                </tr>
            </table>

            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        </form>
    <?php } while ($row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC)); ?>

</body>

</html>