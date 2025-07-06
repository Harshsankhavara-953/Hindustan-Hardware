<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>review</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">


</head>
<body>

<?php include '../components/admin_header.php'; ?>
   


<!-- view posts section starts  -->

<section class="view-post">

   <h1 class="heading">Reviews</h1>

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
         <img src="../project images\hh.jpg" alt="" class="image">
         
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

   <div class="heading">user's reviews <a></a></div>

   <div class="box-container">

   <?php
      $select_reviews = mysqli_query($conn, "SELECT * FROM db.reviews ");
      if(mysqli_num_rows($select_reviews) > 0){
         while($fetch_review = mysqli_fetch_assoc($select_reviews)){
   ?>
   <div class="box">
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

 <script src="../js/admin_script.js"></script>



</body>
</html>