<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
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
   <title>search page</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_box" placeholder="search here..." maxlength="100" class="box" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>
</section>

<section class="Oproducts" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
     if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
     $search_box = $_POST['search_box'];
     $select_products = mysqli_query($conn,"SELECT * FROM db.products WHERE keyword LIKE '%{$search_box}%' OR name LIKE '%{$search_box}%' OR details LIKE '%{$search_box}%' "); 
     
     if(mysqli_num_rows($select_products) > 0){
      while($list = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box">
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
      }else{
         echo '<p class="empty">no products found!</p>';
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