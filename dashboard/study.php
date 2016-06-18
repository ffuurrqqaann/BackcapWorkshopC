<html>
<head>
	<title>Crowdsourcing Researcher Dashboard</title>
	<style>
	h1 {
		color: white;
		text-align: center;
		font-size: 270%;
	}
	h2 {
		color: white;
		text-align: center;
		font-size: 230%;
	}
	p {
		color: white;
		text-align: center;
		font-size: 170%;
	}
	form{
		color: white;
		text-align: center;
		font-size: 170%;
	}
	input[type=text] {
		width: 40%;
		padding: 5px 5px;
		margin: 5px 0;
		box-sizing: border-box;
		font-size: 100%;
	}
	input[type=submit] {
		background-color: #4CAF50;
		border: none;
		color: white;
		padding: 15px 15px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 22px;
		margin: 4px 4px;
		cursor: pointer;
	}
	input[type=button] {
		background-color: #4CAF50;
		border: none;
		color: white;
		padding: 4px 4px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 14px;
		margin: 4px 4px;
		cursor: pointer;
	}
	input[type=file] {
		background-color: white;
		border: none;
		color: black;
		padding: 12px 12px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 18px;
		margin: 4px 2px;
		cursor: pointer;
	}
	::-webkit-file-upload-button {
		background: #4CAF50;
		color: white;
		font-size: 18px;
		padding: 8px;
	}
	body {
		background-color: black;
	}
	</style>
</head>
<body>
	<h1>Crowdsourcing Researcher Dashboard</h1>
	<h2>Current Study</h2>
<?php
	require_once('../utils/database.php');
	// Insert Strings.
	if(isset($_POST['submit'])) {
		$Study = $_POST["Study"];
		//echo $Study;
		try {
			$stmt = $conn->prepare("INSERT INTO study (name) values ('". $Study . "')"); 
			$stmt ->execute();
			echo "<h2>New records created successfully</h2>";
		}
		catch(PDOException $e){
			echo "Error: " . $e->getMessage();
		}
	}
	try {
		$rowNumber=0;
		$stmt=$conn->query("SELECT id,name FROM backcap.study ORDER BY id ASC"); 
		foreach($stmt as $row){
			$rowNumber=$rowNumber+1;
			$name= $row['name'];
			echo "<p>".$rowNumber. ". ". $name. 
				"     <input type=\"button\" onclick=\"studyManage(".$row['id']. ");\" value=\"Manage\"/></p>";
		}
	}
	catch(PDOException $e){
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>
	<h2>Add Study</h2>
	<form method="post" action="study.php">
		Study Name:<br>
		<input type="text" name="Study" ><br>
		<input type="submit" value="Submit" name="submit"> 
	</form>
	<script>
		function studyManage(parameter)
		{
			window.location = "manage_study.php?study_id=" + parameter;
		};
</script>
</body>
</html>