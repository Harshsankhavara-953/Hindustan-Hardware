<?php

include '../vendor/autoload.php';
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){
	$date1 = $_POST['date1'];
	$date2 = $_POST['date2'];
}

$TodayDate = mktime(date("m"), date("d") , date("Y"));
$Date = date("Y-m-d", $TodayDate);

$sql1 = mysqli_query($conn, "SELECT * FROM db.orders WHERE placed_on between '$date1' AND '$date2' ");

$sql2 = mysqli_query($conn, "SELECT * FROM db.order_items where order_id = '$order_id'");

$html = '<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Download Invoice</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="6">
						<table>
							<tr>
								<td class="title">
									<img src="../project images/Screenshot 2022-12-18 125033.png" style="width: 90%; max-width: 160px" />
								</td>
								
								
								<td style="width:40% text-align:right;" >
									Created Report : '.$Date.'<br>
									From : '.$date1.'<br>
									To   : '.$date2.'
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								
								<td>
									 HINDUSATAN HARDWARE<br />
									harshsankhavara953@gmail.com
								</td>
							</tr>
						</table>
					</td>
				</tr>

				


				<tr class="heading">
					<td style="width: 6%;" >Id</td>
					<td style="text-align:left; width: 30%;">Name</td>
					<td style="text-align:left; width: 30%;">Transaction_id</td>
					<td style="width: 20%;text-align:center;">Placed_on</td>
					<td style="width: 21%;text-align:right;">Delivery Status</td>
					<td style="width: 10%;text-align:right;">Price</td>
				</tr>';

				$total_price = 0;
				while($list = mysqli_fetch_assoc($sql1)){
				$html.= '<tr class="item">
					<td style="width: 6%;" >'.$list['id'].'</td>
					<td style="width: 30%; text-align:left;">'.$list['name']. '</td>
					<td style="width: 30%; text-align:left;">'.$list['transaction_id'].'</td>
					<td style="width: 20%; text-align:center;">'.$list['placed_on'].'</td>
					<td style="width: 20%; text-align:center;">'.$list['delivery_status'].'</td>
					<td style="width: 10%;text-align:right;">₹'.$list['total_price'] .'</td>';
					$total_price+=$list['total_price'];
				'</tr>';
				}



$html.= '<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right; width: 20%;"><b>Total:₹' . $total_price . '</b> </td>
				</tr>';

$html .= '</table>
		</div>
	</body>
</html>';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);
$mpdf->Output();
?>