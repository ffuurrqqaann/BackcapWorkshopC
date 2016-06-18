<?php
require_once ("../utils/database.php");
$question 	= $_GET['question_id'];
$device 	= $_GET['device'];

try {
	$sql = "SELECT id, question_id, option_id, device_id FROM answers WHERE question_id=".$question." AND device_id='".$device."'";
	
	$statement = $conn->prepare($sql);
	$statement->execute();
	$row = $statement->fetchAll();
	
	if( count($row)>0 ) {
		echo '1';
	} else {
		echo '0';
	}
	
} catch(PDOException $e) {
 	echo "Error: " . $e->getMessage();
}
?>
