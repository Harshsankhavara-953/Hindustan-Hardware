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
   <title>Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <div class="home-bg">

      <section class="home">

         <div class="swiper home-slider">

            <div class="swiper-wrapper">

               <div class="swiper-slide slide">
                  <!-- <div class="image">
                     <img src="images/6-removebg-preview.png" alt="">
                  </div> -->
                  <div class="content">

                     <h3>Laxury Faucet</h3>
                     <a href="category.php?category=Faucet" class="btn">shop now</a>
                  </div>
               </div>

               <!-- <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/home-img-2.png" alt="">
                  </div>
                  <div class="content">
                     <span>upto 50% off</span>
                     <h3>latest watches</h3>
                     <a href="shop.php" class="btn">shop now</a>
                  </div>
               </div>

               <div class="swiper-slide slide">
                  <div class="image">
                     <img src="images/home-img-3.png" alt="">
                  </div>
                  <div class="content">
                     <span>upto 50% off</span>
                     <h3>latest headsets</h3>
                     <a href="shop.php" class="btn">shop now</a>
                  </div>
               </div> -->

            </div>

            <div class="swiper-pagination"></div>

         </div>

      </section>

   </div>

   <section class="category">

      <h1 class="heading">shop by category</h1>

      <div class="swiper category-slider">

         <div class="swiper-wrapper">



            <?php

            // fetch category from database

            $cat_res =  mysqli_query($conn, "SELECT * From db.category order by cat_id asc");
            $cat_arr = array();

            while ($row = mysqli_fetch_assoc($cat_res)) {
               $cat_arr[] = $row;
            }
            foreach ($cat_arr as $list) {
            ?>

               <a href="category.php?category=<?php echo $list['cat_name'] ?>" class="swiper-slide slide" style="height: 195px;">
                  <img src=" <?php echo 'images/' . $list['img'] ?>" alt="Image" style="height: 120px;">
                  <h3><?php echo $list['cat_name']
                        ?></h3>
               </a>

            <?php
            }
            ?>
         </div>
         <div class="swiper-pagination"></div>

   </section>

   <section class="home-products">

      <h1 class="heading">Latest Products</h1>

      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM db.products  order by id desc LIMIT 8");

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
                        <input type="number" name="qty" class="qty" min="1" max="9" onkeypress="if(this.value.length == 2) return false;" value="1">
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


   <section class="home-products">

      <h1 class="heading">Latest Holders</h1>

      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = 'Holders'  order by id desc LIMIT 8");

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
                        <input type="number" name="qty" class="qty" min="1" max="9" onkeypress="if(this.value.length == 2) return false;" value="1">
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

   <section class="home-products">

      <h1 class="heading">Latest Faucet</h1>

      <div class="swiper products-slider">

         <div class="swiper-wrapper">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = 'Faucet'  order by id desc LIMIT 8");

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
                        <input type="number" name="qty" class="qty" min="1" max="9" onkeypress="if(this.value.length == 2) return false ;" value="1">
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


   <?php include 'components/footer.php'; ?>

   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>

   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".home-slider", {
         loop: false,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
      });

      var swiper = new Swiper(".category-slider", {
         loop: false,
         spaceBetween: 20,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         breakpoints: {
            0: {
               slidesPerView: 2,
            },
            650: {
               slidesPerView: 3,
            },
            768: {
               slidesPerView: 4,
            },
            1024: {
               slidesPerView: 4,
            },
         },
      });

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