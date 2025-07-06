<?php

include 'components/connect.php';

if(isset($_SESSION['otp'])){
	$otp = $_SESSION['otp'];
	echo $otp;
} 
else {
}



if (isset($_POST['submit'])) {

	$email = $_POST['email'];
	$sql = mysqli_query($conn, "SELECT * from db.users where email = '$email'");

	if (mysqli_num_rows($sql) > 0) {
		$row = mysqli_fetch_assoc($sql);

		$otp = rand(1111, 9999);
		$_SESSION['otp'] = $otp;
		// $_SESSION['email'] = $email;
		$html = "$otp is your otp";

		include 'smtp/PHPMailerAutoload.php';
		// $mail->SMTPDebug = 3;
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       =  587;
		$mail->SMTPSecure = "tls";
		$mail->SMTPAuth   = true;
		$mail->Username   = "harshsankhavara953@gmail.com";
		$mail->Password   = "xzmimoipifnuiwrb";
		$mail->setFrom("harshsankhavara953@gmail.com");
		//Recipients
		$mail->addAddress($email);

		// Content
		$mail->isHTML(true);
		// Set email format to HTML
		$mail->Subject = 'Reset your password';
		$mail->Body    = $html;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if ($mail->Send()) {
			
						
			header('location: ');
			
		} else {
			$error = 'Email not Sent. Please try again!';
		}
	} else {
		$error = 'Email not register';
	}
}
?>

