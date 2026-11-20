<?php
require_once 'assets/functions.php';
$records = getTrips();

if ($records->rowCount() > 0) {
    $row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC);
}
$error = false;


if (isset($_POST['submit'])) {
    if (
        isset($_POST['startdate'])
        && isset($_POST['enddate'])
        && isset($_POST['createdby'])
        && ($_POST["startdate"] != "")
        && ($_POST["enddate"] != "")
        && ($_POST["createdby"] != "")
    ) {

        $startdate = filter_input(INPUT_POST, "startdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $enddate = filter_input(INPUT_POST, "enddate", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $createdby = filter_input(INPUT_POST, "createdby", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
            'startdate' => $startdate,
            'enddate' => $enddate,
            'createdby' => $createdby
        ];


        if (addEvent($data)) {
            $_SESSION['startdate'] = $startdate;
            $_SESSION['enddate'] = $enddate;
            $_SESSION['createdby'] = $createdby;
            header("Location: " . $_SERVER['PHP_SELF']);
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}


if (isset($_POST['delete'])) {

    $trip_id = filter_input(INPUT_POST, "trip_id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (deleteTrip($trip_id)) {
        header("Location: trips.php");
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
    <h2>Trips</h2>
    <div class="form-container">
        <form method="post" action="">
            <label for="startdate">startdate:</label>
            <input type="text" id="startdate" name="startdate" required>
            <br>
            <label for="enddate">enddate:</label>
            <input type="text" id="enddate" name="enddate" required>
            <br>
            <label for="createdby">createdby:</label>
            <input type="text" id="createdby" name="createdby" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>
    </div>

    <table>
        <tr>
            <th>startdate</th>
            <th>enddate</th>
            <th>createdby</th>
        </tr>
    </table>

    <h1>Trips</h1>

    <?php do { ?>
        <tr>
            <td><?php echo $row_Recordset1['startdate']; ?></td>
            <td><?php echo $row_Recordset1['enddate']; ?></td>
            <td><?php echo $row_Recordset1['createdby']; ?></td>
        </tr>
        <br>

        <tr>
            <td colspan="2"><input type="submit" name="delete" id="delete" value="delete"></td>
        </tr>
    <?php } while ($row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC)); ?>

</body>

</html>