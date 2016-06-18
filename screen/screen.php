<!DOCTYPE html>
<html>
<head>
	<style>
		#content-container {
			padding: 5px;
			border: 2px solid grey;
			border-radius: 10px;
		}
		#content-image {
		}
		#content-text {
			text-align: center;
			color: white;
			font-size: 270%;
		}
		#results-container{
			padding: 5px;
			border: 2px solid grey;
			border-radius: 10px;
			background-color: rgba(200,0,0,0.2);
		}
		#results {
			color: white;
			text-align: center;
			font-size: 170%;
		}
		#engage-container{
			padding: 10px;
			border: 2px solid grey;
			border-radius: 10px;
			background-color: rgba(200,0,0,0.2);
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
					gameClient.connect(SERVER_ADDRESS.host, SERVER_ADDRESS.port, "screen", GROUP_NAME, function(){});
				};
			self.imageChanged = function(id,url,text)
				{
					console.log("RpcController::imageChanged: "+id+" ("+url+")");
					for (controllerId of controllerIds) {
  						gameClient.callClientRpc(controllerId, "onImageChange",[id,url,text], self, function(err, data)
						{
							//TODO: IMAGE HAS CHANGED - something on screen? NO
						});
					}
				}
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
				$row_number=0;
				try {
					$stmt=$conn->query("SELECT id,text,image_url FROM backcap.questions ORDER BY id ASC"); 
					foreach($stmt as $row){
						$pic= $row['image_url'];
						$textArray[$row_number]=$row['text'];
						$idsArray[$row_number] = $row['id'];
						$urlsArray[$row_number] = $row['image_url'];
						$urlsArray[$row_number] = $row['image_url'];
						$row_number=$row_number+1;
						echo "<img class=\"peopleCarouselImg center-block mySlides img-rounded img-responsive \" src=\"../pics/" . $pic . "\">";
					}
				}
				catch(PDOException $e) {
					echo "Error: " . $e->getMessage();
				}
				$conn = null;
?>
				</div>
				<div id="content-text"></div>
			</div>
			<div class="col-xs-2" id="results-container">
				<div id="results">
					AWARENESS
				</div>
				
			</div>
		</div>
		



		
		
		<div class="row">
			<div class="col-xs-12" id="engage-container">
				<div id="engage">
					<ul id="engage-text">
						<li>WELCOME</li>
						<li>JOIN US!</li>
						<li>VOTE!</li>
						<li>Answer via panoulu_ac http://<?php echo $_SERVER['HTTP_HOST'];?>/controller.php</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script>
	//Homepage text animation
	var animations = {
		rightToLeft: {
			start: {
				top:'55px',
				'font-size': '37px',
				'font-weight': 700,
				color: '#CCC'
			}
		},
		leftToRight: {
			start: {
				top: '50px',
				'font-size': '30px',
				color: '#FDFA27',
				'font-weight': 700
			}
		},
		fadeIn: {
			start: {
				left:null,
				top:'10%',
				right:'25%',
				'font-size': '30px',
				'font-weight': 700
			}
		}
	};
	var textObjects = [
			{
				offset: 0,
				duration: 2000,
				animation: "explode",
			},
			{
				animation: "rightToLeft",
				offset: 100,
				positions: animations.rightToLeft
			},
			{
				animation: "leftToRight",
				offset: 100,
				positions: animations.leftToRight
			},
			{
				offset:500,
				animation: "fadeIn",
				positions: animations.fadeIn,
				duration: 10000
			}
    ];
	var options = {
        //repeat: 5
    };
	
	$(document).ready(function(){
		$("#engage-text").animateText(textObjects, options, animations);
		
/*		$("#engage-text").animateText([
			{
				offset: 0,
				duration: 2000,
				animation: "explode",
			},
			{
				animation: "rightToLeft",
				offset: 0,
				positions: positions.rightToLeft
			},
			{
				animation: "leftToRight",
				offset: 0,
				positions: positions.leftToRight
			},
			{
				offset:500,
				animation: "fadeIn",
				positions: positions.fadeIn,
				duration: 6000
			},*/
/*			{
				offset: 3600,
				duration: 1000,
				animation: "explode",
			},
			{
				animation: "rightToLeft",
				offset: 3600,
				positions: positions.rightToLeft
			},
			{
				animation: "leftToRight",
				offset: 3600,
				positions: positions.leftToRight
			},
			{
				offset:4100,
				animation: "fadeIn",
				positions: positions.fadeIn,
				duration: 2600
			},
			{
				offset: 7200,
				duration: 1000,
				animation: "explode",
			},
			{
				animation: "rightToLeft",
				offset: 7200,
				positions: positions.rightToLeft
			},
			{
				animation: "leftToRight",
				offset: 7200,
				positions: positions.leftToRight
			},
			{
				offset: 7700,
				animation: "fadeIn",
				positions: positions.fadeIn,
				duration: 2600
			},
			{
				offset: 10800,
				animation: "implode",
				positions: {
					1: {
						duration: 4200
					}
				}
			}*/
/*		]);*/
	});
<?php
		$js_text_array = json_encode(array_values($textArray));
		$js_id_array = json_encode(array_values($idsArray));
		$js_url_array = json_encode(array_values($urlsArray));
		echo "var javascript_text_array = ". $js_text_array . ";\n";
		echo "var javascript_id_array = ". $js_id_array . ";\n";
		echo "var javascript_url_array = ". $js_url_array . ";\n";
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
			setTimeout(carousel, 10000); // Change image every 4 seconds
			document.getElementById("content-text").innerHTML =  javascript_text_array[myIndex-1];
			screen.imageChanged(javascript_id_array[myIndex-1],javascript_url_array[myIndex-1],javascript_text_array[myIndex-1]);
		}
	</script>
</body>
</html>