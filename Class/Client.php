<?php
class Client {
	public $clid;
	public $cid;
	public $nickname;
	public $clientType;
	public $uniqueIdentifier;

	public function __construct($clid, $cid, $nickname, $clientType, $uniqueIdentifier){
		$this->clid = $clid;
		$this->cid = $cid;
		$this->nickname = $nickname;
		$this->clientType = $clientType;
		$this->uniqueIdentifier = $uniqueIdentifier;
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