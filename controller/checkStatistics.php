<?php
require_once ("../utils/database.php");
$question 	= $_GET['question_id'];

try {

	$sql= "SELECT count(id) AS bad,
(SELECT COUNT(id) AS nVote FROM answers WHERE question_id=$question AND option_id=2) AS neutral,
(SELECT COUNT(id) AS totalVote FROM answers WHERE question_id=$question AND option_id=3) AS good,
(SELECT COUNT(id) AS totalVote FROM answers WHERE question_id=$question) AS totalVote
FROM answers WHERE question_id=$question AND option_id=1";

	$statement = $conn->prepare($sql);
	$statement->execute();
	$row = $statement->fetch();
	
	echo $row["bad"].",".$row["neutral"].",".$row["good"].",".$row["totalVote"];
	
} catch(PDOException $e) {
 	echo "Error: " . $e->getMessage();
}
?>
