<?php
	
	require 'vendor/autoload.php';
	require 'barcode/vendor/autoload.php';
	
	// reference the Dompdf namespace
	use Dompdf\Dompdf;
	use Dompdf\Options;
	// instantiate and use the dompdf class
	$options = new Options();
	$options->set('defaultFont', 'Courier');
	$options->set('isRemoteEnabled', true);
	$options->setIsHtml5ParserEnabled(true);
	$dompdf = new Dompdf($options);
	$custome_image=wc_get_order_item_meta( $orderLineItemId, 'photo_url', true);
	$Date=wc_get_order_item_meta( $orderLineItemId, 'Dagsetning', true);
	$recipientName=wc_get_order_item_meta( $orderLineItemId, 'recipient_name', true)[0];
	$Message=wc_get_order_item_meta( $orderLineItemId, 'Message', true);
	$Message=nl2br($Message);
	$pass_link=wc_get_order_item_meta( $orderLineItemId, 'pass_link', true);
	$giftcard_no=wc_get_order_item_meta( $orderLineItemId, 'giftcard_no', true);
	$pass__identity=wc_get_order_item_meta( $orderLineItemId, 'pass__identity', true);
	$item = new WC_Order_Item_Product($orderLineItemId);
	$total= $item->get_total();

	$qr_url=plugin_dir_url( __FILE__ ).'qr.php?link='.$pass_link;

	if($pass__identity!=null && !empty($pass__identity)){
		$qr_url='https://veski.leikbreytir.is/en/passinstance/showpasslinkqrcode?passInstance[__identity]='.$pass__identity;
	}

	$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	$html='<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
			<style>
				html { margin: 0px}
				@page { margin: 0px; }
				body { margin: 0px; }
			</style>
		</head>
		<body>
			<table cellpadding="0" cellspacing="0" align="center" width="100%">
				<tr>
					<td style="width:100%;background-color:#ffffff; padding:50px 50px 50px 50px;" valign="top">
						<table cellspacing="0" cellpadding="0" width="100%" align="center" style="margin-bottom:30px">
							<tr>
								<td align="center"><img style="" src="'.plugin_dir_url( __FILE__ ).'assets/images/BykoBlue.svg"></td>
							</tr>
						</table>

						<table cellpadding="0" cellspacing="0" align="center" width="100%">
							<tr>
								<td style="text-align:center;">
									<img style="width:720px;" src="'.$custome_image[0].'" alt="" />
								</td>
							</tr>
						</table>


						<table cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:10px;">
							<tr>
								<td width="100%" style="background-color:#ffffff; padding:50px;border: 2px solid #014189;" valign="top">
									<div style="width:100%;">
										<table cellpadding="0" cellspacing="0" width="100%" style="margin-top: -44px">
											<tr>
												<td style="width:60%;" valign="top">
													<p style="font-size: 16px;">Dagsetning: '.$Date.'</p>
													<table style="width:100%;">
														<tr>
															<td>
																<div style="min-height:200px;">
																	<p style="font-size: 16px;margin-top:-10px;">'.stripslashes($Message).'</p>
																</div>
																<div style="text-align:center;">
																	<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($giftcard_no, $generator::TYPE_CODE_128)) . '">
																	<p style="font-size: 16px;margin-top:0px;">Gjafakorts númer: '.$giftcard_no.'</p>
																</div>
															</td>
														</tr> 
													</table>
												</td>
												<td style="width:40%;vertical-align:top;">
													<p style="text-align: right; font-size:25px; font-weight: 700; color: #2C2E35;">'.wc_price($total).'</p>
												</td>
											</tr>
										</table>
										<img style="width:130px;float:right;margin-top:-100px;margin-right:-20px;" src="'.$qr_url.'" alt="qr-code" />
										
									</div>
								</td>
							</tr>               
						</table>

						<table width="100%" align="center" style="border-top:2px solid #43454B;margin-top:10px;">
							<tr>
								<td><p>Til hamingju með gjafakort Byko. Skannaðu QR kóðann og fáðu gjafakortið beint í rafrænt veski í símanum þínum.  Eins og er er því miður ekki hægt að greiða með gjafakorti í vefverslun Byko.</p></td>		
							</tr>
						</table>
								
					</td>
				</tr>
			</table>
		</body>
	</html>';

	$dompdf->loadHtml($html);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('legal', 'portrait');

	// Render the HTML as PDF
	$dompdf->render();

	if(!isset($output)){
		// Output the generated PDF to Browser
		$dompdf->stream('gjafakort.pdf');

		exit();
	}else{
		$attachment=$dompdf->output();
		$pdf_file_name=$orderLineItemId.'-gjafakort.pdf';
		file_put_contents($pdf_file_name, $attachment);
		
	}