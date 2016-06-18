<?php
require_once('../utils/database.php');
$sql = "SELECT id, name FROM backcap.options";
$result = $conn->query($sql);
$buttonDiv ="<div>";
if($result->rowCount() > 0){
	foreach($result as $row){
		if($row["id"] == "1") {
			$buttonDiv.= '<div class="col-xs-5"><span class="pull-right"><img id="voteImg1" src="../pics/bad.png"  onclick="controller.sendButtonPress(1)"/><p id="voteCounter1">C1</p></span></div>';
		} elseif($row["id"] == "2") {
			$buttonDiv.= '<div class="col-xs-2"><span><img id="voteImg2" src="../pics/neutral.png"  onclick="controller.sendButtonPress(2)"/><p id="voteCounter2"></p></span></div>';
		} elseif($row["id"] == "3") {
			$buttonDiv.= '<div class="col-xs-5"><span class="pull-left"><img id="voteImg3" src="../pics/good.png"  onclick="controller.sendButtonPress(3)"/><p id="voteCounter3">C1</p></span></div>';
		}
	}
} else {
	echo "0 results";
}
$buttonDiv.="</div>";
echo $buttonDiv;
$conn=null;
?>