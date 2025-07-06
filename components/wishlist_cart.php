<?php

if(isset($_POST['add_to_wishlist'])){

   if($user_id == ''){
      $warning_msg[] = 'Please Login First!';
      // header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $image = $_POST['image'];

      $check_wishlist_numbers = mysqli_query($conn,"SELECT * FROM db.wishlist WHERE name = '$name' AND user_id = '$user_id' ");

      if(mysqli_num_rows($check_wishlist_numbers) > 0){
         $info_msg[] = 'Already added to wishlist!';
      }
      else{
         $insert_wishlist = mysqli_query($conn,"INSERT INTO db.wishlist (user_id, pid, name, price, image) VALUES('$user_id', '$pid', '$name', '$price', '$image')");
         // $message[] = 'added to wishlist!';
      }

   }

}

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      $warning_msg[] = 'Please Login First!';
      // header('location:user_login.php');
   }else{

      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $image = $_POST['image'];
      $qty = $_POST['qty'];

      $check_cart_numbers = mysqli_query($conn,"SELECT * FROM db.cart WHERE name = '$name' AND user_id = '$user_id'");

      $select_p = mysqli_query($conn,"SELECT * FROM db.products WHERE id = '$pid'");
      $fetch_p = mysqli_fetch_assoc($select_p);

      if(mysqli_num_rows($check_cart_numbers) > 0){
         $info_msg[] = 'Already added to cart!';
      }elseif($fetch_p['stock'] == 0){
         $error_msg[] = 'Out of stock';
      }elseif($qty > $fetch_p['stock']){
         $info_msg[] = 'Only '.$fetch_p['stock'].' stock is left';
      }else{

         $check_wishlist_numbers = mysqli_query($conn,"SELECT * FROM db.wishlist WHERE name = '$name' AND user_id = '$user_id'");

         if(mysqli_num_rows($check_wishlist_numbers) > 0){
            $delete_wishlist = mysqli_query($conn,"DELETE FROM db.wishlist WHERE name = '$name' AND user_id = '$user_id'");
         }

         $insert_cart = mysqli_query($conn,"INSERT INTO db.cart (user_id, pid, name, price, quantity, image) VALUES('$user_id', '$pid', '$name', '$price', '$qty', '$image') ");
         // $message[] = 'Added to cart!';
         
      }

   }

}



?>
