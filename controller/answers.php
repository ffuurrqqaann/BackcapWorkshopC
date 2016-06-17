<?php
error_reporting(0);
require_once('../utils/Deviceid.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
	<script type="text/javascript" src="http://spaceify.net/games/g/gamelib.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
	<script type="text/javascript">
		var GROUP_NAME = "Grand Theft Washing Machine";
		var SERVER_ADDRESS = {host: "spaceify.net", port: 1979};
		var WEBRTC_CONFIG = {"iceServers":[{url:"stun:kandela.tv"},{url :"turn:kandela.tv", username:"webrtcuser", credential:"jeejeejee"}]};
		var screenId = null;
		function insertAnswer( questionId, deviceId, buttonId ) {
			jQuery.ajax({
				url: "InsertAnswer.php",
				type: "GET",
				data: {
					question_id : questionId,
					device : deviceId,
					button : buttonId
				},
				success: function( result ) {
					alert(result);
				}
			});
		}
		
		function checkUserVote( questionId, deviceId ) {
			jQuery.ajax({
				url: "CheckUserVote.php",
				type: "GET",
				data: {
					question_id : questionId,
					device : deviceId
				},
				success: function( result ) {
					if( result=="1" ) {
						jQuery('img[id="voteImg1"]').removeAttr("onclick");
						jQuery('img[id="voteImg2"]').removeAttr("onclick");
						jQuery('img[id="voteImg3"]').removeAttr("onclick");
					} else {
						jQuery('img[id="voteImg1"]').attr("onclick", "controller.sendButtonPress(1)");
						jQuery('img[id="voteImg2"]').attr("onclick", "controller.sendButtonPress(2)");
						jQuery('img[id="voteImg3"]').attr("onclick", "controller.sendButtonPress(3)");
					}
				}
			});
		}
		
		function TestController() {
			var self = this;
			var gameClient = null;
			var questionId = null;
			var deviceId = "<?php echo $mobileDeviceId ?>";
			
			self.connect = function()
				{
					gameClient = new GameClient(); 
					gameClient.setScreenConnectionTypeListener(self, self.onScreenConnectionTypeUpdated);
					gameClient.setScreenConnectionListener(self, self.onScreenConnected);
					gameClient.exposeRpcMethod( "onImageChange", self, self.onImageChange);
					//Development connection
					gameClient.connect(SERVER_ADDRESS.host, SERVER_ADDRESS.port, "controller", GROUP_NAME, function(){});
					//Production connection
					//gameClient.connectAsController(function(){});	
				};
			self.onScreenConnectionTypeUpdated = function(newConnectionType, screenId)
				{
					console.log("TestController::onScreenConnectionTypeUpdated() new connection type: " + newConnectionType);
					//document.getElementById("conntype").innerHTML = newConnectionType;
				};
			self.onScreenConnected = function(id)
				{
					console.log("RpcController::onScreenConnected() screenId: " + id);
					screenId = id;
				};
			self.sendButtonPress = function(buttonId)
				{
					var btnId = buttonId;
					insertAnswer( questionId, deviceId, btnId );
					//gameClient.notifyScreens("onButtonPressed",[100,200]);
				};
			self.onImageChange = function(id, url, text, callerId, connectionId, callback)
				{
					questionId = id;
					$("#img_url").attr("src","../pics/"+url);
					$("#text").html(text);
					
					checkUserVote( questionId, deviceId );
					
					//jQuery('button[id="voteBtn"]').prop('disabled', false);
				};
		}
		var controller = null; 
		window.onload = function()
		{
			controller = new TestController();
			controller.connect();
		}
	</script>
	<title>
		BackCap Voting
	</title>
</head>
<body>
	<div class="container">
		<div class="row text-center">
			<div class="col-xs-12">
				<img id="img_url" class="img-rounded" src="../pics/no_image.png" height="70" width="100">
			</div>
			<div class="col-xs-12">
				<span id="text"></span>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-xs-12">
				<?php require('buttons.php'); ?>
			</div>
		</div>
	</div>
</body>
</html>
