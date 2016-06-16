<?php
require_once ("database.php");

$question 	= $_GET['question_id'];
$device 	= $_GET['device'];
$button 	= $_GET['button'];

try {
	
	$sql = "INSERT INTO answers (question_id, option_id, device_id) VALUES ('".$question."', '".$button."', '".$device."')";
	$conn->query($sql);
    echo "New record created successfully";
	$conn = null;
	
} catch(PDOException $e) {
 	echo "Error: " . $e->getMessage();
}
?>