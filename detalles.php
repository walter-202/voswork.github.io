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
<title> Detalles </title>
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

    
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<style>
       @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {

            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: grid;
            }
            
            .empty {
                display: none;
            }

            /* Hide table headers (but not display: none;, for accessibility) */
            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }



            /*
		Label the data
		*/
            .td:nth-of-type(1):before {
                content: "Domingo";
            }
            .td:nth-of-type(2):before {
                content: "Lunes";
            }
            .td:nth-of-type(3):before {
                content: "Martes";
            }
            .td:nth-of-type(4):before {
                content: "Miércoles";
            }
            .td:nth-of-type(5):before {
                content: "Jueves";
            }
            .td:nth-of-type(6):before {
                content: "Viernes";
            }
            .td:nth-of-type(7):before {
                content: "Sábado";
            }


        }

        /* Smartphones (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        /* iPads (portrait and landscape) ----------- */

        @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
        }

        @media (min-width:641px) {
            table {
                table-layout: fixed;
            }
            
        }
        
        .row{
            margin-top: 20px;
        }
        
        .today{
            background:#fcf8e3;
        }
        
        
        
    </style>
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Listing-Image-Slider-->

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

<section id="listing_img_slider">
  <div><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage1);?>"  class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage2);?>"  class="img-responsive"  alt="image" width="900" height="560"></div>
  <div><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage3);?>"  class="img-responsive"  alt="image" width="900" height="560"></div>
  <div><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage4);?>"  class="img-responsive"  alt="image" width="900" height="560"></div>
  <?php if($result->Vimage5=="")
{

} else {
  ?>
  <div><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage5);?>"  class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>
<!--/Listing-Image-Slider-->


<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>$<?php echo htmlentities($result->PriceperHour);?> </p>Por hora 
         
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="main_features">
          <ul>
          
            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->ModelYear);?></h5>
              <p> Disponible de:</p>
            </li>
            <li> <i class="fa fa-comments" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->Plan);?></h5>
              <p> Conferencias</p>
            </li>
       
            <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->SeatingCapacity);?></h5>
               <p> Capacidad</p>
            </li>
          </ul>
        </div>

        <div class="col-md-12">
      
        <div class="share_office">
          <p>Compartir: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
        </div>
      </div>

        <div class="listing_more_info">
          <div class="listing_detail_wrap"> 
            <!-- Nav tabs -->
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#office-overview " aria-controls="office-overview" role="tab" data-toggle="tab">Descripción </a></li>
          
              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accesorios</a></li>

              <li role="presentation"><a href="#reservacion " aria-controls="reservacion" role="tab" data-toggle="tab">Reservar </a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content"> 
              <!-- office-overview -->
              <div role="tabpanel" class="tab-pane active" id="office-overview">
                
                <p><?php echo htmlentities($result->officesOverview);?></p>
              </div>
              
              <!-- Reserva -->
          <div role="tabpanel" class="tab-pane " id="reservacion">
                
                <h3>Haz tu Reserva:</h3>

        <div class="row">
            <div class="col-md-12">
            <div class="alert alert-success">Escoje el día y la hora que quieras reservar, cuando escojas el horario se te dirigirá directamente al pago para completar la reserva</div>

            <?php if($_SESSION['login'])
              {?>
              <div class="form-group">
                    <div id="calendar"></div>
              </div>
              <?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Regístrate para reservar</a>

              <?php } ?>
               


            </div>
        </div>

          
          </div>
          

          <!-- TIMESLOTS -->


          
<!--/timeslots-->


              <!-- Reserva -->
              <!-- Accesorios -->
              <div role="tabpanel" class="tab-pane" id="accessories"> 
                <!--Accesorios-->
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Accesorios</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Computadoras</td>
<?php if($result->AirConditioner==1)
{
?>
                      <td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?> 
   <td><i class="fa fa-close" aria-hidden="true"></i></td>
   <?php } ?> </tr>

<tr>
<td>Datashow</td>
<?php if($result->AntiLockBrakingSystem==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
                    </tr>

<tr>
<td>Líneas Telefonicas</td>
<?php if($result->PowerSteering==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   

<tr>

<td>Servicio de Cafetería</td>

<?php if($result->PowerWindows==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   
 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
<?php }} ?>
   
      </div>
      
      
    </div>
    
    <div class="space-20"></div>
    <div class="divider"></div>
    
    <!--Similar-office-->
    <div class="similar_office">
      <h3>Similares</h3>
      <div class="row">
<?php 
$bid=$_SESSION['brndid'];
$sql="SELECT tbloficinas.officesTitle,tblbrands.BrandName,tbloficinas.PriceperHour,tbloficinas.Plan,tbloficinas.ModelYear,tbloficinas.id,tbloficinas.SeatingCapacity,tbloficinas.officesOverview,tbloficinas.Vimage1 from tbloficinas join tblbrands on tblbrands.id=tbloficinas.officesBrand where tbloficinas.officesBrand=:bid";
$query = $dbh -> prepare($sql);
$query->bindParam(':bid',$bid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>      
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="detalles.php?offid=<?php echo htmlentities($result->id);?>"><img src="admin/img/officeimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="detalles.php?offid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->officesTitle);?>-<span><?php echo htmlentities($result->BrandName);?></a></h5>
              <p class="list-price">$<?php echo htmlentities($result->PriceperHour);?></p>
          
              <ul class="features_list">
                
             <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity);?>Capacidad</li>
                <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear);?></li>
                <li><i class="fa fa-comments" aria-hidden="true"></i><?php echo htmlentities($result->Plan);?></li>
              </ul>
            </div>
          </div>
        </div>
 <?php }}?>       

      </div>
    </div>
    <!--/Similar-office--> 
    
  </div>
</section>
<!--/Listing-detail--> 

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

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 

<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
<script > 
$.ajax({
    url:"calendar.php",
    type:"POST",
    data: {'offid':'<?php echo date($offid);?>','month':'<?php echo date('m');?>','year':'<?php echo date('Y')?>'},
    success: function(data){
        $("#calendar").html(data);
    }

});

$(document).on('click','.changemonth',function(){
$.ajax({
    url: "calendar.php",
    type:"POST",
    data: {'offid': $(this).data('offid'), 'month': $(this).data('month'), 'year':$(this).data('year')},
    success: function(data){
        $("#calendar").html(data);
    }   
    });
});
</script> 
</body>
</html>
