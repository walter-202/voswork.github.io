<?php

if (isset($_POST['submitsub'])){

    $email = $_POST['email'];
    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $apiKey = '2357d7a5b1d37efad4fc353b315968a1-us6';
        $listID = 'cec04b13d7';


        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/'. $listID . '/members/' . $memberID;


        $json = json_encode([
		'email_address' => $email,
		'status' => 'subscribed'
	    ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);


            if ($httpCode == 200) {
                echo "<script>alert('Te has suscrito Correctamente');</script>";
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            } else {
                switch($httpCode){
                    case 214:
                        echo "<script>alert('Ya estabas suscrito');</script>";
                        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
                        break;
                    default:
                    echo "<script>alert('Algo salió mal');</script>";
                    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";    
                    break;
                }
            }
        }else{
            echo "<script>alert('Ingrese un email válido');</script>";
echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        }
}