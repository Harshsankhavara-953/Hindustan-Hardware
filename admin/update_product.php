<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}


if(isset($_GET['cat_name']))
{
   $cat_name = $_GET['cat_name'];
}


if (isset($_POST['update'])) {

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $details = $_POST['details'];
   $cat__name = $_POST['cat_name'];
   $stock = $_POST['qty'];

   $update_product =  mysqli_query($conn, "UPDATE db.products SET name = '$name', price = '$price', stock = '$stock', details = '$details' , keyword = '$cat__name' WHERE id = '$pid' ");

   $message[] = 'product updated successfully!';

   
   $image_01 = $_FILES['image_01']['name'];
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/' . $image_01;

   if (!empty($image_01)) {
      if ($image_size_01 > 2000000) {
         $message[] = 'image size is too large!';
      } else {
         $update_image_01 =  mysqli_query($conn, "UPDATE db.products SET image_01 = '$image_01' WHERE id = '$pid'");
         move_uploaded_file($image_tmp_name_01, $image_folder_01);         
      }
   }

 
   $image_02 = $_FILES['image_02']['name'];
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/' . $image_02;

   if (!empty($image_02)) {
      if ($image_size_02 > 2000000) {
         $message[] = 'image size is too large!';
      } else {
         $update_image_02 =  mysqli_query($conn, "UPDATE db.products SET image_02 = '$image_02' WHERE id = '$pid'");
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
       
      }
   }

   $image_03 = $_FILES['image_03']['name'];
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/' . $image_03;

   if (!empty($image_03)) {
      if ($image_size_03 > 2000000) {
         $message[] = 'image size is too large!';
      } else {
         $update_image_03 =  mysqli_query($conn, "UPDATE db.products SET image_03 = '$image_03' WHERE id = '$pid'");
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
        
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="update-product">

      <h1 class="heading">update product</h1>

      <?php
      $update_id = $_GET['update'];
      $select_products =  mysqli_query($conn, "SELECT * FROM db.products WHERE id = '$update_id'");
      if (mysqli_num_rows($select_products) > 0) {
         while ($list = mysqli_fetch_assoc($select_products)) {
      ?>
            <form action="" method="post" enctype="multipart/form-data">
               <input type="hidden" name="pid" value="<?= $list['id']; ?>">
               <div class="image-container">
                  <div class="main-image">
                     <img src="../uploaded_img/<?= $list['image_01']; ?>" alt="">
                  </div>
                  <div class="sub-image">
                     <img src="../uploaded_img/<?= $list['image_01']; ?>" alt="">
                     <img src="../uploaded_img/<?= $list['image_02']; ?>" alt="">
                     <img src="../uploaded_img/<?= $list['image_03']; ?>" alt="">
                  </div>
               </div>
               <!-- category dropdown start -->
               <div class="inputBox">
                  <span>Category id </span>
                  <select name="cat_name" class="box">
                     <option value=""> Select Category </option>
                     <?php

                     // show category name in admin side 

                     $sql_cat = " SELECT cat_id,cat_name from db.category order by cat_id asc";
                     $result = mysqli_query($conn, $sql_cat);
                     while ($row1 = mysqli_fetch_assoc($result)){
                        if ($row1["cat_name"] == $cat_name) {
                           echo ' <option selected value = ' . $row1["cat_name"] . '> ' . $row1["cat_name"]  . ' </option> ';
                        } else {
                           echo ' <option value = ' . $row1["cat_name"] . '> ' . $row1["cat_name"]  . ' </option> ';
                        }
                     }
                     ?>

                  </select>
               </div>
               <!-- category dropdown end -->
               <span>update name</span>
               <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $list['name']; ?>">
               <span>update price</span>
               <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $list['price']; ?>">
               <span>update stock</span>
               <input type="number" name="qty" required class="box" min="0" max="999" placeholder="enter product stock" onkeypress="if(this.value.length == 1000) return false;" value="<?= $list['stock']; ?>">
               <span>update details</span>
               <textarea name="details" class="box" required cols="30" rows="10"><?= $list['details']; ?></textarea>
               <span>update image 01</span>
               <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
               <span>update image 02</span>
               <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
               <span>update image 03</span>
               <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
               <div class="flex-btn">
                  <input type="submit" name="update" class="btn" value="update">
                  <a href="products.php" class="option-btn">go back</a>
               </div>
            </form>

      <?php
         }
      } else {
         echo '<p class="empty">no product found!</p>';
      }
      ?>

   </section>
   <script src="../js/admin_script.js"></script>

</body>
</html>