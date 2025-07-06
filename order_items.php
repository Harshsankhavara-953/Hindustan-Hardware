<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id']) or isset($_GET['id'])) {
   $user_id = $_SESSION['user_id'];
   $oid = $_GET['id'];
} else {
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="Oproducts">
       <h1 class="heading">Your Order Details</h1>
       
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
               <form action="" method="post" class="box" style="height: 100%;">
                  <input type="hidden" name="pid" value="<?= $list['id']; ?>">
                  <input type="hidden" name="name" value="<?= $list['name']; ?>">
                  <input type="hidden" name="price" value="<?= $list['price']; ?>">
                  <input type="hidden" name="image" value="<?= $list['image_01']; ?>">
                  <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                  <a href="quick_view.php?pid=<?= $list['id']; ?>" class="fas fa-eye"></a>
                  <img src="uploaded_img/<?= $list['image_01']; ?>" alt="">
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
      <a href="shop.php" class="option-btn">continue shopping</a>
   </div>
        </section>

   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>
   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>