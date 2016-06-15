<?php
error_reporting(0);
require_once('Deviceid.php');
?>
<!DOCTYP1E html>
<html>
	<head>
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
		
		<script type="text/javascript" src="http://spaceify.net/games/g/gamelib.min.js"></script>		
		<script type="text/javascript">	
				
		//Group name for development use
				
		var GROUP_NAME = "Grand Theft Washing Machine";
				
		var SERVER_ADDRESS = {host: "spaceify.net", port: 1979};
		var WEBRTC_CONFIG = {"iceServers":[{url:"stun:kandela.tv"},{url :"turn:kandela.tv", username:"webrtcuser", credential:"jeejeejee"}]};
			
		function TestController()
			{
			var self = this;
			
			var gameClient = null;
			
			self.connect = function()
				{
				gameClient = new GameClient(); 
				gameClient.setScreenConnectionTypeListener(self, self.onScreenConnectionTypeUpdated);
				
				//Development connection
				gameClient.connect(SERVER_ADDRESS.host, SERVER_ADDRESS.port, "controller", GROUP_NAME, function(){});
				
				//Production connection
				//gameClient.connectAsController(function(){});	
				};
			
			self.sendButtonPress = function(buttonId)
				{
					var deviceId = "<?php echo $mobileDeviceId ?>";
					//alert(deviceId);
					console.log("device id is "+ deviceId);
					//alert("button id is "+buttonId);
					console.log("device id is "+deviceId);
					gameClient.notifyScreens("onButtonPressed",[100,200]);
				};
				
			self.onScreenConnectionTypeUpdated = function(newConnectionType, screenId)
				{
				console.log("TestController::onScreenConnectionTypeUpdated() new connection type: " + newConnectionType);
				document.getElementById("conntype").innerHTML = newConnectionType;
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
			TestController for Spaceify Connectivity Library
		</title>
	</head>
<body>
	<h2>
		Controller 
	</h2>
	<h3>
		Please open the browser console to see what is happening!
	</h3>
	<h3>Connectiontype to the screen:</h3><h3 id="conntype">Cloud</h3>
	<button onclick="controller.sendButtonPress();">Send button press to Server</button><!-- send button id and device id from here -->
	<br/>
	<?php require('buttons.php'); ?>
	
</body>
</html>