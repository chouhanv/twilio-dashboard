var curcon;
Twilio.Device.setup(tc);

Twilio.Device.ready(function (device) {
    //$("#log").text("Ready");
    console.log('Ready');
});

Twilio.Device.error(function (error) {
    //$("#log").text("Error: " + error.message);
    console.log("Error: " + error.message);
    window.location.reload();
});

Twilio.Device.connect(function (conn) {
    //$("#log").text("Successfully established call");
    starttimer();
    console.log("Successfully established call");
});

Twilio.Device.disconnect(function (conn) {
    //$("#log").text("Call ended");
    console.log("Call ended");
    // @TODO popup notes modal
    window.location.reload();
});

Twilio.Device.cancel(function(conn) {
	console.log(conn.parameters.From); // who canceled the call
	$('#myModal').modal('hide');
	window.location.reload();
});

Twilio.Device.incoming(function (conn) {
    curcon = conn;
    console.log(conn.parameters);
    // $("#log").text("Incoming connection from " + conn.parameters.From);
    // accept the incoming connection and start two-way audio

    $("#callernumber").html(conn.parameters.From);
    $("#callerphone").html(conn.parameters.From);
    $('#myModal').modal('show');


    var lat = 0;
    var lng = 0;
    var uid = conn.parameters.From;
    uid = uid.replace("client:", "");
    var at = '';

    popData(uid, at, lat, lng,k);

    //conn.accept();
});

function call() {
    //Twilio.Device.connect();
    curcon.accept();    
    $('#myModal').modal('hide');
}

function hangup() {
    Twilio.Device.disconnectAll();
	$('#myModal').modal('hide');
	window.location.reload();
}
