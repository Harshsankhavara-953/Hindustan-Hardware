<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

if (isset($_POST['order'])) {

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $address = 'Flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ' - ' . $_POST['pin_code'];
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = mysqli_query($conn, "SELECT * FROM db.cart WHERE user_id = '$user_id'");

   if (mysqli_num_rows($check_cart) > 0) {

      $insert_order = mysqli_query($conn, "INSERT INTO db.orders(user_id, name, number, email,address, total_products, total_price) VALUES('$user_id', '$name', '$number', '$email','$address', '$total_products', '$total_price')");
      if($insert_order){
         $sql = mysqli_query($conn, "SELECT * FROM db.orders WHERE user_id = '$user_id' order by id desc limit 1" );
         $list = mysqli_fetch_assoc($sql);
         $Pname = $_POST['Pname'];
         $Pprice = $_POST['Pprice'];
         $Pqty = $_POST['Pqty'];
         $Pid = $list['id'];
         $sql1 = mysqli_query($conn, "INSERT INTO db.order_items (`order_id`, `product_name`, `product_price`, `quantity`) VALUES ('$Pid', '$Pname', '$Pprice', '$Pqty')");

         $delete_cart = mysqli_query($conn, "DELETE FROM db.cart WHERE user_id = '$user_id'");
      }
      
      

      $success_msg[] = 'order placed successfully!';
   } else {
      $info_msg[] = 'your cart is empty';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="checkout-orders">

      <form action="pay.php" method="POST">

         <h3>your orders</h3>

         <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = mysqli_query($conn, "SELECT * FROM db.cart WHERE user_id = '$user_id'");
            if (mysqli_num_rows($select_cart) > 0) {
               while ($row = mysqli_fetch_assoc($select_cart)) {

                  $cart_items[] = $row['name'] . ' (' . $row['price'] . ' x ' . $row['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($row['price'] * $row['quantity']);
            ?>
                  <p> <?= $row['name']; ?> <span>(<?='₹'. $row['price'] . '/- x ' . $row['quantity']; ?>)</span> </p>
            <?php
               }
            } else {
               echo '<p class="empty">your cart is empty!</p>';
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
            <div class="grand-total">grand total : <span>₹<?= $grand_total; ?>/-</span></div>
         </div>

         <h3>Place your orders</h3>

         <div class="flex">
            <div class="inputBox">
               <span>Your name :</span>
               <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>Mobile number :</span>
               <input type="text" name="number" placeholder="Enter your number" class="box" onkeypress="if(this.value.length == 10) return false;" required>
            </div>
            <div class="inputBox">
               <span>Your email :</span>
               <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
            </div>
            
            <div class="inputBox">
               <span>Address line 01 :</span>
               <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Address line 02 :</span>
               <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Area :</span>
               <input type="text" name="city" placeholder="e.g. Nikol" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>Pin code :</span>
               <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
            </div>
         </div>

         <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value="place order">

      </form>

   </section>

   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>