<?php
class ServerGroup {
	public $sgid;
	public $name;
	public $type;

	public function __construct($sgid, $name, $type){
		$this->sgid = $sgid;
		$this->name = $name;
		$this->type = $type;
	}

	// Getter
	public function __get($attr) {
		if (isset($this->$attr))
			return $this->$attr;
		else
			throw new Exception("Attribut inconu ".$attr);
	}

}