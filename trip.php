<?php
require_once 'assets/functions.php';

$records = getTrip();

if($records->rowCount() >0){
$row_Recordset1=$records->fetch(PDO::FETCH_ASSOC);    
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