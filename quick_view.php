<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
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
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="quick-view">



      

      <?php
      $pid = $_GET['pid'];
      $select_products = mysqli_query($conn, "SELECT * FROM db.products WHERE id = '$pid' ");
      $num = mysqli_num_rows($select_products);
      $list = mysqli_fetch_assoc($select_products);
      $name = $list['keyword'];
      if ($num> 0) {

      ?>
         <form action="" method="post" class="box" <?php if($list['stock'] == 0){echo 'disabled';}; ?>>
            <input type="hidden" name="pid" value="<?= $list['id']; ?>">
            <input type="hidden" name="name" value="<?= $list['name']; ?>">
            <input type="hidden" name="price" value="<?= $list['price']; ?>">
            <input type="hidden" name="image" value="<?= $list['image_01']; ?>">
            <div class="row">
               <div class="image-container">
                  <div class="main-image">
                     <img src="uploaded_img/<?= $list['image_01']; ?>" alt="">
                  </div>
                  <div class="sub-image">
                     <img src="uploaded_img/<?= $list['image_01']; ?>" alt="">
                     <img src="uploaded_img/<?= $list['image_02']; ?>" alt="">
                     <img src="uploaded_img/<?= $list['image_03']; ?>" alt="">
                  </div>
               </div>
               <div class="content">
                  <div class="name"><?= $list['name']; ?></div>

                  <div class="flex">
                     <div class="price">₹<?= $list['price']; ?><span>/-</span></div>
                     <?php if($list['stock'] != 0){ ?>
                     <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1"><?php }; ?>
                  </div>
                  <div class="details"><?= $list['details']; ?></div>
                  <?php if($list['stock'] > 9){ ?>
                     <span class="qtyA" style="color: green;"><i class="fas fa-check"></i> in stock</span>
                  <?php }elseif($list['stock'] == 0){ ?>
                     <span class="qtyA" style="color: red;"><i class="fas fa-times"></i> out of stock</span>
                  <?php }else{ ?>
                     <span class="qtyA" style="color: red;">hurry, only <?= $list['stock']; ?> left</span>
                  <?php } ?>
                  
                  <div class="flex-btn">
                     <?php if($list['stock'] != 0){ ?>
                     <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                     <?php }; ?>
                     <input class="option-btn" type="submit" name="add_to_wishlist" value="add to wishlist">
                  </div>
                  
               </div>
            </div>
         </form>
      <?php
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </section>

    <section class="Oproducts">

      <h1 class="heading">Similar products</h1>

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM db.products WHERE keyword LIKE '%{$name}%' LIMIT 3");

         if (mysqli_num_rows($select_products) > 0) {
            while ($list = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="" method="post" class="box" style="width: 95%; " >
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
                     <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                  </div>
                  <input type="submit" value="add to cart" class="btn" name="add_to_cart">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no products found!</p>';
         }
         ?>

      </div>

   </section>
   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>

   <?php include 'components/footer.php'; ?>
   
   <script src="js/script.js"></script>

</body>

</html>