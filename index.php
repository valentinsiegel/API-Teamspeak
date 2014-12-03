<script src="../js/jquery.js"></script>
<script>
	function slide(cid){
		$("#"+cid).stop().slideToggle();
	}

	function kick(cluid) {
		if(confirm('Êtes-vous sûr(e) de vouloir kicker le client ?')) {
			$.ajax({
				url :'_kick.php',
				type: 'POST',
				data: { cluid: cluid}
			});
		}
	}

	function showUser(cluid){
					$.ajax({
				url :'_kick.php',
				type: 'POST',
				data: { cluid: cluid}
			});

		$("#popup").css("display", "block");
		$("#popup").load("_user.php");
	}
</script>

<div>

<?php

require_once("Class/TS.php");

$channels = TS::getChannelList();
$clientlist = TS::getClientList();

$test="'test2'";
$display="<input type='button' onclick=showUser(".$test.");></div>";
$display.="<div id='popup' style='display:none'></div>";

foreach ($channels as $channel) {
		$nbUsers = $channel->totalClients;
		$users="";
		if ($channel->totalClients > 0) {
			$userlist = TS::getClientList($channel->cid);
			foreach ($userlist as $user) {
				if ($user->clientType==0){
					$users.="<div style='position: relative; margin-left: 10px;'>".$user->nickname;
					$users.= /* "<input type='button' onclick=kick('".$user->uniqueIdentifier."');> */ "</div>";
				}
				else {
					$nbUsers--;
				}
			}
			$list = "<div id='".$channel->cid."' style='display: none;''>";
			$list.=$users;
			$list.="</div>";

		$display.="<div style='margin-left:".(10)*$channel->hierarchie."' onclick=slide(".$channel->cid.");>".$channel->channelName."(".$nbUsers.")";
		if ($nbUsers > 0 ) {
			$display.=$list;
		}		
		$display.="</div>";
		}
		else {
			$display.="<div style='margin-left:".(10)*$channel->hierarchie."' onclick=slide(".$channel->cid.");>".$channel->channelName."(".$nbUsers.")";
			$display.="</div>";
		}
	}

echo $display;

?>

</div>
