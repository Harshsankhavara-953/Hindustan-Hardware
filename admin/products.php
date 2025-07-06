<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
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
      $select_products = mysqli_query($conn, "SELECT * FROM db.products where keyword = '$catgory' order by id desc ");
      $show = false;
   }
}

if($show==true)
{
   $select_products = mysqli_query($conn, "SELECT * FROM db.products order by id desc ");
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


   
            <!-- Sort function  -->
            <sectionsort class="sort">

               <form action="" method="POST">
                     <div class="inputBox">

                              <span> Select Category  </sapn>
                              <select name="category" class="box">
                                 
                                 <option selected disabled> All </option>
                                 <?php

                                // show category name in admin side 

                                 $sql_cat = " SELECT cat_id,cat_name from db.category order by cat_id asc ";
                                 $result = mysqli_query($conn, $sql_cat);
                                 while ($row = mysqli_fetch_assoc($result)) {
                                    echo ' <option value = ' . $row["cat_name"] . '> ' . $row["cat_name"]  . ' </option> ';
                                 }
                                 ?>                           
                              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       
                              <!-- <select name="sort" class="box">
                                 <option selected disabled> Sort by </option>
                                 <option value="asc">Price -- Low to High</option>
                                 <option value="desc">Price -- High to Low</option>                        
                              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->

                              <input type="submit" value="Apply" class="btnsort" name="ok">
                     </div>                 
               </form>

            </sectionsort>
            



   <section class="display-product-table">

      <table>

         <thead>
            <th style="width: 200px;">Product Image</th>
            <th>Product name</th>
            <th style="width: 180px;">Product Price</th>
            <th style="width: 200px;">Action</th>
         </thead>

         <tbody>
            <?php

            $select_products = mysqli_query($conn, "SELECT * FROM db.products order by id desc ");
            if (mysqli_num_rows($select_products) > 0) {
               while ($list = mysqli_fetch_assoc($select_products)) {
            ?>

                  <tr>
                     <td><img src="../uploaded_img/<?= $list['image_01']; ?>" height="100" alt=""></td>
                     <td><?= $list['name']; ?></td>
                     <td><span>₹<?= $list['price']; ?></span>/-</td>
                     <td>
                        <a href="products.php?delete=<?= $list['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
                        <a href="update_product.php?update=<?= $list['id']; ?>&cat_name=<?= $list['keyword']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
                     </td>
                  </tr>

            <?php
               };
            } else {
               echo "<div class='empty'>No product added</div>";
            };
            ?>
         </tbody>
      </table>

   </section>

  








   <script src="../js/admin_script.js"></script>

</body>

</html>