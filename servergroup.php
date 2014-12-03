<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function() {
    $( "#accordion" ).accordion({
      active: false,
      autoHeight: false
    });
  });
  </script>

<?php
require_once("Class/TS.php");
$ServerGroups = TS::getServerGroupList();

	$display="<div id='accordion'>";

	foreach ($ServerGroups as $serverGroup) {
		if($serverGroup->type == 1 && $serverGroup->name != "Guest") {
			$display.="<h3>".$serverGroup->name."</h3>";
			$serverGroupClientList = TS::getServerGroupClientList($serverGroup->sgid);
			$display.="<div>";
			foreach ($serverGroupClientList as $ServerGroupClient){
				$display.="<p>".$ServerGroupClient->nickname."</p>";
			}
			$display.="</div>";
		}
	}

$display.="</div>";
echo $display;

?>