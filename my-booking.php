<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/calendar.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?><!DOCTYPE HTML>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title> Reserva </title>
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

<!-- Google-Font-->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media Consultas -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->  
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!--Page Header-->
<!-- /Header --> 

<!--Page Header-->
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Mis Reservas</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Inicio</a></li>
        <li>Mis Reservas</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
<section class="user_profile inner_pages">
  <div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40">
      <div class="upload_user_logo"> <i class="fa fa-user" style="font-size: 120px;"></i>
      </div>

      <div class="dealer_info">
        <h5><?php echo htmlentities($result->FullName);?></h5>
        <p>Email: <?php echo htmlentities($result->EmailId);?><br>
          No Celular: <?php echo htmlentities($result->ContactNo);?>&nbsp;<?php echo htmlentities($result->Country); }}?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3">
       <?php include('includes/sidebar.php');?>
   
      <div class="col-md-9 col-sm-9">
        <div class="profile_wrap">
          <h5 class="uppercase underline">Mis Reservas </h5>
          <div class="my_office_list">
            <ul class="office_listing">
<?php 
$useremail=$_SESSION['login'];
 $sql = "SELECT tbloficinas.Vimage1 as Vimage1,tbloficinas.officesTitle,tbloficinas.id as vid,tblbrands.BrandName,tblbooking.date,tblbooking.timeslot,tblbooking.message,tblbooking.Status  from tblbooking join tbloficinas on tblbooking.officeId=tbloficinas.id join tblbrands on tblbrands.id=tbloficinas.officesBrand where tblbooking.userEmail=:useremail ORDER BY tblbooking.date DESC";
$query = $dbh -> prepare($sql);
$query-> bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

<li>
                <div class="office_img"> <a href="detalles.php?offid=<?php echo htmlentities($result->vid);?>"><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
                <div class="office_title">
                  <h6><a href="detalles.php?offid=<?php echo htmlentities($result->vid);?>"> <?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></a></h6>
                  <p><b>Fecha:</b> <?php echo htmlentities($result->date);?><br /> <b>Hora:</b> <?php echo htmlentities($result->timeslot);?></p>
                  <div style="float: left"><p><b>Mi Mensaje:</b> <?php echo htmlentities($result->message);?> </p></div>

                  <?php if($result->Status==1)
                { ?>
                <div class="office_status"> <a href="#" class="btn outline btn-xs active-btn">Confirmado</a>
                           <div class="clearfix"></div>
        </div>

              <?php } else if($result->Status==2) { ?>
 <div class="office_status"> <a href="#" class="btn outline btn-xs inactive-btn">Cancelado</a>
            <div class="clearfix"></div>
        </div>
             


                <?php } else { ?>
 <div class="office_status"> <a href="#" class="btn outline btn-xs ">En Revisión</a>
            <div class="clearfix"></div>
        </div>
                <?php } ?>
      
              </li>
              <?php }} ?>
                </div>
                
                
             
         
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/my-office--> 
<?php include('includes/footer.php');?>

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
<?php } ?>