<?php

require('config.php');
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};


require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

// if payment successfully done then this work.
if ($success === true)
{
    $transaction_id = $_POST['razorpay_payment_id'];
    
    $name = $_SESSION['cname'];
    $number = $_SESSION['cnumber'];
    $email = $_SESSION['cemail'];
    $address = $_SESSION['address'];
    $total_products = $_SESSION['product'];
    $total_price = $_SESSION['total_price'];
    

    $check_cart = mysqli_query($conn, "SELECT * FROM db.cart WHERE user_id = '$user_id'");

   if (mysqli_num_rows($check_cart) > 0) {

        // insert into order table
        $insert_order = mysqli_query($conn, "INSERT INTO db.orders(user_id, name, number, email, transaction_id, address, total_products, total_price) VALUES('$user_id', '$name', '$number', '$email', '$transaction_id', '$address', '$total_products', '$total_price')");

        // select order id from order table
        $select_id = mysqli_query($conn, " SELECT * FROM db.orders WHERE user_id = '$user_id'  order by id desc limit 1 ");
        $list = mysqli_fetch_assoc($select_id);
        $Oid = $list['id'];

        // all product transfer cart table to order_items table
        $cart = mysqli_query($conn," SELECT * FROM db.cart where user_id = '$user_id'");
        if (mysqli_num_rows($check_cart) > 0) {
        while ($row = mysqli_fetch_assoc($cart)){
        $Ppid = $row['pid'];
        $Pname = $row['name']; 
        $Pprice = $row['price'];
        $Pqty = $row['quantity'];
        // insert into order_items
        $insert_order_items = mysqli_query($conn,"INSERT INTO db.order_items(`order_id`, `product_name`, `product_price`, `quantity`) VALUES ('$Oid', '$Pname', '$Pprice', '$Pqty')");

        $select_p = mysqli_query($conn,"SELECT * FROM db.products WHERE id = '$Ppid'");
        $fetch_p = mysqli_fetch_assoc($select_p);
        $total_stock = ($fetch_p['stock'] - $Pqty);
        $update_stock = mysqli_query($conn,"UPDATE db.products SET stock = '$total_stock' WHERE id = '$Ppid'");

        // empty cart table
        if($update_stock){
        $delete_cart = mysqli_query($conn, "DELETE FROM db.cart WHERE user_id = '$user_id'");}
      }
    }    

   }

   header ('location: orders.php');
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;
