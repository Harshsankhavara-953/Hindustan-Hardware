<?php

include 'vendor/autoload.php';
include 'components/connect.php';

session_start();

$user_id = $_SESSION['user_id'];
$order_id = $_GET['id'];

$TodayDate = mktime(date("m"), date("d") , date("Y"));
$Date = date("Y-m-d", $TodayDate);

$sql = mysqli_query($conn, "SELECT * FROM db.orders WHERE user_id = '$user_id' AND id = '$order_id' ");

$sql2 = mysqli_query($conn, "SELECT * FROM db.order_items where order_id = '$order_id'");
$row = mysqli_fetch_assoc($sql);


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
					<td colspan="4">
						<table>
							<tr>
								<td class="title">
									<img src="project images/Screenshot 2022-12-18 125033.png" style="width: 90%; max-width: 160px" />
								</td>
								
								<td style="width:40%" >
									Invoice : 0' . $row['id'] . '  <br />
									
									Place_on : ' . $row['placed_on'] . ' <br/>
									Created : '.$Date.'
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="4">
						<table>
							<tr>
								<td style="width:30%">
									' . $row['address'] . '
								</td>

								<td>
									Khodiyar hardware<br />
									jigar.amarkotiya@gmail.com
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td style="width: 10%;text-align:left;">Payment Id</td>
					<td></td>
					<td></td>
					<td style="width: 55%;text-align:right;">' . $row['transaction_id'] . '</td>
				</tr>


				<tr class="heading">
					<td >Item</td>
					<td style="text-align:center;">Price</td>
					<td style="width: 29%;text-align:center;">Quantity</td>
					<td style="text-align:right;">Price</td>
				</tr>';

				while($list = mysqli_fetch_assoc($sql2)){
				$html.= '<tr class="item">
					<td style="width: 55%;">'.$list['product_name']. '</td>
					<td style="width: 10%; text-align:center;">₹'.$list['product_price'].'</td>
					<td style="width: 10%; text-align:center;">'.$list['quantity'].'</td>
					<td style="width: 12%;text-align:right;">₹'.($list['product_price'] * $list['quantity']) .'</td>
				</tr>';
				}



$html.= '<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right;"><b>Total:₹' . $row['total_price'] . '</b> </td>
				</tr>';

$html .= '</table>
		</div>
	</body>
</html>';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);
$mpdf->Output();
?>