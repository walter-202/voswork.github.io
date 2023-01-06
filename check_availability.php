<?php 
require_once("includes/config.php");
// code user email availablity
if(!empty($_POST["emailid"])) {
	$email= $_POST["emailid"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "<span class='error'> Error : No ingresaste un email válido.</span>";
	}
	else {
		$sql ="SELECT EmailId FROM tblusers WHERE EmailId=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span class='error'> El email ya existe en nuestra base de datos.</span>";
echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span class='good'> Email disponible para registrarse</span>";
echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}


?>
