<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];

   $update_profile = mysqli_query($conn, "UPDATE db.users SET name = '$name', email = '$email' WHERE id = '$user_id'");


   $empty_pass = 'd41d8cd98f00b204e9800998ecf8427e';
   $prev_pass = $_POST['prev_pass'];
   $old_pass = md5($_POST['old_pass']);
   $new_pass = md5($_POST['new_pass']);
   $cpass = md5($_POST['cpass']);

   if(isset($_POST['old_pass'])){
   if($old_pass == $empty_pass){
      $warning_msg[] = 'Please enter old password!';
   }elseif($old_pass != $prev_pass){
      $error_msg[] = 'Old password not matched!';
   }elseif($new_pass != $cpass){
      $warning_msg[] = 'Confirm password not matched!';
   }else{
      if($new_pass != $empty_pass){
         $update_admin_pass = mysqli_query($conn, "UPDATE db.users SET password = '$cpass' WHERE id = '$user_id'");
         $success_msg[] = 'Password updated successfully!';
      }else{
         $info_msg[] = 'Please enter a new password!';
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
      <h3>update now</h3>
      <input type="hidden" name="prev_pass" value="<?= $list["password"]; ?>">
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" value="<?= $list["name"]; ?>">
      <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $list["email"]; ?>">
      <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>