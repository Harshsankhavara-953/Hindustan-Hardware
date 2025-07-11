<?php
include 'components/connect.php';
require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//

$total = mysqli_real_escape_string($conn,$_POST['total_price']);
$name = mysqli_real_escape_string($conn,$_POST['name']);
$number = mysqli_real_escape_string($conn,$_POST['number']);
$email = mysqli_real_escape_string($conn,$_POST['email']);

if (isset($_POST['order'])) {

  
   $address = mysqli_real_escape_string($conn,$_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ' - ' . $_POST['pin_code']);
   $total_products = mysqli_real_escape_string($conn,$_POST['total_products']);
   $total_price = mysqli_real_escape_string($conn,$_POST['total_price']);

   $_SESSION['cname'] =  $name;
   $_SESSION['cnumber'] = $number;
   $_SESSION['cemail'] =  $email;
   $_SESSION['address'] = $address;
   $_SESSION['product'] = $total_products;
   $_SESSION['total_price'] = $total_price;
   
}



$orderData = [
    'receipt'         => 3456,
    'amount'          => $total * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}


$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "HINDUSTAN HARDWARE",
    "description"       => "Tron Legacy",
    "image"             => "project%20images/Screenshot%202022-12-18%20125033.png",
    "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => $number,
    ],
    "notes"             => [
    "address"           => "Hello World",
    "merchant_order_id" => "12312321",
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

?>

<!--  The entire list of Checkout fields is available at
 https://docs.razorpay.com/docs/checkout-form#checkout-fields -->

<form action="verify.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount="<?php echo $data['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id="3456"
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden" name="shopping_order_id" value="3456">
</form>

