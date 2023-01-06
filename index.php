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
  <title> Vos Work </title>
  <!--Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
  <link rel="stylesheet" href="assets/css/animate.min.css" type="text/css">
  <link href="assets/css/slick.css" rel="stylesheet">
  <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
  <link href="assets/css/font-awesome.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>

<body>
  <!--Header-->
  <?php include('includes/header.php');?>
  <!-- /Header -->
  <!-- Banners -->

  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="banner" style="background-image: url(assets/images/banner-image.jpeg);" ></div>
                    <div class="carousel-caption">
                        <h1 class="animated bounceInRight white-text" style="animation-delay: 0.2s">Somos <span>Vos Work</span></h1>
                        <h3 class="animated bounceInLeft  white-text" style="animation-delay: 0.4s">Y te ofrecemos las mejores oficinas para tí</h3>
                        <p class="animated bounceInRight  white-text" style="animation-delay: 0.6s"><a href="#Oficinas">Ver Más</a></p>
                    </div>
                </div>
                <div class="item">
                    <div class="banner" style="background-image:url(assets/images/banner-image-2.jpg);"></div>
                    <div class="carousel-caption">
                        <h1 class="animated slideInDown white-text" style="animation-delay: 0.4s">Encuentra una <span>Oficina</span></h1>
                        <h3 class="animated fadeInUp white-text" style="animation-delay: 0.8s">Tenemos oficinas a tu comodidad</h3>
                        <p class="animated zoomIn white-text" style="animation-delay: 1.2s"><a href="#Oficinas">Ver Planes</a></p>
                    </div>
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>

<!-- /Banners -->
<!-- NUEVO -->
<section class="price-table" id="Oficinas">
        <div class="container">
            <div class="section-header text-center">
                <h2>Encuentra la mejor <span>Oficina para Tí</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Earum quo tenetur quibusdam eveniet, quod
                  aspernatur dignissimos, rem amet a voluptas mollitia ut reprehenderit, blanditiis iste voluptates totam.
                  Expedita, molestiae temporibus?
                </p>
              </div>
            <div class="row">
            <div class="col-md-12">
        <div class="result-sorting-wrapper">
      <div class="sorting-count">
<?php 
//Query for Listing count
$sql = "SELECT id from tbloficinas";
$query = $dbh -> prepare($sql);
$query->bindParam(':offid',$offid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=$query->rowCount();
?>
<p><span><?php echo htmlentities($cnt);?> Oficinas </span></p>
</div>
</div>

<?php $sql = "SELECT tbloficinas.*,tblbrands.BrandName,tblbrands.id as bid  from tbloficinas join tblbrands on tblbrands.id=tbloficinas.officesBrand";
$query = $dbh -> prepare($sql);
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
            <p class="list-price">$ <?php echo htmlentities($result->PriceperHour);?> Por Hora</p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity);?> Capacidad</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear);?></li>
              <li><i class="fa fa-comments" aria-hidden="true"></i><?php echo htmlentities($result->Plan);?></li>
            </ul>
            <a href="detalles.php?offid=<?php echo htmlentities($result->id);?>" class="btn"> Ver Detalles <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
          </div>
        </div>
      <?php }} ?>
    </div>
        </div>
        </div>
    </section>
<!-- /NUEVO -->
<!-- <div class="services-area section-padding secondary-bg text-center">
    <div class="container">
      <h2 class="section-header white-text">Servicios</h2>
      <div class="row text-center">
        <div class="col-sm-4">

          <div class="single-service">
            <div class="symbol">
              <i class="fa fa-coffee"></i>

            </div>
            <h4>Servicio de cafetería</h4>
            <p> Ofrecemos una alta velocidad de navegación por la web </p>
          </div>
        </div>
        <div class="col-sm-4">

          <div class="single-service">
            <div class="symbol">
              <i class="fa fa-comments"></i>

            </div>
            <h4>Sala de Reuniones</h4>
            <p> Ofrecemos una alta velocidad de navegación por la web </p>
          </div>
        </div>
        <div class="col-sm-4">

          <div class="single-service">
            <div class="symbol">
              <i class="fa fa-tty"></i>

            </div>
            <h4>Alquiler de líneas telefónicas</h4>
            <p> Ofrecemos una alta velocidad de navegación por la web </p>
          </div>
        </div>
        <div class="col-sm-4">

          <div class="single-service">
            <div class="symbol">
              <i class="fa fa-wifi"></i>

            </div>
            <h4>Internet de alta velocidad</h4>
            <p> Ofrecemos una alta velocidad de navegación por la web </p>
          </div>
        </div>
        <div class="col-sm-4">

          <div class="single-service">
            <div class="symbol">
              <i class="fa fa-print"></i>

            </div>
            <h4>Servicio de Impresora y fotocopiadora</h4>
            <p> Ofrecemos una alta velocidad de navegación por la web </p>
          </div>
        </div>
        <div class="col-sm-4">

          <div class="single-service">
            <div class="symbol">
              <i class="fa fa-tv"></i>

            </div>
            <h4>Sala de Conferencias</h4>
            <p> Ofrecemos una alta velocidad de navegación por la web </p>
          </div>
        </div>
      </div>
    </div>
</div> -->
  <!-- Resent Ct-->
  <!-- <section class="price-table" id="Oficinas">
        <div class="container">
            <div class="section-header text-center">
                <h2>Encuentra la mejor <span>Oficina para Tí</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Earum quo tenetur quibusdam eveniet, quod
                  aspernatur dignissimos, rem amet a voluptas mollitia ut reprehenderit, blanditiis iste voluptates totam.
                  Expedita, molestiae temporibus?
                </p>
              </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>Privadas</h2>
                            <p>Desde/<span>100$</span></p>
                        </div>
                        <div class="price-content ">
                            <ul>
                                <li>Acceso de Lunes a viernes</li>
                                <li>Internet de alta velocidad</li>
                                <li>Servicio de Recepcionista</li>
                                <li>Servicio de Cafetería</li>
                                <li>Capacidad de 1 a 10 personas</li>
                                <li>Oficinas Equipadas
                                </li>
                                <li>Sala de reuniones</li>
                            </ul>
                        </div>
                        <div class="price-bottom" >
                          <div class="buy-btn"><a href="listado.php"> EXPLORAR</a></div>
                            
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>Personales</h2>
                            <p>Desde/<span>100$</span></p>
                        </div>
                        <div class="price-content " >
                            <ul>
                                <li>Acceso de Lunes a viernes</li>
                                <li>Internet de alta velocidad</li>
                                <li>Oficinas Equipadas</li>
                                <li>Servicio de Recepcionista</li>
                                <li>Servicio de Cafetería</li>
                                <li>Escritorios Personales</li>
                                <li>Sala de reuniones</li>
                            </ul>
                            
                        </div>
                        <div class="price-bottom">
                        <div class="buy-btn"><a href="listado.php"> EXPLORAR</a></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>Independientes</h2>
                            <p>Desde/<span>100$</span></p>
                        </div>
                        <div class="price-content">
                            <ul>
                                <li>Acceso de Lunes a viernes</li>
                                <li>Internet de alta velocidad</li>
                                <li>Servicio de Recepcionista</li>
                                <li>Servicio de Cafetería</li>
                                <li>Sala de reuniones</li>
                            </ul>
                            
                        </div>
                        <div class="price-bottom" >
                        <div class="buy-btn"><a href="listado.php"> EXPLORAR</a></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="single-price">
                        <div class="price-head">
                            <h2>Virtuales</h2>
                            <p>Desde<span>100$</span></p>
                        </div>
                        <div class="price-content">
                            <ul>
                                <li>Dirección fiscal, postal y comercial</li>
                                <li>Internet de alta velocidad</li>
                                <li>Servicio de Recepcionista</li>
                                <li>Servicio de Cafetería</li>
                                <li>Renta de líneas telefónicas. </li>
                                <li>Sala de reuniones</li>
                                <li>Recepción de Mensajes</li>
                            </ul>
                        </div>
                        <div class="price-bottom" >
                        <div class="buy-btn"><a href="listado.php"> EXPLORAR</a></div>
                        </div>
                    </div>

                </div>
        </div>
        </div>
    </section> -->
  <!-- /Resent Cat -->

  <!-- Our Services-->

  <!-- /Our Services-->

  <!--Testimonial -->
  <section class="section-padding testimonial-section parallex-bg">
    <div class="container div_zindex">
      <div class="section-header white-text text-center">
        <h2>Nuestros <span>Clientes</span></h2>
      </div>
      <div class="row">
        <div id="testimonial-slider">
          <?php 
$tid=1;
$sql = "SELECT tbltestimonial.Testimonial,tblusers.FullName from tbltestimonial join tblusers on tbltestimonial.UserEmail=tblusers.EmailId where tbltestimonial.status=:tid";
$query = $dbh -> prepare($sql);
$query->bindParam(':tid',$tid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

          <div class="testimonial-m">
            <div class="testimonial-img"> <i class="fa fa-user" style="font-size: 290px;"></i> </div>
            <div class="testimonial-content">
              <div class="testimonial-heading">
                <h5><?php echo htmlentities($result->FullName);?></h5>
                <p><?php echo htmlentities($result->Testimonial);?></p>
              </div>
            </div>
          </div>
          <?php }} ?>
          <div class="testimonial-m">
            <div class="testimonial-img"> <i class="fa fa-user" style="font-size: 290px;"></i> </div>
            <div class="testimonial-content">
              <div class="testimonial-heading">
                <h5>Usuario1</h5>
                <p>Este es un buen servicio!</p>
              </div>
            </div>
          </div>
          <div class="testimonial-m">
            <div class="testimonial-img"> <i class="fa fa-user" style="font-size: 290px;"></i> </div>
            <div class="testimonial-content">
              <div class="testimonial-heading">
                <h5>Usuario 2 </h5>
                <p>Muy bueno lo recomiendo!</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- Dark Overlay-->
    <div class="dark-overlay"></div>
  </section>
  <!-- /Testimonial-->

  <div class="ubicacion-area section-padding  gray-bg">
    <div class="container">
      <div class="section-header text-center">
        <h2>Encuentranos <span>en :</span></h2>
        <p>Calle 18 de Calacoto Nº 8022, Edificio Parque 18, Piso 3 oficina 3b</p>

        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d956.1828361278491!2d-68.08117201113186!3d-16.53965525249734!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4d5b97a8fcf41e07!2sEdificio%20Parque%2018!5e0!3m2!1ses!2sbo!4v1622248031408!5m2!1ses!2sbo"
            allowfullscreen="yes" loading="lazy"></iframe>
        </div>

      </div>
    </div>
  </div>

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
  <!--/Forgot-password-Form -->
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