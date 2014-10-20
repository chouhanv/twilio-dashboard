var map;
var seconds = 0;
var gMarkers = [];
var categories = [];
var slugs = [];
var types = ["accounting","airport","amusement_park","aquarium","art_gallery","atm","bakery","bank","bar","beauty_salon","bicycle_store","book_store","bowling_alley","bus_station","cafe","campground","car_dealer","car_rental","car_repair","car_wash","casino","cemetery","church","city_hall","clothing_store","convenience_store","courthouse","dentist","department_store","doctor","electrician","electronics_store","embassy","establishment","finance","fire_station","florist","food","funeral_home","furniture_store","gas_station","general_contractor","grocery_or_supermarket","gym","hair_care","hardware_store","health","hindu_temple","home_goods_store","hospital","insurance_agency","jewelry_store","laundry","lawyer","library","liquor_store","local_government_office","locksmith","lodging","meal_delivery","meal_takeaway","mosque","movie_rental","movie_theater","moving_company","museum","night_club","painter","park","parking","pet_store","pharmacy","physiotherapist","place_of_worship","plumber","police","post_office","real_estate_agency","restaurant","roofing_contractor","rv_park","school","shoe_store","shopping_mall","spa","stadium","storage","store","subway_station","synagogue","taxi_stand","train_station","travel_agency","university","veterinary_care","zoo"];
var currentinfo = null;
var showForecast = false;
function includeRequiredJs(jsname,pos) {
	var th = document.getElementsByTagName(pos)[0];
	var s = document.createElement('script');
	s.setAttribute('type','text/javascript');
	s.setAttribute('src',jsname);
	th.appendChild(s);
} 
//includeRequiredJs('//static.twilio.com/libs/twiliojs/1.2/twilio.min.js','body');
//includeRequiredJs('https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js','body'); 
       
function popData(uid, at, lat, lng, key) {
	uid = uid.replace("client:", "");                        
	uid = '543254ab741b8c463638ba41';
	//at = 'eR99pBZ0jDZUnhL4daWshsobqpAhDju7XAcUhnCWHEwhbaCsLG5ScfmI93WU8xAJ';
	//lat = 40.753726959228516;
	//lng  = -73.97865295410156;
	
	// Get callers personal/professional/family information based on userid send by the srivi app
	$.ajax({
		url: "http://104.131.124.227:3000/api/calls/"+uid,
		type: 'GET',
		data: {},
		success: function (data) {
			//console.log('data',data);
			if(data.id == uid)
			{
				at = data.appUserId;
				$.ajax({
					url: "http://104.131.124.227:3000/api/appUsers/" + uid + "?access_token=" + at,
					type: 'GET',
					data: {},
					success: function (result) {
						if (result.id)
						{
							lat = result.last_location.lat;
							lng = result.last_location.lng;
							initialize(lat,lng);
							var familyHTML = '';
							if (result.realm != "")
							{
								$("#callerimage").attr("src", result.realm);
								$("#callerbgimg").attr("src",result.realm);
							}
							$("#inputEmail").val(result.email);
							$("#inputCity").val(result.details.city);
							$("#inputState").val(result.details.state);
							$("#inputZip").val(result.details.zip);
							$("#inputOccupation").val(result.details.occupation);
							$("#callername").html(result.details.first_name + " " + result.details.last_name);
							$("#callerlevel").html('Free');
							if (result.details.family)
							{
								familyHTML += "<b>Marital Status</b> : " + result.details.family[0].marital_status + "<br /><br />";
								if (result.details.family[0].children == "yes")
								{
									familyHTML += "<b>Children</b> : " + result.details.family[0].children + "<br /><br />";
									if (result.details.family[0].child)
									{
										for (var x = 0; x < result.details.family[0].child.length; x++)
										{
											if (result.details.family[0].child[x].child_first_name)
											{
												familyHTML += "<b>Child First Name</b> : " + result.details.family[0].child[x].child_first_name + "<br /><br />";
											}
											if (result.details.family[0].child[x].child_last_name)
											{
												familyHTML += "<b>Child Last Name</b> : " + result.details.family[0].child[x].child_last_name + "<br /><br />";
											}
											if (result.details.family[0].child[x].child_birthday)
											{
												familyHTML += "<b>Child Birthday</b> : " + result.details.family[0].child[x].child_birthday + "<br /><br />";
											}
										}
									}
									else if (result.details.family[0].child_first_name)
									{
										familyHTML += "<b>Child First Name</b> : " + result.details.family[0].child_first_name + "<br /><br />";
									}
									if (result.details.family[0].child_last_name)
									{
										familyHTML += "<b>Child Last Name</b> : " + result.details.family[0].child_last_name + "<br /><br />";
									}
									if (result.details.family[0].child_birthday)
									{
										familyHTML += "<b>Child Birthday</b> : " + result.details.family[0].child_birthday + "<br /><br />";
									}
								}
							}
							$(".family").html(familyHTML);
							
							// Get current location and weather information of the users based on the users latest latitude and longitude
							var geocoder;
							geocoder = new google.maps.Geocoder();
							var latlng = new google.maps.LatLng(lat, lng);
							geocoder.geocode({'latLng': latlng}, function (results, status)
							{
								if (status == google.maps.GeocoderStatus.OK)
								{
									if (results[0])
									{
										var add = results[0].formatted_address;
										var value = add.split(",");
										count = value.length;
										country = value[count - 1];
										state = value[count - 2];
										city = value[count - 3];
										$(".city").html(city);
										$(".state").html(state);
										$.ajax({
											url: "https://query.yahooapis.com/v1/public/yql?q=select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='"+$(".city").html()+","+ $(".state").html()+"')&format=json",
											type: 'GET',
											data: {},
											success: function (resp) {
												if(resp.query.results)
												{																	
													var dt = resp.query.results.channel.item.condition.date;
													var day = dt.split(',')[0];
													var tempF = resp.query.results.channel.item.condition.temp;
													$("#temp").html(tempF);
													$(".day").html(getFullDay(day));
													var forecast = resp.query.results.channel.item.forecast;
													if(forecast.length > 0)
													{
														showForecast = true;
														$("#tblforecast").append("<tbody>");
														for(var i =0; i < forecast.length; i++)
														{
															$("#tblforecast").append("<tr><td>"+forecast[i].day+", "+forecast[i].date+"</td><td>"+forecast[i].high+"</td><td>"+forecast[i].low+"</td><td>"+forecast[i].text+"</td></tr>");
														}	
														$("#tblforecast").append("</tbody>");
													}												
												}
											}
										});
									}
								}
							});
							
							// Get deals from sqoot near by users location
							$.ajax({
								url: "http://api.sqoot.com/v2/deals?api_key="+key+"&order=distance&per_page=200&location=" + lat + "," + lng,
								type: 'GET',
								data: {},
								success: function (res) {
									var deals = res.deals;
									var evenHtml = '';
									var oddHtml = '';
									for (var i = 0; i < deals.length; i++)
									{
										var category = '';
										var title = '';
										var description = '';
										var address = '';
										var city = '';
										var state = '';
										var zip = '';
										var phone = '';
										var completeAddress = '';
										
										if (deals[i].deal.category_name)
										{
											category = deals[i].deal.category_name;
										}
										if (deals[i].deal.description)
										{
											description = deals[i].deal.description;
										}
										if (deals[i].deal.title)
										{
											title = deals[i].deal.title;
										}
										if (deals[i].deal.merchant.address)
										{
											address = deals[i].deal.merchant.address;
											completeAddress += address + ", ";
										}
										if (deals[i].deal.merchant.locality)
										{
											city = deals[i].deal.merchant.locality;
											completeAddress += city + ", ";
										}
										if (deals[i].deal.merchant.region)
										{
											state = deals[i].deal.merchant.region;
											completeAddress += state + " ";
										}
										if (deals[i].deal.merchant.postal_code)
										{
											zip = deals[i].deal.merchant.postal_code;
											completeAddress += zip + ", ";
										}
										if (deals[i].deal.merchant.phone_number)
										{
											phone = deals[i].deal.merchant.phone_number;
											completeAddress += phone;
										}
										if (i == 0 || i == 2)
										{
											evenHtml += '<div class="rating_box1">';
											evenHtml += '<div class="number number1">' + (i + 1) + '</div>';
											evenHtml += '<div class="sushi pull-left">';
											evenHtml += '<h1>' + title + '</h1>'
											evenHtml += '<p class="rate"><span class="color_orange">4.3 <img src="images/ratingstar2.png" alt=""></span> 39 Reviews - $$ ' + (category != '' ? '- ' + category : category) + '</p>';
											evenHtml += '<p>' + description + '</p>';
											evenHtml += '<span>' + completeAddress + '</span>';
											evenHtml += '</div>';
											evenHtml += '<div class="sushi_img pull-right">';
											evenHtml += '<img src="' + deals[i].deal.image_url + '" />';
											evenHtml += '</div>';
											evenHtml += '<div class="clear"></div>';
											evenHtml += '</div>';
										}
										else if (i == 1 || i == 3)
										{
											oddHtml += '<div class="rating_box1">';
											oddHtml += '<div class="number number1">' + (i + 1) + '</div>';
											oddHtml += '<div class="sushi pull-left">';
											oddHtml += '<h1>' + title + '</h1>';
											oddHtml += '<p class="rate"><span class="color_orange">4.3 <img src="images/ratingstar2.png" alt=""></span> 39 Reviews - $$ ' + (category != '' ? '- ' + category : category) + '</p>';
											oddHtml += '<p>' + description + '</p>';
											oddHtml += '<span>' + completeAddress + '</span>';
											;
											oddHtml += '</div>';
											oddHtml += '<div class="sushi_img pull-right">';
											oddHtml += '<img src="' + deals[i].deal.image_url + '" />';
											oddHtml += '</div>';
											oddHtml += '<div class="clear"></div>';
											oddHtml += '</div>';
										}
										
										var ltLn = new google.maps.LatLng(deals[i].deal.merchant.latitude, deals[i].deal.merchant.longitude);
										var image = {
											url: 'images/marker_green.png',
											size: new google.maps.Size(71, 71),
											origin: new google.maps.Point(0, 0),
											anchor: new google.maps.Point(17, 34),
											scaledSize: new google.maps.Size(25, 25)
										};

										// Create a marker for each place.
										var marker = new google.maps.Marker({
											map: map,
											icon: image,
											title: deals[i].deal.title,
											position: ltLn,
										});
										marker.category = deals[i].deal.category_slug;
										gMarkers.push(marker);
										var infowindow = new google.maps.InfoWindow();
										var content = '<h5>' + deals[i].deal.title + '</h5><p>' + completeAddress;
										content += '<br>' + deals[i].deal.category_name;
										content += '<br><a id="aUrl" title="copy link"><i class="fa fa-copy ic-copy"></i></a><input id="hfUrl" type="hidden" value="'+deals[i].deal.url+'"/></p>';
										//infowindow.setContent(contentStr);
										google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
											return function() {
												if(currentinfo) { currentinfo.close();} 
												infowindow.setContent(content);
												google.maps.event.addListener(infowindow, 'domready', function() {
												    $('a#aUrl').zclip({
														path:'js/ZeroClipboard.swf',
														copy:$('#hfUrl').val(),
														afterCopy:function(){
															$('#txtMessage').val($('#hfUrl').val());
														}
													});
												});
												infowindow.open(map,marker);
												currentinfo = infowindow; 
												e.preventDefault();
											};
										})(marker,content,infowindow));
									}
									$(".dealodd").html(evenHtml);
									$(".dealeven").html(oddHtml);
								}
							});
						}
					}									
				});				
			}
		}
	});
}
// Get categories from Sqoot and populate the category list
function populateCategories(key)
{
	$.ajax({
		url: "http://api.sqoot.com/v2/categories?api_key="+key,
		type: 'GET',
		data: {},
		success: function (res) {
			categories = res.categories;
			for (var i = 1; i <= categories.length; i++)
			{
				slugs.push(categories[i-1].category.slug);
				if(i%2 == 0)
				{
					$(".category-right").append('<div class="checkbox check-primary"><input id="category'+(i-1)+'" type="checkbox" value="'+categories[i-1].category.slug+'" onclick="applyCategoryfilter(this);"><label for="category'+(i-1)+'">'+categories[i-1].category.name+'</label></div>');
				}
				else
				{
					$(".category-left").append('<div class="checkbox check-primary"><input id="category'+(i-1)+'" type="checkbox" value="'+categories[i-1].category.slug+'" onclick="applyCategoryfilter(this);"><label for="category'+(i-1)+'" >'+categories[i-1].category.name+'</label></div>');
				}
			}
			/*
			console.log("slugs",slugs);
			console.log("types",types);
			var common = $.grep(slugs, function(element) {
			    return $.inArray(element, types ) !== -1;
			});
			console.log("common",common);
			*/
		}
	});
}
// Filter deals as per the selected categories			
function applyCategoryfilter(obj)
{
	var cslugs = $("#txtSlugs").val();
	var slug = $(obj).val();
	if($(obj).is(":checked"))
	{
		cslugs+=slug+",";						
	}
	else
	{
		cslugs = cslugs.replace(slug+',','');
	}
	$("#txtSlugs").val(cslugs);					
	if(cslugs != "")
	{
		for (var i=0; i< gMarkers.length; i++) 
		{
			if(gMarkers[i].category != null)
			{
				var cvalue = gMarkers[i].category.toString();			
				if (cvalue.indexOf(',') == -1 && cslugs.indexOf(cvalue) != -1) {
					gMarkers[i].setVisible(true);
				}
				else if (cvalue.indexOf(',') > 0) 
				{ 
					var flag = false;
					var c = cvalue.split(',');
					if(c.length > 0)
					{
						for(var j = 0; j < c.length; j++)
						{
							if(cslugs.indexOf(c[j]) != -1)
							{
								flag = true;
							}
						}
					}				
					if(flag)
					{
						gMarkers[i].setVisible(true);
					}
					else{
						gMarkers[i].setVisible(false);
					}
				}
				else{
					gMarkers[i].setVisible(false);
				}
			}
			else{
				gMarkers[i].setVisible(false);
			}
		}
	}
	else{
		for (var i=0; i< gMarkers.length; i++) {
			gMarkers[i].setVisible(true);
		}
	}
}

function getFullDay(val)
{
	var day = '';
	if(val == "Mon")
	{
		day = "Monday";
	}
	else if(val == "Tue")
	{
		day = "Tuesday";
	}
	else if(val == "Wed")
	{
		day = "Wednesday";
	}
	else if(val == "Thu")
	{
		day = "Thursday";
	}
	else if(val == "Fri")
	{
		day = "Friday";
	}
	else if(val == "Sat")
	{
		day = "Saturday";
	}
	else if(val == "Sun")
	{
		day = "Sunday";
	}
	return day;
}

function filterCategories(term)
{
    term = term.toLowerCase();
	$(".checkboxwrap-2 input[type=checkbox]").each(function(){
		if($(this).next('label').text().toLowerCase().indexOf(term) != -1)
		{
			$(this).parent('.check-primary').show();
		}
		else
		{
			$(this).parent('.check-primary').hide();
		}
	});
	e.preventDefault();
}
// This example adds a search box to a map, using the Google Place Autocomplete
// feature. People can enter geographical searches. The search box will return a
// pick list containing a mix of places and predicted search terms.

function initialize(userLat,userLng) {
	var latLng = new google.maps.LatLng(userLat, userLng);
	var markers = [];
	map = new google.maps.Map(document.getElementById('map-canvas'), {
		center: latLng,
		zoom: 11,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		panControl: true,
		panControlOptions: {
			position: google.maps.ControlPosition.RIGHT_CENTER
		},
		zoomControl: true,
	    zoomControlOptions: {
	        style: google.maps.ZoomControlStyle.LARGE,
	        position: google.maps.ControlPosition.RIGHT_CENTER
	    },
	});

	var defaultBounds = new google.maps.LatLngBounds(
		new google.maps.LatLng(userLat, userLng),
		new google.maps.LatLng(userLat, userLng));
	//map.fitBounds(defaultBounds);
	// Create a marker for each place.
	var mark = new google.maps.Marker({
	   position: latLng,
	   map: map
	 });
	// Create the search box and link it to the UI element.
	var input = /** @type {HTMLInputElement} */(
			document.getElementById('pac-input'));
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
	var infowindow = new google.maps.InfoWindow();

	var searchBox = new google.maps.places.SearchBox(
			/** @type {HTMLInputElement} */(input));

	// [START region_getplaces]
	// Listen for the event fired when the user selects an item from the
	// pick list. Retrieve the matching places for that item.
	google.maps.event.addListener(searchBox, 'places_changed', function () {
		var places = searchBox.getPlaces();
		
		if (places.length == 0) {
			return;
		}
		for (var i = 0, marker; marker = markers[i]; i++) {
			marker.setMap(null);
		}

		// For each place, get the icon, place name, and location.
		markers = [];
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0, place; place = places[i]; i++) {
			var image = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
			};

			// Create a marker for each place.
			var marker = new google.maps.Marker({
				map: map,
				icon: image,
				title: place.name,
				position: place.geometry.location,
			});
			marker.category =  place.types;
			gMarkers.push(marker);
			var request = {
				reference: place.reference
			};
			var content = '<h5>' + place.name + '</h5><p>' + place.formatted_address;
			if (!!place.formatted_phone_number)
				content += '<br>' + place.formatted_phone_number;
			if (!!place.website)
				content += '<br><a target="_blank" href="' + place.website + '">' + place.website + '</a>';
			content += '<br>' + place.types + '</p>';
			//content += '<br>' + place + '</p>';
			google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
				return function() {
					if(currentinfo) { currentinfo.close();} 
					infowindow.setContent(content);
					infowindow.open(map,marker);
					currentinfo = infowindow;
				};
			})(marker,content,infowindow)); 
			markers.push(marker);
			bounds.extend(place.geometry.location);
		}
		map.fitBounds(bounds);
	});
	// [END region_getplaces]
	// Bias the SearchBox results towards places that are within the bounds of the
	// current map's viewport.
	google.maps.event.addListener(map, 'bounds_changed', function () {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
	});
}
//google.maps.event.addDomListener(window, 'load', initialize);            
function starttimer() {
	$(".btn-hangup").show();
	setInterval(function(){
	    ++seconds;
	    $('#timer').html(pad(parseInt(seconds / 60)) + ":" + pad(seconds % 60));
	    //$('.timer .min.count').html()); 
	},1000);
}
function pad(val) {
    var valString = val + "";
    return (valString.length < 2) ? "0" + valString : valString;
}

function showForeCast()
{
	if(showForecast)
	{
		$('#forecastModal').modal('show');
	}  
}

/*
var common = $.grep(array1, function(element) {
    return $.inArray(element, array2 ) !== -1;
});

console.log(common); // returns [1, 2, 3, 4, 5, 6];
*/