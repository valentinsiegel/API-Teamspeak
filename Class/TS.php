<?php
require_once("ts3admin.php");
require_once("Ban.php");
require_once("Client.php");
require_once("Channel.php");
require_once("ServerGroup.php");

class TS {
	private static $url = "nisuha.fr";
	private static $qport = 10011;
	private static $username = "serveradmin";
	private static $password = "alligator3";
	private static $port = 9987;

	private static $ts = null;

	public function __construct() {
		self::$ts = new ts3admin(TS::$url, TS::$qport);
		self::$ts->connect();
		self::$ts->login(TS::$username, TS::$password);
		self::$ts->selectServer(TS::$port);
	}

	public static function getInstance() {
		if(self::$ts == null) {
			new self;
			return self::$ts;
		}
		else
			return self::$ts;
	}

	public static function getBanlist() {
		$bans = TS::getInstance()->banlist();
		if($bans["errors"] == null) {
			$array = array();
			foreach ($bans["data"] as $ban) {
				$temp = new Ban($ban["banid"], $ban["lastnickname"], $ban["ip"], $ban["reason"], $ban["invokername"], $ban["invokeruid"], $ban["created"], $ban["duration"], $ban["enforcements"]);
				$array[] = $temp;
			}
			return $array;
		}
		return null;
	}

	public static function getChannelList(){
		$channels = TS::getInstance()->channelList();
		if($channels["errors"] == null){
			$decalage = array();
			$decalage[] = 0;
			$array = array();
			foreach ($channels["data"] as $channel) {
				if($channel["pid"] != $decalage[(sizeof($decalage) - 1)]) {
					if($channel["pid"] > $decalage[(sizeof($decalage) - 1)]) {
						$decalage[sizeof($decalage)] = $channel["pid"];
					}
					else {
						unset($decalage[(sizeof($decalage) - 1)]);
					}
				}
				$temp = new Channel($channel["pid"],$channel["cid"], $channel["channel_name"],$channel["total_clients"], sizeof($decalage));
				$array[] = $temp;
			}
			return $array;
		}
		return null;
	}

			//Récupère la liste des clients
	public function getClientList($cid=null){
		$clients = TS::getinstance()->clientList("-uid");
		if ($clients["errors"] == null) {
			$array = array();
			if (is_null($cid)) {
				foreach ($clients["data"] as $client) {
					$temp = new Client($client["clid"], $client["cid"], $client["client_nickname"], $client["client_type"], $client["client_unique_identifier"]);
					$array[] = $temp;			
				}
			} else {
				foreach ($clients["data"] as $client) {
					if ($client["cid"] == $cid) {
						$temp = new Client($client["clid"], $client["cid"], $client["client_nickname"], $client["client_type"], $client["client_unique_identifier"]);
						$array[] = $temp;
					}
				}
			}
			return $array;
		}
		return null;
	}

	public function getServerGroupList(){
		$serverGroups = TS::getInstance()->serverGroupList();
		if ($serverGroups["errors"] == null) {
			$array = array();
			foreach ($serverGroups["data"] as $serverGroup) {
				if ($serverGroup["type"] == 1) {
					$temp = new ServerGroup($serverGroup["sgid"], $serverGroup["name"], $serverGroup["type"]);
					$array[] = $temp;
				}
				
			}
			return $array;
		}
		return null;
	}

	public function getServerGroupClientList($sgid){
		$connect=TS::getInstance();
		$serverGroupClientList = $connect->serverGroupClientList($sgid, true);
		if ($serverGroupClientList["errors"] == null) {
			$array = array();
			foreach ($serverGroupClientList["data"] as $serverGroupClient) {
				$client = $connect->clientGetIds($serverGroupClient["client_unique_identifier"])["data"]["0"]["clid"];
				$clientinfo = $connect->clientInfo($client);
				$temp = new Client( $client,
				  $clientinfo["data"]["cid"],
				  $serverGroupClient["client_nickname"], 
				  $clientinfo["data"]["client_type"],
				  $serverGroupClient["client_unique_identifier"]);
				$array[] = $temp;
			}
			return $array;
		}
		return null;
	}

}
?>