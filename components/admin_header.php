<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

      <form action="search_page.php" method="post" class="search-form">
         <input type="text" name="search" placeholder="Search here..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="reoprt-btn" class="fa-solid fa-file"></div>
         <!-- <div id="toggle-btn" class="fas fa-sun"></div> -->
      </div>

      <div class="profile">
         <?php
            $select_profile = mysqli_query($conn,"SELECT * FROM db.admins WHERE id = '$admin_id' ");
            if(mysqli_num_rows($select_profile) > 0){
            $fetch_profile = mysqli_fetch_assoc($select_profile);
         ?>
         <h3><?= $fetch_profile['name']; ?></h3>
         <a href="update_profile.php" class="btn">Update profile</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">Login</a>
            <a href="register.php" class="option-btn">Register</a>
         </div>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }
         ?>
      </div>

      <div class="report">
         <form action="genrate_report.php" method="post">
         <h3>Genrate Report</h3>
         <h1>Select first date</h1>
         <input type="date" name="date1" required placeholder="Select date" class="box">
         <h1>Select second date</h1>
         <input type="date" name="date2" required placeholder="Select date" class="box">
         <input type="submit" value="Genrate" class="btn" name="submit">
         </form>
      </div>



   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         
         <img src="../project images\hh.jpg" alt="" class="image">
   </div>

   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="add_products.php"><i class="fa-solid fa-plus"></i></i><span>Add Product</span></a>
      <a href="products.php"><i class="fa-solid fa-bag-shopping"></i></i><span>Show Products</span></a>
      <a href="placed_orders.php"><i class="fa-solid fa-bars-staggered"></i><span>Order</span></a>
      <a href="users_accounts.php"><i class="fa-solid fa-user"></i></i><span>Users</span></a>
      <a href="admin_accounts.php"><i class="fas fa-graduation-cap"></i><span>Admins</span></a>
      <a href="messages.php"><i class="fas fa-comment"></i><span>Message</span></a>
      <a href="admin_review.php"><i class="fas fa-star"></i><span>Review</span></a>
      <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>
   </nav>

</div>

<!-- side bar section ends -->