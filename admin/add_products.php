<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['add_product'])) {

   $name = $_POST['name'];
   $price = $_POST['price'];
   $details = $_POST['details'];
   $cat_name = $_POST['cat_name'];
   $stock = $_POST['qty'];

   $image_01 = $_FILES['image_01']['name'];
   // $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/' . $image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/' . $image_03;

   $select_products = mysqli_query($conn, "SELECT * FROM db.products WHERE name = '$name'");

   if (mysqli_num_rows($select_products) > 0) {
      $message[] = 'product name already exist!';
   } else {

      $insert_products = mysqli_query($conn, "INSERT INTO db.products (name, details, price,stock, image_01, image_02, image_03, keyword) VALUES('$name','$details','$price','$stock','$image_01','$image_02','$image_03','$cat_name')");

      if ($insert_products) {
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         $message[] = 'New product added!';
      }
   }
};

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
   header('location:products.php');
}



$show = true;
if(isset($_POST['ok'])){
   if(isset($_POST['category'])){
      $catgory = $_POST['category'];
      $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = '$catgory'");
      $show = false;
   }
}

if($show==true)
{
   $select_products = mysqli_query($conn, "SELECT * FROM db.products ");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="add-products">

      <h1 class="heading">add product</h1>
      

      <form action="" method="post" enctype="multipart/form-data">
         <div class="flex">
            <div class="inputBox">
               <span>Category id </span>
               <select name="cat_name" class="box" required>
                  <option value=""> Select Category </option>

                  <?php

                  // show category name in admin side 

                  $sql_cat = " SELECT cat_id,cat_name from db.category order by cat_id asc ";
                  $result = mysqli_query($conn, $sql_cat);
                  while ($row = mysqli_fetch_assoc($result)) {
                     echo ' <option value = ' . $row["cat_name"] . '> ' . $row["cat_name"]  . ' </option> ';
                  }
                  ?>

               </select>
            </div>
            <div class="inputBox">
               <span>Product name</span>
               <input type="text" class="box" required maxlength="100" placeholder="Enter product name" name="name">
            </div>
            <div class="inputBox">
               <span>Product price </span>
               <input type="number" min="0" class="box" required max="9999999999" placeholder="Enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
            </div>
            <div class="inputBox">
               <span>Product stock </span>
               <input type="number" min="0" class="box" required max="999" placeholder="Enter product stock" onkeypress="if(this.value.length == 1000) return false;" name="qty">
            </div>
            <div class="inputBox">
               <span>Image 01</span>
               <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Image 02</span>
               <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Image 03</span>
               <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
               <span>Product details</span>
               <textarea name="details" placeholder="Enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
            </div>
         </div>

         <input type="submit" value="add product" class="btn" name="add_product">
      </form>

   </section>


   <script src="../js/admin_script.js"></script>

</body>

</html>