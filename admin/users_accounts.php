<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>







<section class="display-product-table">

      <h1 class="heading">User accounts</h1>

      <table>

         <thead>
            <th style="width: 30px;">User Id</th>
            <th style="width: 100px;">User name</th>
            <th style="width: 200px;">User Email</th>
            <th style="width: 100px;">User Phone No.</th>
            <th style="width: 10px;">Order</th>
         </thead>

         <tbody>
            <?php

            $select_accounts =  mysqli_query($conn,"SELECT * FROM db.users ");
      if(mysqli_num_rows($select_accounts) > 0){
         while($list = mysqli_fetch_assoc($select_accounts)){ 
            ?>
                  <tr>
                     <td><?= $list['id']; ?></td>
                     <td style="text-transform: capitalize;"><?= $list['name']; ?></td>
                     <td><?= $list['email']; ?></td>
                     <td>+91<?= $list['phone_no']; ?></td>
                     <td>
                     <a href="placed_orders.php?user_id=<?= $list['id']; ?>"  class="option-btn">Show Order</a>
                     </td>
                  </tr>
            <?php
               };
            } else {
               echo "<div class='empty'>No product added</div>";
            };
            ?>
         </tbody>
      </table>

   </section>

<!-- <section class="accounts">

   <h1 class="heading">User accounts</h1>

   <div class="box-container">

   <?php
      $select_accounts =  mysqli_query($conn,"SELECT * FROM db.users ");
      if(mysqli_num_rows($select_accounts) > 0){
         while($list = mysqli_fetch_assoc($select_accounts)){   
   ?>
   <div class="box" style=" text-align: left;">
      <p> User id : <span><?= $list['id']; ?></span> </p>
      <p> Username : <span><?= $list['name']; ?></span> </p>
      <p> Email : <span><?= $list['email']; ?></span> </p>
      <a href="placed_orders.php?user_id=<?= $list['id']; ?>"  class="btn">Show Order</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No accounts available!</p>';
      }
   ?>

   </div>

</section> -->

<script src="../js/admin_script.js"></script>
   
</body>
</html>