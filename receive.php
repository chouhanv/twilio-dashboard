<?php
@session_start();
include 'Services/Twilio/Capability.php';

// put your Twilio API credentials here
$accountSid = 'AC50bcbef90dd37cf6f5cb5f8ef13964c9';
$authToken  = '49d0225d70d46d9e57324e98c48d3b22';

// put your Twilio Application Sid here
$appSid     = 'APa3f3e49d38f8f607c580e1d82ac82b96';

$clientName = $_SESSION["userid"];
$username = $_SESSION["username"];

$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$capability->allowClientIncoming('virendra');
$token = $capability->generateToken();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Hello Client Monkey 3 <?php echo $username; ?></title>
    <script type="text/javascript"
      src="//static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>
    <script type="text/javascript"
      src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <link href="http://static0.twilio.com/packages/quickstart/client.css"
      type="text/css" rel="stylesheet" />
    <script type="text/javascript">

      Twilio.Device.setup("<?php echo $token; ?>");

      Twilio.Device.ready(function (device) {
        $("#log").text("Ready");
      });

      Twilio.Device.error(function (error) {
        $("#log").text("Error: " + error.message);
      });

      Twilio.Device.connect(function (conn) {
        $("#log").text("Successfully established call");
      });

      Twilio.Device.disconnect(function (conn) {
        $("#log").text("Call ended");
      });

      Twilio.Device.incoming(function (conn) {
        $("#log").text("Incoming connection from " + conn.parameters.From);
        // accept the incoming connection and start two-way audio
        conn.accept();
      });

      function call() {
        Twilio.Device.connect();
      }

      function hangup() {
        Twilio.Device.disconnectAll();
      }
    </script>
  </head>
  <body>
    <button class="call" onclick="call();">
      Call
    </button>

    <button class="hangup" onclick="hangup();">
      Hangup
    </button>

    <div id="log">Loading pigeons...</div>
  </body>
</html>
