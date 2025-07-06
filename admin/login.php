<?php

include '../components/connect.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $pass = sha1($_POST['pass']);

   echo "$name";
   echo "$pass";
   $select_admin = mysqli_query($conn, "SELECT * FROM db.admins WHERE name = 'harsh' AND password = 'harsh92'");
   $row = mysqli_fetch_assoc($select_admin);
   
   if(mysqli_num_rows($select_admin) > 0){
     session_start();
     $_SESSION['admin_id'] = $row['id'];
     $_SESSION['name'] = $row['name'];    
     header('location:dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="padding-left: 0;">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- register section starts  -->

<section class="form-container">

   <form action="" method="post" class="login">
      <h3>Welcome back!</h3>
      <p>Your name <span>*</span></p>
      <input type="text" name="name" placeholder="Enter your name" maxlength="20" required class="box">
      <p>Your password <span>*</span></p>
      <input type="password" name="pass" placeholder="Enter your password" maxlength="20" required class="box">
      <input type="submit" name="submit" value="Login now" class="btn">
   </form>

</section>

<!-- registe section ends -->





<script>

let darkMode = localStorage.getItem('dark-mode');
let body = document.body;

const enabelDarkMode = () =>{
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}else{
   disableDarkMode();
}

</script>
   
</body>
</html>