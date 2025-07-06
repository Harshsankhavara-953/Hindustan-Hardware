<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   $warning_msg[] = 'Please Login First!';
   // header('location:user_login.php');
};

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = mysqli_query($conn,"DELETE FROM db.wishlist WHERE id = '$wishlist_id'");
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = mysqli_query($conn,"DELETE FROM db.wishlist WHERE user_id = '$user_id' ");
   header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="Oproducts">

   <h3 class="heading">your wishlist</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_wishlist = mysqli_query($conn,"SELECT * FROM db.wishlist WHERE user_id = '$user_id' ");

      if(mysqli_num_rows($select_wishlist) > 0){
         while($list = mysqli_fetch_assoc($select_wishlist)){
            $grand_total += $list['price'];  
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $list['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $list['id']; ?>">
      <input type="hidden" name="name" value="<?= $list['name']; ?>">
      <input type="hidden" name="price" value="<?= $list['price']; ?>">
      <input type="hidden" name="image" value="<?= $list['image']; ?>">
      <a href="quick_view.php?pid=<?= $list['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $list['image']; ?>" alt="">
      <div class="name"><?= $list['name']; ?></div>
      <div class="flex">
         <div class="price">$<?= $list['price']; ?>/-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <input type="submit" value="delete item" onclick="return confirm('delete this from wishlist?');" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Your wishlist is empty</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>Grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from wishlist?');">delete all item</a>
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