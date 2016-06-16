<?php
require_once('database.php');

$sql = "SELECT id, name FROM backcap.options";
$result = $conn->query($sql);
$buttonDiv ="<div>";
if($result->rowCount() > 0){
	foreach($result as $row){
		$buttonDiv.= '<button style="margin-left:15px" class="btn btn-large btn-';
		
		if($row["id"] == "1") {
			$buttonDiv.= 'danger"';
		} elseif($row["id"] == "2") {
			$buttonDiv.= 'warning"';
		} elseif($row["id"] == "3") {
			$buttonDiv.= 'primary"';
		} elseif($row["id"] == "4") {
			$buttonDiv.= 'info"';
		} elseif($row["id"] == "5") {
			$buttonDiv.= 'success"';
		}
		
		$buttonDiv.=' onclick="controller.sendButtonPress(';
		$buttonDiv.=$row["id"];
		$buttonDiv.=');">';
		$buttonDiv.= $row["name"];
		$buttonDiv.= '</button>';
    }
	
} else {
    echo "0 results";
}
$buttonDiv.="</div>";
echo $buttonDiv;
$conn=null;
?>