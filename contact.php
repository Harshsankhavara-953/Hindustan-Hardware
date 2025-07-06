<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   $warning_msg[] = 'Please Login First!';
};

if(isset($_POST['send'])){

    if($user_id == ''){
      $warning_msg[] = 'Please Login First!';
   }else{

   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $msg = $_POST['msg'];

   $select_message = mysqli_query($conn,"SELECT * FROM db.messages WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'");

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = mysqli_query($conn,"INSERT INTO `messages`(user_id, name, email, number, message) VALUES('$user_id','$name','$email','$number','$msg')");

      $success_msg[] = 'sent message successfully!';

   }
}

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>get in touch</h3>
      <input type="text" name="name" placeholder="Enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Enter your email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="Enter your number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="Send message" name="send" class="btn">
   </form>

</section>


<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>



<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>