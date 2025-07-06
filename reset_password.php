<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>



    <?php
    include 'components/connect.php';
    $msg = '';

    if (isset($_GET["key"]) && isset($_GET["id"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
        $key = $_GET["key"];
        $id = $_GET["id"];
        $curDate = date("Y-m-d H:i:s");
        $query = mysqli_query($conn, "SELECT * FROM db.users WHERE reset_key='$key' and id = '$id' ");
        if (!mysqli_num_rows($query) > 0) {
            $msg = '<h2>Invalid Link</h2>';
        } else {
            $row = mysqli_fetch_assoc($query);
            $expDate = $row['expDate'];
            if ($expDate >= $curDate) {
    ?>
                <section class="form-container" style="padding: 70px">

                    <form action="" method="post" name="update">

                        <h3 style="padding-bottom: 20px;">Recover Password</h3>

                        <input type="password" name="pass1" class="box" placeholder="Enter New Password" required />

                        <input type="password" name="pass2" class="box" placeholder="Re-Enter New Password" required />

                        <input type="hidden" name="email" value="<?php echo $id; ?>" />

                        <input type="submit" name="submit" id="reset" value="Reset Password" class="btn" />



                    </form>
                </section> <?php
                        } else {
                            $msg = "<h1>Link Expired</h1>>";
                        }
                    }
                }


                if (isset($_POST['submit'])) {
                    $msg2 = "";
                    $pass1 = md5($_POST['pass1']);
                    $pass2 = md5($_POST['pass2']);
                    $curDate = date("Y-m-d H:i:s");
                    if ($pass1 != $pass2) {
                        $msg2 = "Password do not match, both password should be same";
                        $warning_msg[] = "Password do not match, both password should be same";
                    }
                    if ($msg2 == "") {
                        $pass1 = $pass1;
                        $sql =  mysqli_query($conn, "UPDATE db.users SET password = '$pass1' WHERE id = '$id' ");
                        $del_sql = mysqli_query($conn, "UPDATE db.users SET reset_key = '', expDate = '' WHERE id = '$id'");
                        if ($sql) {
                            header('location: user_login.php');
                        }
                    }
                }              
        ?>

                            <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/alers.php'; ?>


</body>

</html>