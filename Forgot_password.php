<?php

include 'components/connect.php';
// include 'components/Forgot_password_submit.php';

session_start();
$otp = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $sql = mysqli_query($conn, "SELECT * from db.users where email = '$email'");
    

    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $id = $row['id'];
        $html='';
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
        $expDate = date("Y-m-d H:i:s", $expFormat);
        $key = md5(time());
        $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
        $key = $key . $addKey;
        // Insert Temp Table
        $sql = mysqli_query($conn, "UPDATE db.users SET reset_key = '$key', expDate = '$expDate' WHERE (id = '$id')");
        $html .= '<p>Please click on the following link to reset your password.</p>';
        //replace the site url
        $html .= '<p><a href="http://localhost:7882/php/ecommerce__website/reset_password.php?key=' . $key . '&id=' . $id . '&action=reset" target="_blank">http://localhost:7882/php/ecommerce__website/reset_password.php?key=' . $key . '&id=' . $id . '&action=reset</a></p>';
        $body = $html;

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
        $mail->FromName = "Hindustan Hardware Gallery";
        //Recipients
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        // Set email format to HTML
        $mail->Subject = 'Reset your password';
        $mail->Body    = $body;
        if ($mail->Send()) {
            $info_msg[] = 'check your email to reset your password';
        } else {
            $warning_msg[] = "Mailer Error: " . $mail->ErrorInfo;
        }
    }
    else{   
        $error_msg[] = 'Email not register';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>


    <?php
    include 'components/user_header.php';

    ?>


    <section class="form-container" style="padding: 70px">

        <form action="" method="post">

            <h3 style="padding-bottom: 20px;">Recover Password</h3>
            
                <input type="text" name="email" id="email" placeholder="Enter your email" maxlength="50" class="box" required >
                <button class="btn" type="submit" name="submit">Sent Email</button>

            </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <?php include 'components/footer.php'; ?>
    <!-- <script>
        function email_sent_otp() {
            jQuery('#email').attr('disabled', true);
            var email = jQuery('#email').val();
            if (email == '') {
                jQuery("$email_error").html('Please enter email id');
            } else {
                jQuery.ajax({
                    url: 'components/Forgot_password_submit.php',
                    type: 'post',
                    data: 'email=' + email + 'type=email',
                    success: function(result) {
                        if (result == 'done') {
                            jQuery('#email').attr('disabled', true);
                            jQuery('.email_verify_otp').show();
                            jQuery('.email_sent_otp').hide();
                        }


                    }
                });
            }
        }

        function email_verify_otp() {
            var email_otp = jQuery('#email_otp').val()
            if (email_otp == '') {
                jQuery("#email_otp_result").html('Please enter otp');
            } else {
                jQuery.ajax({
                    url: 'components/password_otp.php',
                    type: 'post',
                    data: 'otp=' + email_otp + 'type=email',
                    success: function(result) {
                        if (result == 'done') {
                            jQuery('.email_verify_otp').hide();
                            jQuery('#email_otp_result').html('Email id verified');
                        } else {
                            jQuery('#email_error').html('please enter valid otp');
                        }


                    }
                });
                jQuery('.email_verify_otp').hide();
                jQuery('#email_otp_result').html('Email id verified');

            }
        }
    </script> -->
    <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>

    <script src="js/script.js"></script>





</body>

</html>