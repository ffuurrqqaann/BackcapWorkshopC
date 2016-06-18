<!DOCTYPE html>
<html>
<head>
	<style>
		#content-container {
			padding: 5px;
			border: 1px solid grey;
			border-radius: 10px;
		}
		#content-image {
		}
		#content-text {
			text-align: center;
			color: white;
			font-size: 270%;
		}
		#counter_text{
			text-align: center;
			color: white;
			font-size: 170%;
		}
		#counter{
			text-align: center;
			color: white;
			font-size: 170%;
		}
		#results-container{
			padding: 5px;
			border-radius: 10px;
			background-color: rgba(200,0,0,0.1);
		}
		#results {
			color: white;
			text-align: center;
			font-size: 170%;
		}
		#engage-container{
			padding: 10px;
			border-radius: 10px;
			background-color: rgba(200,0,0,0.1);
		}
		#engage {
			width: 100%;
			height: 100px;

			color: white;
			text-align: center;
			font-size: 170%;
		}
		html body {
			background-color: rgba(0,0,0,1.00);
			height:100%;
		}
		.peopleCarouselImg{
			width: auto;
			height: 480px;
			max-height: 480px;
		}
	</style>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../utils/animateText.js"></script>
	<script type="text/javascript" src="http://spaceify.net/games/g/gamelib.min.js"></script>
	<script type="text/javascript">	
		//Group name for development use
		var GROUP_NAME = "Grand Theft Washing Machine";
		var SERVER_ADDRESS = {host: "spaceify.net", port: 1979};
		var WEBRTC_CONFIG = {"iceServers":[{url:"stun:kandela.tv"},{url :"turn:kandela.tv", username:"webrtcuser", credential:"jeejeejee"}]};
		function BackCapScreen()
		{
			var self = this;
			var gameClient = new GameClient();
			var buttonPressCounter = 0;
			var controllerIds = [];
			self.onControllerConnected = function(id)
				{
					console.log("RpcController::onControllerConnected() controllerId: " + id);
					controllerIds.push(id);
					gameClient.callClientRpc(id, "onImageChange",[javascript_id_array[myIndex-1],javascript_url_array[myIndex-1],javascript_text_array[myIndex-1]], self, function(err, data)
						{
							//TODO: NEW CONTROLLER CONNECTED - something on screen?
						});
				};
			self.connect = function()
				{
					gameClient.setControllerConnectionListener(self, self.onControllerConnected);
					gameClient.exposeRpcMethod("onVoteChange", self, self.onVoteChange);
					gameClient.connect(SERVER_ADDRESS.host, SERVER_ADDRESS.port, "screen", GROUP_NAME, function(){});
				};
			self.imageChanged = function(id,url,text,num)
				{
					console.log("RpcController::imageChanged: "+id+" ("+url+")");
					for (controllerId of controllerIds) {
  						gameClient.callClientRpc(controllerId, "onImageChange",[id,url,text], self, function(err, data)
						{
							//TODO: IMAGE HAS CHANGED - something on screen? NO
						});
					}
				}
			self.onVoteChange = function(questionId, deviceId, btnId, callerId, connectionId, callback)
				{
					//answer got!!!!
					javascript_numAnswers_array[myIndex-1] = javascript_numAnswers_array[myIndex-1] + 1;
					awarenessEffect(javascript_numAnswers_array[myIndex-1]);
					//jQuery('button[id="voteBtn"]').prop('disabled', false);
				};
		}
		var screen = new BackCapScreen();
		window.onload = function()
			{
				screen.connect();
			}
	</script>
	<title>
		BackCap Screen
	</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-10" id="content-container">
				<div class="peopleCarouselImg" id="content-image">
<?php
				require_once('../utils/database.php');
				$textArray = array();
				$idsArray = array();
				$urlsArray = array();
				$numAnswersArray = array();
				$row_number=0;
				try {
					$stmt=$conn->query("SELECT id,text,image_url FROM backcap.questions ORDER BY id ASC"); 
					foreach($stmt as $row){
						$pic= $row['image_url'];
						$textArray[$row_number]=$row['text'];
						$idsArray[$row_number] = $row['id'];
						$urlsArray[$row_number] = $row['image_url'];
						$stmt_count=$conn->query("SELECT count(*) FROM backcap.answers where question_id=".$row['id'])->fetchColumn();
						$numAnswersArray[$row_number] = $stmt_count;
						$row_number=$row_number+1;
						echo "<img class=\"peopleCarouselImg center-block mySlides img-rounded img-responsive \" src=\"../pics/" . $pic . "\">";
					}
				}
				catch(PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
?>
				</div>
				<div id="content-text"></div>
			</div>
			<div class="col-xs-2" id="results-container">
				<div id="results">
					<!--<img src="../pics/oulu.svg" width="70"><br/>-->
					<!--<img src="../pics/algoritmi.png" width="100"><br/>-->
<?php
					//options
					$rowNumber2=0;
					try {
						$stmt=$conn->query("SELECT * FROM backcap.answers"); 
						foreach($stmt as $row){
							$rowNumber2=$rowNumber2+1;
						}
						echo "<h1 id=\"counter_text\">NUMBER OF VOTES</h1>";
						echo "<h1 id=\"counter\"></h1>";
					}
					catch(PDOException $e)
					{
						echo "Error: " . $e->getMessage();
					}
					$conn = null;
?>
					<script type="text/javascript">	
						document.write('<img id="thanksImg" class="mySlides2" src="../pics/thanks.png" width="200">');
						$("#thanksImg").hide();
						
						
						function awarenessEffect(counter) {
							document.getElementById("counter").innerHTML = counter;
							$("#counter").fadeIn(100).fadeOut(100).fadeIn(100);
							$("#thanksImg").fadeIn(300).delay(3000).fadeOut(300);
						}
					</script>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12" id="engage-container">
				<div id="engage">
					<ul id="engage-text">
						<li>HELLO!</li>
						<li>JOIN US!</li>
						<li>VOTE!</li>
						<li>VOTE ON http://<?php echo $_SERVER['HTTP_HOST'];?>/controller/answers.php</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script>
	//Homepage text animation
	var animations = {
		myexplode: {
			start: {
				top:'0px',
				'font-size': '37px',
				'font-weight': 700,
				color: 'grey'
			}
		},
		rightToLeft: {
			start: {
				top:'55px',
				'font-size': '40px',
				'font-weight': 700,
				color: 'Red'
			}
		},
		leftToRight: {
			start: {
				top: '50px',
				'font-size': '35px',
				color: 'Orange',
				'font-weight': 700
			}
		},
		fadeIn: {
			start: {
				left:null,
				top:'20%',
				right:'10%',
				'font-size': '40px',
				'font-weight': 700
			}
		}
	};
	var textObjects = [
			{
				offset: 0,
				duration: 3000,
				animation: "explode",
				positions: animations.myexplode
			},
			{
				offset: 2000,
				duration: 3000,
				animation: "rightToLeft",
				positions: animations.rightToLeft
			},
			{
				offset: 2500,
				duration: 2500,
				animation: "leftToRight",
				positions: animations.leftToRight
			},
			{
				offset:4200,
				duration: 10000,
				animation: "fadeIn",
				positions: animations.fadeIn
			}
    ];
	var options = {
        //repeat: 5
    };
	
	$(document).ready(function(){
							$("#engage-text").animateText(textObjects, options, animations);
						});
<?php
		$js_text_array = json_encode(array_values($textArray));
		$js_id_array = json_encode(array_values($idsArray));
		$js_url_array = json_encode(array_values($urlsArray));
		$js_numAnswers_array = json_encode(array_values($numAnswersArray),JSON_NUMERIC_CHECK);
		
		
		echo "var javascript_text_array = ". $js_text_array . ";\n";
		echo "var javascript_id_array = ". $js_id_array . ";\n";
		echo "var javascript_url_array = ". $js_url_array . ";\n";
		echo "var javascript_numAnswers_array = ". $js_numAnswers_array . ";\n";
?>
		var myIndex = 0;
		carousel();
		function carousel() {
			var i;
			var x = document.getElementsByClassName("mySlides");
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";
			}
			myIndex++;
			if (myIndex > x.length) {
				myIndex = 1;
			}
			x[myIndex-1].style.display = "block";
			setTimeout(carousel, 12000); // Change image every 4 seconds
			$("#thanksImg").hide();
			document.getElementById("content-text").innerHTML =  javascript_text_array[myIndex-1];
			document.getElementById("counter").innerHTML =  javascript_numAnswers_array[myIndex-1];
			screen.imageChanged(javascript_id_array[myIndex-1],javascript_url_array[myIndex-1],javascript_text_array[myIndex-1], javascript_numAnswers_array[myIndex-1]);
		}
	</script>
</body>
</html>