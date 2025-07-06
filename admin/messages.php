<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)) {
   header('location:login.php');
};

if(isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_message = mysqli_query($conn, "DELETE FROM db.messages WHERE id = '$delete_id' ");
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

   <?php include '../components/admin_header.php'; ?>

   <section class="contacts">

      <h1 class="heading">messages</h1>

      <div class="box-container">

         <?php
         $select_messages = mysqli_query($conn, "SELECT * FROM db.messages ");
         if (mysqli_num_rows($select_messages) > 0) {
            while ($list = mysqli_fetch_assoc($select_messages)) {
         ?>
               <div class="box">
                  <p> User id : <span><?= $list['user_id']; ?></span></p>
                  <p> Name : <span><?= $list['name']; ?></span></p>
                  <p> Email : <span><a href="mailto:<?= $list['email']; ?>"><?= $list['email']; ?></a></span></p>

                  <p> Number : <span><?= $list['number']; ?></span></p>
                  <p> Message : <span><?= $list['message']; ?></span></p>
                  <a href="messages.php?delete=<?= $list['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">You have no messages</p>';
         }
         ?>

      </div>

   </section>












   <script src="../js/admin_script.js"></script>

</body>

</html>