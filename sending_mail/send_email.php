<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container col-lg-6">
	<h2 class="text-center text-danger">Sending Email </h2>
	<form method="POST" action="">
		<div class="form-group">
			<label>To :</label>
			<input type="email" class="form-control" name="mail">
		</div>
		<div class="form-group">
			<label>Subject :</label>
			<input type="text" class="form-control" name="sub">
		</div>
		<div class="form-group">
			<label>Message :</label>
			<input type="text" class="form-control" name="msg">
		</div>
		<button type="submit" name="Sending" class="btn btn-success">Sending</button>
	</form> 
</div>
</body>
</html>
<?php
if(isset($_POST['Sending']))
{
	
	require ('crediential.php');
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require('PHPMailerAutoload.php');

// Load Composer's autoloader
//require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer;

    //Server settings
    $mail->SMTPDebug =4 ;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                   // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = EMAIL;                     // SMTP username
    $mail->Password   = PASS;                               // SMTP password
    $mail->SMTPSecure = 'TLS';        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port = 587;  

                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom(EMAIL, 'Bapi Cyber Zone');
    $mail->addAddress($_POST['mail']);     // Add a recipient
   
    $mail->addReplyTo(EMAIL);
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_POST['sub'];
    $mail->Body    = '<div class="container bg-light col-lg-6">
    <h2 class="text-danger text-center">Bapi Cyber Zone</h2>
    <h3 class="text-success">Your Verified Code.... <b class="text-danger">123456</b><h3>
    <h4>Massage Will Send :</h4>
    <p>'.$_POST['msg'].'</p>
    </div>';
    //$mail->AltBody = 

    if($mail->send())
    {
    	echo 'Message has been sent';
    }else{
    	 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}


?>