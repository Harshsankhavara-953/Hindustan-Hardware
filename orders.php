<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = mysqli_query($conn,"SELECT * FROM db.orders WHERE user_id = '$user_id'");

         if(mysqli_num_rows($select_orders) > 0){
            while($row = mysqli_fetch_assoc($select_orders)){
   ?>
   <div class="box">
      <p>Placed on : <span><?= $row['placed_on']; ?></span></p>
      <p>Name : <span><?= $row['name']; ?></span></p>
      <p>Email : <span><?= $row['email']; ?></span></p>
      <p>Number : <span><?= $row['number']; ?></span></p>
      <p>Address : <span><?= $row['address']; ?></span></p>
      <p>Payment id : <span><?= $row['transaction_id']; ?></span></p>
      <p>Your Orders :<a href="order_items.php?id=<?= $row['id']; ?>">  <span><?= $row['total_products']; ?></span> </a></p>
      <p>Total price : <span> ₹ <?= $row['total_price']; ?>/-</span></p>
      <p> Payment status : <span style="color:<?php if($row['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $row['payment_status']; ?></span> </p>
      <p> Delivery status : <span style="color:<?php if($row['delivery_status'] == 'in progress'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $row['delivery_status']; ?></span> </p>
      <a href="invoice.php?id=<?= $row['id']; ?>" class="btn">Download Incoice</a>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

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