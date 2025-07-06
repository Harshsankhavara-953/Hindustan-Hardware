<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn,$_POST['name']);
   $email = mysqli_real_escape_string($conn,$_POST['email']);
   $pass = mysqli_real_escape_string($conn,md5($_POST['pass']));
   $cpass = mysqli_real_escape_string($conn,md5($_POST['cpass']));
   $number = mysqli_real_escape_string($conn,$_POST['number']);


   $sql1 = mysqli_query($conn,"SELECT * FROM db.users WHERE name = '$name'");
   $sql2 = mysqli_query($conn,"SELECT * FROM db.users WHERE email = '$email'");

   $row = mysqli_fetch_assoc($sql1);

   if(mysqli_num_rows($sql1) > 0){
      $error_msg[] = 'Username already exists!';
   }
   elseif(mysqli_num_rows($sql2) > 0){
      $error_msg[] = 'Email already registered!';
   }else{
      if($pass != $cpass){
         $warning_msg[] = 'Confirm password not matched!';
      }else{
         $insert_user = mysqli_query($conn,"INSERT INTO db.users (name, email, password,phone_no) VALUES('$name', '$email', '$cpass','$number')");
         if($insert_user){
         $success_msg[] = 'Registered successfully, login now please!';
         }
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
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Register now</h3>
      <input type="text" name="name" required placeholder="Username" maxlength="20"  class="box">
      <input type="email" name="email" required placeholder="Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="number" required placeholder="Mobile number" maxlength="10"  class="box">
      <input type="password" name="pass" required placeholder="Password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>Already have an account?</p>
      <a href="user_login.php" class="option-btn">Login now</a>
   </form>

</section>


<!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>



<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>