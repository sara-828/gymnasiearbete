<?php
require_once 'assets/functions.php';

$records = getUsers();

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
    <h2>Users</h2>
    

    <?php do { ?>
                <tr>
                    <td><?php echo $row_Recordset1['username']; ?></td>
                </tr>
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>
</body>
</html>