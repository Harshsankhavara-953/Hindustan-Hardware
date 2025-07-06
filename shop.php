<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/wishlist_cart.php';

$show = true;

if(isset($_POST['ok'])){

   if(isset($_POST['category'])){

      $category = $_POST['category'];

         if(isset($_POST['sort'])){

            $sort = $_POST['sort'];
            $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = '$category' order by price $sort");
            $show = false;
         }
         else{
            $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = '$category' ");
            $show = false;
         }
   }
   elseif(isset($_POST['sort'])){
      $sort = $_POST['sort'];
      $select_products = mysqli_query($conn, "SELECT * FROM db.products order by price $sort");
      $show = false;
   }
}
if($show == true ){
   $select_products = mysqli_query($conn, "SELECT * FROM db.products order by id desc");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>


   <?php
            // fetch category from database

            $cat_res =  mysqli_query($conn, "SELECT * From db.category");
            if (mysqli_num_rows($cat_res) > 0) {
               while ($list = mysqli_fetch_assoc($cat_res)) {
               $cat_arr = $list['cat_name'];
   ?>


   <section class="home-products">

      <!-- <h1 class="heading">Latest <?= $cat_arr ?></h1> -->

      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = '$cat_arr'  order by id desc");

            if (mysqli_num_rows($select_products) > 0) {
               while ($row = mysqli_fetch_assoc($select_products)) {
            ?>
                  <form action="" method="post" class="swiper-slide slide">
                     <input type="hidden" name="pid" value="<?= $row['id']; ?>">
                     <input type="hidden" name="name" value="<?= $row['name']; ?>">
                     <input type="hidden" name="price" value="<?= $row['price']; ?>">
                     <input type="hidden" name="image" value="<?= $row['image_01']; ?>">
                     <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                     <a href="quick_view.php?pid=<?= $row['id']; ?>" class="fas fa-eye"></a>
                     <img src="uploaded_img/<?= $row['image_01']; ?>" alt="">
                     <div class="name" style="height: 60px;"><?= $row['name']; ?></div>
                     <div class="flex">
                        <div class="price"><span>₹</span><?= $row['price']; ?><span>/-</span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                     </div>
                     <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                  </form>
            <?php
               }
            } else {
               echo '<p class="empty">no products added yet!</p>';
            }
            ?>

         </div>
         <div class="swiper-pagination"></div>

      </div>

   </section>

   <?php
            }}
   ?>

   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>

   <script src="js/script.js"></script>
   

   <script>
      var swiper = new Swiper(".products-slider", {
         slidesPerView: 5,
         loop: false,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            320: {
               slidesPerView: 1,
            },
            480: {
               slidesPerView: 2,
            },
            768: {
               slidesPerView: 3,
            },
            1200: {
               slidesPerView: 4,
            },
         },
      });
      // swiper.slideNext()
   </script>

</body>

</html>