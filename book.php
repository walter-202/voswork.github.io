<?php
session_start();
include('includes/config.php');
error_reporting(0);
$mysqli = new mysqli('localhost', 'root', '', 'data');
if(isset($_GET['date'])&& isset($_GET['offid'])){
    $date = $_GET['date'];
    $offid = $_GET['offid'];
    $stmt = $mysqli->prepare("SELECT * from tblbooking where date = ? and officeid = ?");
    $stmt->bind_param('ss', $date, $offid);
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = $row['timeslot'];
            }
            $stmt->close();
        }
    }
}

if(isset($_POST['submit'])){
    $message = $_POST ['message'];
    $email = $_SESSION['login'];
    $timeslot = $_POST['timeslot'];
    $status=0;
    $offid=$_GET['offid'];
    $stmt = $mysqli->prepare("SELECT * from tblbooking where date = ? AND timeslot=?");
    $stmt->bind_param('ss', $date, $timeslot);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            echo "<script>alert('Algo salió mal. Intente de nuevo');</script>";
            echo "<script type='text/javascript'> document.location = 'listado.php'; </script>";
        }else{
            $stmt = $mysqli->prepare("INSERT INTO tblbooking (message, officeId, timeslot, userEmail, date, Status) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param('ssssss', $message, $offid, $timeslot, $email, $date, $status);
            $stmt->execute();
            echo "<script>alert('Reserva Hecha.');</script>";
            $bookings[] = $timeslot;
            $stmt->close();
            $mysqli->close();
            echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
        }
    }
}

/*
if(isset($_POST['submit']))
{
$date=$_POST['date'];
$timeslot=$_POST['timeslot']; 
$message=$_POST['message'];
$useremail=$_SESSION['login'];
$status=0;
$offid=$_GET['offid'];
$sql="INSERT INTO  tblbooking(userEmail,officeId,date,timeslot,message,Status) VALUES(:useremail,:offid,:date,:timeslot,:message,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':offid',$offid,PDO::PARAM_STR);
$query->bindParam(':date',$date,PDO::PARAM_STR);
$query->bindParam(':timeslot',$timeslot,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Reserva Hecha.');</script>";
echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
}
else 
{
echo "<script>alert('Algo salió mal. Intente de nuevo');</script>";
echo "<script type='text/javascript'> document.location = 'listado.php'; </script>";
}
}
*/

$duration = 60;
$cleanup = 0;
$start = "09:00";
$end = "18:00";


function timeslots ($duration, $cleanup, $start, $end){
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT".$duration."M");
    $cleanupInterval = new DateInterval("PT".$cleanup."M");
    $slots = array();
    
    for($intStart = $start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }
        
        $slots[] = $intStart->format("H:iA")." - ". $endPeriod->format("H:iA");
        
    }
    
    return $slots;
}



?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title></title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body>
<?php 
$offid=intval($_GET['offid']);
$sql = "SELECT tbloficinas.*,tblbrands.BrandName,tblbrands.id as bid  from tbloficinas join tblbrands on tblbrands.id=tbloficinas.officesBrand where tbloficinas.id=:offid";
$query = $dbh -> prepare($sql);
$query->bindParam(':offid',$offid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$_SESSION['brndid']=$result->bid;  
?>  

<div class="container">
        <h2 class="text-center"> Escoge el Tiempo que quieras Reservar para el: <span> <?php echo date('d/m/Y', strtotime($date)); ?></span></h2><hr>
        <h3 class="text-center">Para: <?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></span></h3>
        <div class="row vc_row">

<?php $timeslots = timeslots($duration, $cleanup, $start, $end); 
    foreach($timeslots as $ts){
?>
<div class="reservation" >
    <div class="form-group ">
<?php if(in_array($ts, $bookings)){ ?>
<button class="btn-padding btn-danger"><?php echo $ts; ?></button>
<?php }else{ ?>
<button class="btn-padding btn-success book" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
<?php }  ?>
    </div>
</div>
<?php } ?>
</div>
</div>

<!-- FORMULARIO RESERVA -->

<div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Reserva: <span id="slot"></span></h3>
                    <h4><?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Intervalos de Tiempo:</label>
                                    <input readonly type="text" class="form-control" id="timeslot" name="timeslot">
                                </div>
                                <div class="form-group">
                                    <label for="">Dejanos un Mensaje:</label>
                                    <input required type="text" class="form-control" name="message">
                                </div>
                                <div class="form-group pull-right">
                                    <button name="submit" type="submit" class="btn-padding btn-success">Pagar $<?php echo htmlentities($result->PriceperHour);?> </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }} ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    <script>
$(".book").click(function(){
    var timeslot = $(this).attr('data-timeslot');
    $("#slot").html(timeslot);
    $("#timeslot").val(timeslot);
    $("#myModal").modal("show");
});
</script>
  </body>

</html>
