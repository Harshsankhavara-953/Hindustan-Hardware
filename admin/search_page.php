<?php

include '../components/connect.php';


session_start();
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

$search = '';  

if(isset($_POST['search']) or isset($_POST['search_btn'])){
$search = $_POST['search'];
}

$select_orders = mysqli_query($conn, "SELECT * FROM db.orders WHERE name LIKE '%{$search}%' order by id desc");
$select_products = mysqli_query($conn, "SELECT * FROM db.products WHERE keyword LIKE '%{$search}%' OR name LIKE '%{$search}%' OR details LIKE '%{#$search}%'   ");

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   echo $delete_id;
   $delete_order_item = mysqli_query($conn, "DELETE FROM db.order_items WHERE order_id = '$delete_id'");
   $delete_order = mysqli_query($conn, "DELETE FROM db.orders WHERE id = '$delete_id'");
   header('location:search_page.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_product_image = mysqli_query($conn, "SELECT * FROM db.products WHERE id = '$delete_id'");
   $fetch_delete_image = mysqli_fetch_assoc($delete_product_image);
   unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
   unlink('../uploaded_img/' . $fetch_delete_image['image_03']);
   $delete_product = mysqli_query($conn, "DELETE FROM db.products WHERE id = '$delete_id'");
   $delete_cart = mysqli_query($conn, "DELETE FROM db.cart WHERE pid = '$delete_id'");
   $delete_wishlist = mysqli_query($conn, "DELETE FROM db.wishlist WHERE pid = '$delete_id'");
   $message[] = 'Product Deleted!';
   header('location:search_page.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<?php if (mysqli_num_rows($select_orders) > 0) { ?>

 <section class="orders">

      <h1 class="heading">placed orders</h1>

      <div class="box-container">

         <?php
         
   
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
                        <input type="submit" value="update" class="option-btn" name="update_payment">
                        <a href="search_page.php?delete=<?= $list['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                     </div>
                  </form>
               </div>
         <?php
            }
         
         ?>

      </div>

   </section>

   <?php } ?>
   


<?php  if (mysqli_num_rows($select_products) > 0) { ?>

   <section class="display-product-table">

   <h1 class="heading">Products</h1>

      <table>

         <thead>
            <th style="width: 200px;">Product Image</th>
            <th>Product name</th>
            <th style="width: 180px;">Product Price</th>
            <th style="width: 200px;">Action</th>
         </thead>

         <tbody>
            <?php
               while ($list = mysqli_fetch_assoc($select_products)) {
            ?>
                  <tr>
                     <td><img src="../uploaded_img/<?= $list['image_01']; ?>" height="100" alt=""></td>
                     <td><?= $list['name']; ?></td>
                     <td><span>₹<?= $list['price']; ?></span>/-</td>
                     <td>
                        <a href="search_page.php?delete=<?= $list['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
                        <a href="update_product.php?update=<?= $list['id']; ?>&cat_name=<?= $list['keyword']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
                     </td>
                  </tr>
            <?php
               }
            ?>
         </tbody>
      </table>

   </section>

   <?php }?>


<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

</body>
</html>