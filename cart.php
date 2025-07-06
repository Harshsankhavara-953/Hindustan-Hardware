<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   $warning_msg[] = 'Please Login First!';
};

if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = mysqli_query($conn, "DELETE FROM db.cart WHERE id = '$cart_id' ");
}

if (isset($_GET['delete_all'])) {
   $delete_cart_item = mysqli_query($conn, "DELETE FROM db.cart WHERE user_id = '$user_id'");
   header('location:cart.php');
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $update_qty = mysqli_query($conn, "UPDATE db.cart SET quantity = '$qty' WHERE id = '$cart_id'");
   $success_msg[] = 'cart quantity updated';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="Oproducts shopping-cart">

      <h3 class="heading">shopping cart</h3>

      <div class="box-container">

         <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM db.cart WHERE user_id = '$user_id'");
         if (mysqli_num_rows($select_cart) > 0) {
            while ($row = mysqli_fetch_assoc($select_cart)) {
         ?>
               <form action="" method="post" class="box">
                  <input type="hidden" name="cart_id" value="<?= $row['id']; ?>">
                  <a href="quick_view.php?pid=<?= $row['pid']; ?>" class="fas fa-eye"></a>
                  <img src="uploaded_img/<?= $row['image']; ?>" alt="">
                  <div class="name" style="height: 56px;"><?= $row['name']; ?></div>
                  <div class="flex">
                     <div class="price">₹<?= $row['price']; ?>/-</div>
                     <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $row['quantity']; ?>">
                     <button type="submit" class="fas fa-edit" name="update_qty"></button>
                  </div>
                  <div class="sub-total"> sub total : <span>₹<?= $sub_total = ($row['price'] * $row['quantity']); ?>/-</span> </div>
                  <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
               </form>
         <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty">your cart is empty</p>';
         }
         ?>
      </div>

      <div class="cart-total">
         <p>grand total : <span>₹<?= $grand_total; ?>/-</span></p>
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all item</a>
         <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
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