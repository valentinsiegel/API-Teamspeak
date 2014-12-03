<?php
require("Class/TS.php");

$banlist = TS::getBanlist();
echo "<pre>";
	print_r($banlist);
echo "</pre>";
?>