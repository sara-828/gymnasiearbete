<?php
require_once 'assets/functions.php';
session_start();

$records = getEvents();

if($records->rowCount() >0){
$row_Recordset1=$records->fetch(PDO::FETCH_ASSOC);    
}


$error=false;


if(isset($_POST['submit'])){
    if(isset($_POST['eventname'])
        && isset($_POST['date'])
        && isset($_POST['price'])
        && ($_POST["eventname"] != "") 
        && ($_POST["date"] != "") 
        && ($_POST["price"] != "") 
    ){

        $eventname = filter_input(INPUT_POST, "eventname", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
        $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;

        $data = [
            'eventname' => $eventname,
            'date' => $date,
            'price' => $price
        ];


            if(addEvent($data)){
                $_SESSION['eventname']= $eventname;
                $_SESSION['date']= $date;
                $_SESSION['price']= $price;
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
            <label for="eventname">eventname:</label>
            <input type="text" id="eventname" name="eventname" required>
            <br>
            <label for="date">date:</label>
            <input type="text" id="date" name="date" required>
            <br>
            <label for="price">price:</label>
            <input type="text" id="price" name="price" required>
            <br>
            <input type="submit" id="submit" name="submit">
        </form>
    

       <?php do { ?>
    <form  method="post">
    <table>
                <tr>
                    <td>Event ID: <?php echo $row_Recordset1['event_id']; ?></td>
                    <input type="hidden" name="event_id" value="<?php echo $row_Recordset1['event_id']; ?>">
                    <td><input class="textFiled" name="eventname" type="text" id="eventname" value="<?php echo $row_Recordset1['eventname']; ?>" ></td>
                    <td><input class="textFiled" name="date" type="text" id="date" value="<?php echo $row_Recordset1['date']; ?>" ></td>
                    <td><input class="textFiled" name="price" type="text" id="price" value="<?php echo $row_Recordset1['price']; ?>" ></td>
                    <td colspan="2"><input type="submit" name="spara" id="spara" value="spara"></td>
                    <td colspan="2"><input type="submit" name="delete" id="delete" value="delete"></td>
                </tr>      
    </table>
    </form>
    
<?php } while ($row_Recordset1=$records->fetch(PDO::FETCH_ASSOC)); ?>
    
</body>
</html>