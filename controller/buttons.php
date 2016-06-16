<?php
require_once('../utils/database.php');
$sql = "SELECT id, name FROM backcap.options";
$result = $conn->query($sql);
$buttonDiv ="<div>";
if($result->rowCount() > 0){
	foreach($result as $row){
		$buttonDiv.= '<button id="voteBtn" style="margin-left:15px" disabled class="btn btn-large">';
		
		if($row["id"] == "1") {
			$buttonDiv.= '<img src="../pics/bad.png" onclick="controller.sendButtonPress(1)"/>';
		} elseif($row["id"] == "2") {
			$buttonDiv.= '<img src="../pics/neutral.png" onclick="controller.sendButtonPress(2)"/>';
		} elseif($row["id"] == "3") {
			$buttonDiv.= '<img src="../pics/good.png" onclick="controller.sendButtonPress(3)"/>';
		}
		
		$buttonDiv.= '</button>';
	}
} else {
	echo "0 results";
}
$buttonDiv.="</div>";
echo $buttonDiv;
$conn=null;
?>