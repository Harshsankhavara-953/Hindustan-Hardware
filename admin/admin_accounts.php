<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = mysqli_query($conn, "DELETE FROM db.admins WHERE id = '$delete_id' ");
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">admin accounts</h1>

   <div class="box-container">

   <div class="box">
      <p>Add new admin</p>
      <a href="register.php" class="option-btn">register admin</a>
   </div>

   <?php
      $select_accounts = mysqli_query($conn, "SELECT * FROM db.admins");
      if(mysqli_num_rows($select_accounts) > 0){
         while($list = mysqli_fetch_assoc($select_accounts)){   
   ?>
   <div class="box">
      <p> Admin id : <span><?= $list['id']; ?></span> </p>
      <p> Admin name : <span><?= $list['name']; ?></span> </p>
      <div class="flex-btn">
         <a href="admin_accounts.php?delete=<?= $list['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($list['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>
<script src="../js/admin_script.js"></script>
   
</body>
</html>