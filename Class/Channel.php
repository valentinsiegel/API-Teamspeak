<?php
require_once("ts3admin.php");

/**
* 
*/
class Channel {
	public $pid;
	public $cid;
	public $channelName;
	public $totalClients;
	public $hierarchie;
	
	public function __construct($pid, $cid, $channelName, $totalClients, $hierarchie){
		$this->pid = $pid;
		$this->cid = $cid;
		$this->channelName = $channelName;
		$this->totalClients = $totalClients;
		$this->hierarchie = $hierarchie;
	}

	// Getter
	public function __get($attr) {
		if (isset($this->$attr))
			return $this->$attr;
		else
			throw new Exception("Attribut inconu ".$attr);
	}
}
?>