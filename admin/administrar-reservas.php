<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="2";
$sql = "UPDATE tblbooking SET Status=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Reserva Cancelada y Notificada!";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE tblbooking SET Status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();

$msg="Reserva Confirmada y Notificada";
}


?>



<!doctype html>
<html lang="es" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>VosWork|Admin Testimonios   </title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Administrar Reservas</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Info de Reserva</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>COMPLETADO</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
											<th>Nombre</th>
											<th>Oficina</th>
											<th>Día</th>
											<th>Hora</th>
											<th>Mensaje</th>
											<th>Estado</th>
											<th>Día Enviado</th>
											<th>Acción</th>
									
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
										<th>Nombre</th>
											<th>Oficina</th>
											<th>Día</th>
											<th>Hora</th>
											<th>Mensaje</th>
											<th>Estado</th>
											<th>Día Enviado</th>
											<th>Acción</th>
											
										</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT tblusers.FullName,tblbrands.BrandName,tbloficinas.officesTitle,tblbooking.date,tblbooking.timeslot,tblbooking.message,tblbooking.officeId as vid,tblbooking.Status,tblbooking.PostingDate,tblbooking.id  from tblbooking join tbloficinas on tbloficinas.id=tblbooking.officeId join tblusers on tblusers.EmailId=tblbooking.userEmail join tblbrands on tbloficinas.officesBrand=tblbrands.id  ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->FullName);?></td>
											<td><a href="edit-office.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></td>
											<td><?php echo htmlentities($result->date);?></td>
											<td><?php echo htmlentities($result->timeslot);?></td>
											<td><?php echo htmlentities($result->message);?></td>
											<td ><?php 
if($result->Status==0)
{
echo htmlentities('Sin Confirmar');
} else if ($result->Status==1) {
echo htmlentities('Confirmado');
}
 else{
 	echo htmlentities('Cancelado');
 }
										?></td>
											<td><?php echo htmlentities($result->PostingDate);?></td>
										<td><a class="action-positive"  href="administrar-reservas.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿Quieres confirmar esta Reserva?')"> Confirmar</a> /


<a class="action-negative" href="administrar-reservas.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('¿Quieres cancelar esta Reserva?')"> Cancelar</a>
</td>

										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>

						

							</div>
						</div>

					

					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>
