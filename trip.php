<?php
require_once 'assets/functions.php';
$records = getTrip();

if($records->rowCount() >0){
$row_Recordset1=$records->fetch(PDO::FETCH_ASSOC);    
}
$error=false;


if(isset($_POST['submit'])){
    if(isset($_POST['startdate'])
        && isset($_POST['enddate'])
        && isset($_POST['createdby'])
        && ($_POST["startdate"] != "") 
        && ($_POST["enddate"] != "") 
        && ($_POST["createdby"] != "") 
    ){

        $startdate = filter_input(INPUT_POST, "startdate", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $enddate = filter_input(INPUT_POST, "enddate", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $createdby = filter_input(INPUT_POST, "createdby", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;

        $data = [
            'startdate' => $startdate,
            'enddate' => $enddate,
            'createdby' => $createdby
        ];


            if(addEvent($data)){
                $_SESSION['startdate']= $startdate;
                $_SESSION['enddate']= $enddate;
                $_SESSION['createdby']= $createdby;
                header("Location: " . $_SERVER['PHP_SELF']);
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
    
    <h1>Trips</h1>
    
     <?php do { ?>
                <tr>
                    <td><?php echo $row_Recordset1['startdate']; ?></td>
                    <td><?php echo $row_Recordset1['enddate']; ?></td>
                    <td><?php echo $row_Recordset1['createdby']; ?></td>
                </tr>
                <br>
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>
    
</body>
</html>