<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['submit'])) {

   $username = mysqli_real_escape_string($conn,$_POST['username']);
   $pass = mysqli_real_escape_string($conn,md5($_POST['pass']));

   $select_user = mysqli_query($conn, "SELECT * FROM db.users WHERE name = '$username' AND password = '$pass'");
   $row = mysqli_fetch_assoc($select_user);

   if (mysqli_num_rows($select_user) > 0) {
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
   }else{
      $error_msg[] = 'incorrect username or password!';
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

   <?php include 'components/user_header.php'; ?>

   <section class="form-container">

      <form action="" method="post">
         <h3>login now</h3>
         <input type="text" name="username" required placeholder="Username" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="Password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <a href="Forgot_password.php" class="forgot_pass"><p>Forgot password?<p></a>
         <input type="submit" value="login now" class="btn" name="submit">

         <p>Don't have an account?</p>
         <a href="user_register.php" class="option-btn">register now</a>
      </form>

   </section>

<!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>