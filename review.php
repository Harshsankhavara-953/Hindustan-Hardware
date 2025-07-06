<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


include 'components/user_header.php';


if(isset($_POST['delete_review'])){

   $delete_id = $_POST['delete_id'];

   $verify_delete = mysqli_query($conn,"SELECT * FROM db.reviews WHERE id = '$delete_id' ");
   
   if(mysqli_num_rows($verify_delete) > 0){
      $delete_review =mysqli_query($conn,"DELETE FROM db.reviews WHERE id = '$delete_id' ");
      $success_msg[] = 'Review deleted!';
   }else{  
      $warning_msg[] = 'Review already deleted!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Review</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   


<!-- view posts section starts  -->

<section class="view-post">

   <div class="headingR"><h1>Review</h1> </div>

   <?php
      

        $total_ratings = 0;
        $rating_1 = 0;
        $rating_2 = 0;
        $rating_3 = 0;
        $rating_4 = 0;
        $rating_5 = 0;

        $select_ratings = mysqli_query($conn,"SELECT * FROM db.reviews ");
        $total_reivews = mysqli_num_rows($select_ratings);
        while($fetch_rating = mysqli_fetch_assoc($select_ratings)){
            $total_ratings += $fetch_rating['rating'];
            if($fetch_rating['rating'] == 1){
               $rating_1 += 1;
            }
            if($fetch_rating['rating'] == 2){
               $rating_2 += 1;
            }
            if($fetch_rating['rating'] == 3){
               $rating_3 += 1;
            }
            if($fetch_rating['rating'] == 4){
               $rating_4 += 1;
            }
            if($fetch_rating['rating'] == 5){
               $rating_5 += 1;
            }
        }

        if($total_reivews != 0){
            $average = round($total_ratings / $total_reivews, 1);
        }else{
            $average = 0;
        }
        
   ?>
   <div class="row">
      <div class="col">
         <img src="project images\hh.jpg" alt="" class="image">
         
      </div>
      <div class="col">
         <div class="flex">
            <div class="total-reviews">
               <h3><?= $average ?><i class="fas fa-star"></i></h3>
               <p><?= $total_reivews ?> reviews</p>
            </div>
            <div class="total-ratings">
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_5 ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_4 ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_3 ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_2 ?></span>
               </p>
               <p>
                  <i class="fas fa-star"></i>
                  <span><?= $rating_1 ?></span>
               </p>
            </div>
         </div>
      </div>
   </div>

</section>

<!-- view posts section ends -->

<!-- reviews section starts  -->

<section class="reviews-container">

   <div class="headingR"><h1>user's reviews</h1> <a href="add_review.php" class="inline-btn" style="margin-top: 0;">add review</a></div>

   <div class="box-container">

   <?php
      $select_reviews = mysqli_query($conn, "SELECT * FROM db.reviews ");
      if(mysqli_num_rows($select_reviews) > 0){
         while($fetch_review = mysqli_fetch_assoc($select_reviews)){
   ?>
   <div class="box" <?php if($fetch_review['user_id'] == $user_id){echo 'style="order: -1;"';}; ?>>
      <?php
         $userid = $fetch_review['user_id'];
         $select_user = mysqli_query($conn, "SELECT * FROM db.users WHERE id = '$userid'");
         while($fetch_user = mysqli_fetch_assoc($select_user)){
      ?>
      <div class="user">
         <div>
            <span><h2><?= $fetch_user['name'] ?></h2></span>
            <span><?= $fetch_review['date'] ?></span>
         </div>
      </div>
      <?php }; ?>
      <div class="ratings">
         <?php  if($fetch_review['rating'] == 1){ ?>
            <p style="background:var(--red);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
         <?php  }; ?> 
         <?php if($fetch_review['rating'] == 2){ ?>
            <p style="background:var(--orange);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
         <?php }; ?>
         <?php  if($fetch_review['rating'] == 3){ ?>
            <p style="background:var(--orange);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
         <?php }; ?>   
         <?php if($fetch_review['rating'] == 4){ ?>
            <p style="background:var(--main-color);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
         <?php }; ?>
         <?php if($fetch_review['rating'] == 5){ ?>
            <p style="background:var(--main-color);"><i class="fas fa-star"></i> <span><?= $fetch_review['rating']; ?></span></p>
         <?php }; ?>
      </div>
      <?php if($fetch_review['description'] != ''){ ?>
         <p class="description"> <?= $fetch_review['description'] ?>
            </p>
      <?php }; ?>  
      <?php if($fetch_review['user_id'] == $user_id){ ?>
         <form action="" method="post" class="flex-btnR">
            <input type="hidden" name="delete_id" value="<?= $fetch_review['id'] ?>">
            <a href="update_review.php?id=<?= $fetch_review['id'] ?>" class="inline-option-btn">Edit review</a>
            <input type="submit" value="Delete review" class="inline-delete-btn" name="delete_review" onclick="return confirm('delete this review?');">
         </form>
      <?php }; ?>   
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no reviews added yet!</p>';
      }
   ?>

   </div>

</section>

<!-- reviews section ends -->













<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>

</body>
</html>