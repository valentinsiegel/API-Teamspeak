<?php
class Ban {
	public $id;
	public $nickname;
	public $ip;
	public $reason;
	public $banner;
	public $bannerUID;
	public $date;
	public $duree;
	public $nbConnexionAfterBan;

	public function __construct($id, $nickname ,$ip ,$reason, $banner, $bannerUID, $date, $duree, $nbConnexionAfterBan) {
		$this->id = $id;
		$this->nickname = $nickname;
		$this->ip = $ip;
		$this->reason = $reason;
		$this->banner = $banner;
		$this->bannerUID = $bannerUID;
		$this->date = $date;
		$this->duree = $duree;
		$this->nbConnexionAfterBan = $nbConnexionAfterBan;
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