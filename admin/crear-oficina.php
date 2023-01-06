<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ if(isset($_POST['submit']))
{
$officetitle=$_POST['officetitle'];
$brand=$_POST['brandname'];
$officeoverview=$_POST['officeoverview'];
$PriceperHour=$_POST['PriceperHour'];
$Plan=$_POST['Plan'];
$modelyear=$_POST['modelyear'];
$seatingcapacity=$_POST['seatingcapacity'];
$vimage1=$_FILES["img1"]["name"];
$vimage2=$_FILES["img2"]["name"];
$vimage3=$_FILES["img3"]["name"];
$vimage4=$_FILES["img4"]["name"];
$vimage5=$_FILES["img5"]["name"];
$airconditioner=$_POST['airconditioner'];
$antilockbrakingsys=$_POST['antilockbrakingsys'];
$powersteering=$_POST['powersteering'];
$powerwindow=$_POST['powerwindow'];
move_uploaded_file($_FILES["img1"]["tmp_name"],"img/officeimages/".$_FILES["img1"]["name"]);
move_uploaded_file($_FILES["img2"]["tmp_name"],"img/officeimages/".$_FILES["img2"]["name"]);
move_uploaded_file($_FILES["img3"]["tmp_name"],"img/officeimages/".$_FILES["img3"]["name"]);
move_uploaded_file($_FILES["img4"]["tmp_name"],"img/officeimages/".$_FILES["img4"]["name"]);
move_uploaded_file($_FILES["img5"]["tmp_name"],"img/officeimages/".$_FILES["img5"]["name"]);

$sql="INSERT INTO tbloficinas(officesTitle,officesBrand,officesOverview,PriceperHour,Plan,ModelYear,SeatingCapacity,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5,AirConditioner,AntiLockBrakingSystem,PowerSteering,PowerWindows) VALUES(:officetitle,:brand,:officeoverview,:PriceperHour,:Plan,:modelyear,:seatingcapacity,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5,:airconditioner,:antilockbrakingsys,:powersteering,:powerwindow)";
$query = $dbh->prepare($sql);
$query->bindParam(':officetitle',$officetitle,PDO::PARAM_STR);
$query->bindParam(':brand',$brand,PDO::PARAM_STR);
$query->bindParam(':officeoverview',$officeoverview,PDO::PARAM_STR);
$query->bindParam(':PriceperHour',$PriceperHour,PDO::PARAM_STR);
$query->bindParam(':Plan',$Plan,PDO::PARAM_STR);
$query->bindParam(':modelyear',$modelyear,PDO::PARAM_STR);
$query->bindParam(':seatingcapacity',$seatingcapacity,PDO::PARAM_STR);
$query->bindParam(':vimage1',$vimage1,PDO::PARAM_STR);
$query->bindParam(':vimage2',$vimage2,PDO::PARAM_STR);
$query->bindParam(':vimage3',$vimage3,PDO::PARAM_STR);
$query->bindParam(':vimage4',$vimage4,PDO::PARAM_STR);
$query->bindParam(':vimage5',$vimage5,PDO::PARAM_STR);
$query->bindParam(':airconditioner',$airconditioner,PDO::PARAM_STR);

$query->bindParam(':antilockbrakingsys',$antilockbrakingsys,PDO::PARAM_STR);

$query->bindParam(':powersteering',$powersteering,PDO::PARAM_STR);

$query->bindParam(':powerwindow',$powerwindow,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="office posted successfully";
}
else 
{
$error="Algo salió mal. Intente de nuevo";
}

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
	
	<title>VosWork|Crear oficina</title>

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
					
						<h2 class="page-title">Crear una Oficina</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Info Básica</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>COMPLETADO</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Título <span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="officetitle" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Seleccionar plan<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value=""> Seleccionar </option>
<?php $ret="select id,BrandName from tblbrands";
$query= $dbh -> prepare($ret);
$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($results as $result)
{
?>
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->BrandName);?></option>
<?php }} ?>

</select>
</div>
</div>
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Descripción<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="officeoverview" rows="3" required></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Precio Por Hora(en USD)<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="PriceperHour" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Sala de Conferencias<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="Plan" required>
<option value=""> Seleccionar </option>

<option value="Si">Si</option>
														<option value="No">No</option>							
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Disponibilidad<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="modelyear" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Capacidad<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" required>
</div>
</div>
<div class="hr-dashed"></div>


<div class="form-group">
<div class="col-sm-12">
<h4><b>Upload Images</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">Image 1 <span style="color:red">*</span><input type="file" name="img1" required></div>
<div class="col-sm-4">Image 2<span style="color:red">*</span><input type="file" name="img2" required></div>
<div class="col-sm-4">Image 3<span style="color:red">*</span><input type="file" name="img3" required></div>
<div class="form-group">
<div class="col-sm-4">Image 4<span style="color:red">*</span><input type="file" name="img4" required></div>
<div class="col-sm-4">Image 5<input type="file" name="img5"></div>

</div>
<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">Accesorios</div>
<div class="panel-body">
<div class="form-group">
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="airconditioner" name="airconditioner" value="1">
<label for="airconditioner">Computadoras </label>
</div>
</div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="antilockbrakingsys" name="antilockbrakingsys" value="1">
<label for="antilockbrakingsys"> DataShow</label>
</div></div>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powersteering" name="powersteering" value="1">
<input type="checkbox" id="powersteering" name="powersteering" value="1">
<label for="inlineCheckbox5"> Líneas Telefonicas </label>
</div>
</div>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="powerwindow" name="powerwindow" value="1">
<label for="powerwindow"> Servicio de Cafetería </label>
</div>
</div>
<div class="form-group">
								<div class="col-sm-8 col-sm-offset-2">
									<button class="btn btn-default" type="reset">Cancelar</button>
									<button class="btn btn-primary" name="submit" type="submit">Guardar Cambios</button>
								</div>
							</div>

										</form>
									</div>
								</div>
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