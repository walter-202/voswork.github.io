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
$officesoverview=$_POST['officesoverview'];
$priceperday=$_POST['priceperday'];
$plan=$_POST['plan'];
$modelyear=$_POST['modelyear'];
$seatingcapacity=$_POST['seatingcapacity'];
$airconditioner=$_POST['airconditioner'];

$antilockbrakingsys=$_POST['antilockbrakingsys'];

$powersteering=$_POST['powersteering'];

$powerwindow=$_POST['powerwindow'];

$id=intval($_GET['id']);

$sql="UPDATE tbloficinas set officesTitle=:officetitle,officesBrand=:brand,officesOverview=:officesoverview,PriceperHour=:priceperday,Plan=:plan,ModelYear=:modelyear,SeatingCapacity=:seatingcapacity,AirConditioner=:airconditioner,AntiLockBrakingSystem=:antilockbrakingsys,PowerSteering=:powersteering,PowerWindows=:powerwindow where id=:id ";
$query = $dbh->prepare($sql);
$query->bindParam(':officetitle',$officetitle,PDO::PARAM_STR);
$query->bindParam(':brand',$brand,PDO::PARAM_STR);
$query->bindParam(':officesoverview',$officesoverview,PDO::PARAM_STR);
$query->bindParam(':priceperday',$priceperday,PDO::PARAM_STR);
$query->bindParam(':plan',$plan,PDO::PARAM_STR);
$query->bindParam(':modelyear',$modelyear,PDO::PARAM_STR);
$query->bindParam(':seatingcapacity',$seatingcapacity,PDO::PARAM_STR);
$query->bindParam(':airconditioner',$airconditioner,PDO::PARAM_STR);
$query->bindParam(':antilockbrakingsys',$antilockbrakingsys,PDO::PARAM_STR);
$query->bindParam(':powersteering',$powersteering,PDO::PARAM_STR);
$query->bindParam(':powerwindow',$powerwindow,PDO::PARAM_STR);

$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();

$msg="Actualizado Correctamente";


}


	?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Vos | Admin Editar oficina</title>

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
					
						<h2 class="page-title">Editar Oficina</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Información Básica</div>
									<div class="panel-body">
<?php if($msg){?><div class="succWrap"><strong>Completado</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
<?php 
$id=intval($_GET['id']);
$sql ="SELECT tbloficinas.*,tblbrands.BrandName,tblbrands.id as bid from tbloficinas join tblbrands on tblbrands.id=tbloficinas.officesBrand where tbloficinas.id=:id";
$query = $dbh -> prepare($sql);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Titulo de la Oficina<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="officetitle" class="form-control" value="<?php echo htmlentities($result->officesTitle)?>" required>
</div>
<label class="col-sm-2 control-label">Seleccionar Plan<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value="<?php echo htmlentities($result->bid);?>"><?php echo htmlentities($bdname=$result->BrandName); ?> </option>

<?php $ret="select id,BrandName from tblbrands";
$query= $dbh -> prepare($ret);
//$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$resultss = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($resultss as $results)
{
if($results->BrandName==$bdname)
{
continue;
} else{
?>
<option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->BrandName);?></option>
<?php }}} ?>

</select>
</div>
</div>
											
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Descripción <span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="officesoverview" rows="3" required><?php echo htmlentities($result->officesOverview);?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Precio por Hora(en USD)<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" value="<?php echo htmlentities($result->PriceperHour);?>" required>
</div>
<label class="col-sm-2 control-label">Salas de Conferencia<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="plan" required>
<option value="<?php echo htmlentities($result->Plan);?>"> <?php echo htmlentities($result->Plan);?> </option>

<option value="Si">Si</option>
<option value="No">No</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Disponibilidad<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="modelyear" class="form-control" value="<?php echo htmlentities($result->ModelYear);?>" required>
</div>
<label class="col-sm-2 control-label">Capacidad <span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" value="<?php echo htmlentities($result->SeatingCapacity);?>" required>
</div>
</div>
<div class="hr-dashed"></div>								
<div class="form-group">
<div class="col-sm-12">
<h4><b>Imágenes</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Imagen 1 <img src="img/officeimages/<?php echo htmlentities($result->Vimage1);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>">Cambiar Imagen 1</a>
</div>
<div class="col-sm-4">
Imagen 2<img src="img/officeimages/<?php echo htmlentities($result->Vimage2);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id)?>">Cambiar Imagen 2</a>
</div>
<div class="col-sm-4">
Imagen 3<img src="img/officeimages/<?php echo htmlentities($result->Vimage3);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id)?>">Cambiar Imagen 3</a>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Imagen 4<img src="img/officeimages/<?php echo htmlentities($result->Vimage4);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage4.php?imgid=<?php echo htmlentities($result->id)?>">Cambiar Imagen 4</a>
</div>
<div class="col-sm-4">
Imagen 5
<?php if($result->Vimage5=="")
{
echo htmlentities("No hay Resultados");
} else {?>
<img src="img/officeimages/<?php echo htmlentities($result->Vimage5);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage5.php?imgid=<?php echo htmlentities($result->id)?>">Cambiar Imagen 5</a>
<?php } ?>
</div>

</div>
<div class="hr-dashed"></div>									
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
<?php if($result->AirConditioner==1)
{?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="airconditioner" checked value="1">
<label for="inlineCheckbox1"> Computadoras </label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="airconditioner" value="1">
<label for="inlineCheckbox1"> Computadoras </label>
</div>
<?php } ?>
</div>
        
        <div class="col-sm-3">
<?php if($result->AntiLockBrakingSystem==1)
{?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="antilockbrakingsys" checked value="1">
<label for="inlineCheckbox3"> Datashow </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="antilockbrakingsys" value="1">
<label for="inlineCheckbox3"> Datashow </label>
</div>
<?php } ?>
        </div>

<div class="form-group">
<?php if($result->PowerSteering==1)
{
	?>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powersteering" checked value="1">
<label for="inlineCheckbox1"> Líneas Telefónicas </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powersteering" value="1">
<label for="inlineCheckbox1"> Líneas Telefónicas </label>
</div>
<?php } ?>
</div>

<div class="col-sm-3">
<?php if($result->PowerWindows==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powerwindow" checked value="1">
<label for="inlineCheckbox3"> Servicio Cafetería </label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powerwindow" value="1">
<label for="inlineCheckbox3"> Servicio Cafetería </label>
</div>
<?php } ?>
</div>





<?php }} ?>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2" >
<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Guardar Cambios</button>
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