<?php
require_once("Class/TS.php");

	if(isset($_POST["cluid"])) {
		$cluid = $_POST["cluid"];
		$connection = TS::getInstance();

			$clientList = TS::getClientList();

			foreach ($clientList as $client) {
				$temp = $connection->clientInfo($client->clid)["data"]["client_unique_identifier"];
				if($cluid == $temp) {
					$connection->clientKick($client->clid, "server");
					break;
				}	
			}
		}
?>