<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_POST['update_delivery'])) {
   $order_id = $_POST['order_id'];
   $delivery_status = $_POST['delivery_status'];
   $update_delivery = mysqli_query($conn, "UPDATE db.orders SET delivery_status = '$delivery_status' WHERE id =  '$order_id'");
   $message[] = 'Delivery status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   echo $delete_id;
   $delete_order_item = mysqli_query($conn, "DELETE FROM db.order_items WHERE order_id = '$delete_id'");
   $delete_order = mysqli_query($conn, "DELETE FROM db.orders WHERE id = '$delete_id'");
   header('location:placed_orders.php');
}

// show order by delivery status
if(isset($_GET['delivery_status'])){
   $d_status = $_GET['delivery_status'];
   $select_orders = mysqli_query($conn, "SELECT * FROM db.orders WHERE delivery_status = '$d_status'");
}
else{
$select_orders = mysqli_query($conn, "SELECT * FROM db.orders order by id desc");
}

// show order by user id 
if(isset($_GET['user_id'])){
   $user_id = $_GET['user_id'];
   $select_orders = mysqli_query($conn, "SELECT * FROM db.orders WHERE user_id = '$user_id'");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="orders">

      <h1 class="heading">placed orders</h1>

      <div class="box-container">

         <?php
         
         if (mysqli_num_rows($select_orders) > 0) {
            while ($list = mysqli_fetch_assoc($select_orders)) {
         ?>
               <div class="box">
                  <p> Placed on : <span><?= $list['placed_on']; ?></span> </p>
                  <p> Name : <span><?= $list['name']; ?></span> </p>
                  <p> Number : <span><?= $list['number']; ?></span> </p>
                  <p> Email : <span><?= $list['email']; ?></span></p>
                  <p> Address : <span><?= $list['address']; ?></span> </p>
                  <p> Total products :<a href="user_order_items.php?id=<?= $list['id']; ?>">  <span><?= $list['total_products']; ?></span> </a></p>
                  <p> Total price : <span>₹<?= $list['total_price']; ?>/-</span> </p>
                  <p> Payment id : <span><?= $list['transaction_id']; ?></span> </p>
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?= $list['id']; ?>">
                     <select name="delivery_status" class="select">
                        <option selected disabled><?= $list['delivery_status']; ?></option>
                        <option value="in progress">in progress</option>
                        <option value="completed">completed</option>
                     </select>
                     <div class="flex-btn">
                        <input type="submit" value="update" class="option-btn" name="update_delivery">
                        <a href="placed_orders.php?delete=<?= $list['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                     </div>
                  </form>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No orders placed yet!</p>';
         }
         ?>

      </div>

   </section>
   <script src="../js/admin_script.js"></script>

</body>

</html>