<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   $warning_msg[] = 'Please Login First!';
};

if(isset($_POST['submit'])){

      if($user_id == ''){
         $warning_msg[] = 'Please Login First!';
      }else{

         $description = $_POST['description'];
         $rating = $_POST['rating'];
         $verify_review = mysqli_query($conn, "SELECT * FROM db.reviews WHERE user_id = '$user_id'");

         if(mysqli_num_rows($verify_review) > 0){
            $warning_msg[] = 'Your review already added!';
         }else{
            $add_review = mysqli_query($conn , "INSERT INTO db.reviews (user_id, rating,description) VALUES('$user_id','$rating','$description')");
            $success_msg[] = 'Review added!';
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
   <title>Add review</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
   

<!-- add review section starts  -->

<section class="account-form">

   <form action="" method="post">
      <h3>post your review</h3>
      <p class="placeholder">Review description</p>
      <textarea name="description" class="box" placeholder="Enter review description" maxlength="1000" cols="30" rows="10"></textarea>
      <p class="placeholder">Review rating <span>*</span></p>
      <select name="rating" class="box" required>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
      </select>
      <input type="submit" value="Submit review" name="submit" class="btn">
      <a href="review.php" class="option-btn">go back</a>
   </form>

</section>

<!-- add review section ends -->

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>

</body>
</html>