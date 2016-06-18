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
    padding: 14px 14px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 24px;
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
.button2 {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 14px 14px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 24px;
    margin: 4px 4px;
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
	<h2>Study:
<?php
	require_once('../utils/database.php');
	if(isset($_POST['submit'])) {
		$pictureName = "pictureNAME";
		try {
			$stmt = $conn->prepare("INSERT INTO questions (text,image_url) values ('". $Study . "','". $pictureName. "')"); 
			$stmt ->execute();
			echo "<h2>New records created successfully</h2>";
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
	}
	if(isset($_POST['submitImage'])) {
		$study_id=$_GET["study_id"];
		$target_dir = "../pics/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$pictureName=$_FILES["fileToUpload"]["name"];
		$Question = $_POST["Question"];
		echo $Question;
		try {
			$stmt = $conn->prepare("INSERT INTO questions (study_id,text,image_url) 
								values (".$study_id.",'". $Question . "','". $pictureName. "')"); 
			$stmt ->execute();
			echo "<h2>New records created successfully</h2>";
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
		// Check if image file is a actual image or fake image
		//if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		//}
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	try {
		$rowNumber=0;
		$study_id=$_GET["study_id"];
		$stmt=$conn->query("SELECT name FROM backcap.study Where id = " .$study_id); 
		foreach($stmt as $row){
			$rowNumber=$rowNumber+1;
			$name= $row['name'];
			echo $name;
		}
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
?>
	</h2>
	<h2>Question:
<?php
	try {
		$rowNumber=0;
		$question_id=$_GET["question_id"];
		$stmt=$conn->query("SELECT text FROM backcap.questions Where id = " .$question_id); 
		foreach($stmt as $row){
			$rowNumber=$rowNumber+1;
			$name= $row['text'];
			echo $question_id. ". ".$name;
		}
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>
	</h2>
	<h2>Edit Question</h2>     
<?php
	$study_id=$_GET["study_id"];
	$question_id=$_GET["question_id"];
	echo "<form method=\"post\"  action=\"manage_question.php?study_id=".$study_id."&question_id=".$question_id."\" enctype=\"multipart/form-data\">";
?>
		New Question Text:<br> 
		<input type="text" name="Question" ><br>
		New Question Image:<br>   
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Submit" name="submitImage">
	</form>
<?php
	$study_id=$_GET["study_id"];
	echo "<p><input type=\"button\" onclick=\"studyManage(".$study_id. ");\" value=\"Back To Study\"/></p>";
?>
</body>
<script>
	function studyManage(parameter)
	{
		window.location = "manage_study.php?study_id=" + parameter;
	};
</script>
</html>