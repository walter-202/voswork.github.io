<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Listado</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<!-- Fav and touch icons -->

<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>
<!--Header--> 
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Page Header-->
<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Lista de Oficinas</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Lista de Oficinas</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<!--Listing-->
<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
<?php 
//Query for Listing count
$brand=$_POST['brand'];
$Plan=$_POST['Plan'];
$sql = "SELECT id from tbloficinas where tbloficinas.officesBrand=:brand and tbloficinas.Plan=:Plan";
$query = $dbh -> prepare($sql);
$query -> bindParam(':brand',$brand, PDO::PARAM_STR);
$query -> bindParam(':Plan',$Plan, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=$query->rowCount();
?>
<p><span><?php echo htmlentities($cnt);?> Listado</span></p>
</div>
</div>

<?php 

$sql = "SELECT tbloficinas.*,tblbrands.BrandName,tblbrands.id as bid  from tbloficinas join tblbrands on tblbrands.id=tbloficinas.officesBrand where tbloficinas.officesBrand=:brand and tbloficinas.Plan=:Plan";
$query = $dbh -> prepare($sql);
$query -> bindParam(':brand',$brand, PDO::PARAM_STR);
$query -> bindParam(':Plan',$Plan, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>
        <div class="product-listing-m gray-bg">
          <div class="product-listing-img"><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="Image" /> </a> 
          </div>
          <div class="product-listing-content">
            <h5><a href="detalles.php?offid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></a></h5>
            <p class="list-price">$<?php echo htmlentities($result->PriceperHour);?> Por Hora</p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity);?>Capacidad</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear);?></li>
              <li><i class="fa fa-comments" aria-hidden="true"></i><?php echo htmlentities($result->Plan);?></li>
            </ul>
            <a href="detalles.php?offid=<?php echo htmlentities($result->id);?>" class="btn">Ir a Reservar <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
          </div>
        </div>
      <?php }} ?>
         </div>
      
      <!--Side-Bar-->
      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter" aria-hidden="true"></i> Volver al Listado </h5>
          </div>
          <p> Click aquí para <a href="listado.php"> Volver </a></p>
        </div>

        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-comments" aria-hidden="true"></i>Oficinas Recientes</h5>
          </div>
          <div class="recent_addedoff">
            <ul>
<?php $sql = "SELECT tbloficinas.*,tblbrands.BrandName,tblbrands.id as bid  from tbloficinas join tblbrands on tblbrands.id=tbloficinas.officesBrand order by id desc limit 4";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

              <li class="gray-bg">
                <div class="recent_post_img"> <a href="detalles.php?offid=<?php echo htmlentities($result->id);?>"><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
                <div class="recent_post_title"> <a href="detalles.php?offid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></a>
                  <p class="widget_price">$<?php echo htmlentities($result->PriceperHour);?> Por Hora</p>
                </div>
              </li>
              <?php }} ?>
              
            </ul>
          </div>
        </div>
      </aside>
      <!--/Side-Bar--> 
    </div>
  </div>
</section>
<!-- /Listing--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 


<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
