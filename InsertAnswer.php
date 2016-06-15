<?php
require_once ("database.php");

$question 	= $_GET['question_id'];
$device 	= $_GET['device'];
$button 	= $_GET['button'];

$sql = "INSERT INTO answers (question_id, option_id, device_id) VALUES ('".$question."', '".$button."', '".$device."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>