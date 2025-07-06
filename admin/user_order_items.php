<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_GET['id'])) {
   $oid = $_GET['id'];
} 

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order items</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="Oproducts">
       <h1 class="heading">Order Details</h1>
    <div class="box-container">

         <?php
         $grand_total = 0;
         
         $select_products_name = mysqli_query($conn, "SELECT * FROM db.order_items where order_id = '$oid'");
         if (mysqli_num_rows($select_products_name) > 0) {
            while ($row = mysqli_fetch_assoc($select_products_name)) {
                $Pname = $row['product_name'];
                $select_products = mysqli_query($conn, "SELECT * FROM db.products where name = '$Pname'");
                if (mysqli_num_rows($select_products) > 0) {
            while ($list = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="" method="post" class="box">
                  <img src="../uploaded_img/<?= $list['image_01']; ?>" alt="">
                  <div class="name" style="height: 60px;"><?= $list['name']; ?></div>
                  <div class="flex">
                     <div class="price"><span>₹</span><?= $list['price']; ?><span>/-</span></div>
                      <div class="qtyT"><?= $row['quantity']; ?></div>
                  </div>
                  <div class="Tprice">Sub Total : <span>₹</span><?= ($row['product_price'] * $row['quantity']) ?><span>/-</span></div>
                   
               </form>
         <?php
         $grand_total += ($row['product_price'] * $row['quantity']); 
            }
        }
            }
         } else {
            echo '<p class="empty">no products found!</p>';
         }
         ?>

      </div>

      <div class="wishlist-total">
      <p>Grand total : <span>₹<?= $grand_total; ?>/-</span></p>
   </div>
        </section>
   <script src="js/script.js"></script>
</body>

</html>