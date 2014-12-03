<?php
	session_start();
	if(isset($_GET["succeed"])) {
		if($_GET["succeed"] == "ok") {
			if(isset($_GET["token"]) && isset($_GET["PayerID"])) {
				$payerID = $_GET["PayerID"];
				$curl = curl_init($_SESSION["execute"]);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					'Content-Type:application/json',
					'Authorization: Bearer ' . $_SESSION["access_token"],
				));
				curl_setopt($curl, CURLOPT_POSTFIELDS, 
					'{ 
						"payer_id": "'.$payerID.'"
					}'
				);
				$result = curl_exec($curl);
				if($result === FALSE) {
					echo curl_error($curl);
				}
				else {
					$json = json_decode($result);
					echo "<pre>";
						print_r($json);
					echo "</pre>";
				}
			}
		}
		else {
			echo "<h1>BÂTARD</h1>";
		}
	}
	else {
		if(isset($_GET["montant"])) {
			$clientId = "AWNOPRCzegk9dm6KD0b4st11kIFiYbJ-73Wefs3VXVgtabbEFpcp-qm6mAM9";
			$secret = "EOHhEhB2PQ78rYhdWN8XlzRKCh95RchGZBHhys7HU9pClhniI2MaBYZZPK0D";

			$url = "https://api.sandbox.paypal.com/v1/oauth2/token";
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_USERPWD, $clientId.":".$secret);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

			$result = curl_exec($curl);
			$json = json_decode($result);
			$_SESSION["access_token"] = $json->access_token;

			$url = "https://api.sandbox.paypal.com/v1/payments/payment";
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Content-Type:application/json',
				'Authorization: Bearer ' . $json->access_token,
			));
			curl_setopt($curl, CURLOPT_POSTFIELDS, 
				'{ 
					"intent":"sale",
					"redirect_urls" :
						{
							"return_url":"http://nisuha.fr/test/paypal.php?succeed=ok",
							"cancel_url":"http://nisuha.fr/test/notOK.php?succeed=no"
						},
					"payer":
						{
							"payment_method":"paypal"
						},
					"transactions":[
						{
							"amount":
								{
									"total":"'.$_GET['montant'].'",
									"currency":"EUR"
								}
						}
					]
				}'
			);
			$result = curl_exec($curl);
			if($result === FALSE) {
				echo curl_error($curl);
			}
			else {
				$json = json_decode($result);
				$_SESSION["execute"] = $json->links[2]->href;
				header('Location: ' . $json->links[1]->href);
			}
		}
	}
?>