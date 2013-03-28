var MYMAP = {
	map: null,
	bounds: null,
	currentMarker: null,
	geocoder: null
}

MYMAP.init = function(selector, zoom) {
	var myOptions = {
		zoom:zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		scrollwheel: false
	}
	this.map = new google.maps.Map($(selector)[0], myOptions);
	//this.bounds = new google.maps.LatLngBounds();
	this.geocoder = new google.maps.Geocoder();
}

MYMAP.setCurrentMarker = function(draggable, address) {
	this.currentMarker = new google.maps.Marker( { draggable: draggable } );
	// Try HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			latlng = new google.maps.LatLng(position.coords.latitude,
										position.coords.longitude);

			//MYMAP.bounds.extend(latlng);
			MYMAP.currentMarker.setMap(MYMAP.map);
			MYMAP.currentMarker.setPosition(latlng);
			MYMAP.currentMarker.setTitle("you're here");
			MYMAP.map.setCenter(latlng);

			google.maps.event.addListener(MYMAP.map, 'zoom_changed', function() {
				MYMAP.map.setCenter(latlng);
			});

			if (typeof address !== 'undefined') {
				MYMAP.getMarkerInfo(MYMAP.currentMarker, address.id, address.lat, address.lng);
			}
			//MYMAP.map.fitBounds(MYMAP.bounds);
		}, function() {
			handleNoGeolocation(true);
		});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
	}
}

MYMAP.placeMarkers = function(selector, url) {
	$.ajax({
		'dataType': 'json',
		'type'    : 'POST',
		'async'   : false,
		'url'     : url,
		//'data'    : { lat: lat, lng: lng },
		'success' : function(data) {
			$(selector).empty();
			$.each(data, function(index, element) {
				$(selector).append(listing_item(element));

				// create a new LatLng point for the marker
				var lat = element.latitude;
				var lng = element.longitude;
				var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

				var marker = new google.maps.Marker({
					position: point,
					map: MYMAP.map
				});

				var infoWindow = new google.maps.InfoWindow();
				var html='<p>' + element.note + '</p>';
				google.maps.event.addListener(marker, 'click', function() {
					infoWindow.setContent(html);
					infoWindow.open(MYMAP.map, marker);
				});
				//MYMAP.map.fitBounds(MYMAP.bounds);
				new google.maps.Marker({
					position: new google.maps.LatLng(parseFloat(element.lat), parseFloat(element.lng)),
					map: MYMAP.map,
					//icon: image,
					title: element.note
				});

				/*latlng = new google.maps.LatLng(14.058326, 108.377199);
				new google.maps.Marker({
					position: latlng,
					map: MYMAP.map,
					//icon: image,
					title: 'adssa'
				});*/
			});
		}
	});
	$("#listing").listview("refresh");
}

MYMAP.getMarkerInfo = function(marker, address_elementid, lat_elementid, lng_elementid) {
	if (MYMAP.geocoder) {
		MYMAP.geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					$(address_elementid).val(results[0].formatted_address);
					$(lat_elementid).val(marker.getPosition().lat());
					$(lng_elementid).val(marker.getPosition().lng());
				}
			}
		});
	}
}

MYMAP.addDragMarkerEvent = function(marker, address_elementid, lat_elementid, lng_elementid) {
	//Add listener to marker for reverse geocoding
	google.maps.event.addListener(marker, 'drag', function() {
		//MYMAP.getMarkerInfo(marker, address_elementid, lat_elementid, lng_elementid);
		MYMAP.geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					$(address_elementid).val(results[0].formatted_address);
					$(lat_elementid).val(marker.getPosition().lat());
					$(lng_elementid).val(marker.getPosition().lng());
				}
			}
		});
	});
}

MYMAP.searchLocation = function(marker, address_elementid, lat_elementid, lng_elementid) {
	var address = document.getElementById("address").value;
	MYMAP.geocoder.geocode ( { 'address': address }, function( results, status )  {
		if ( status == google.maps.GeocoderStatus.OK ) {
			MYMAP.map.setCenter( results[0].geometry.location );
			marker.setPosition( results[0].geometry.location );
			$(address_elementid).val( results[0].formatted_address );
			$(lat_elementid).val( results[0].geometry.location.lat() );
			$(lng_elementid).val( results[0].geometry.location.lng() );
			//updateDistance(pos, results[0].geometry.location);
			//map.setZoom(15);
			//google.maps.geometry.spherical.computeDistanceBetween(pos, results[0].geometry.location);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

MYMAP.placeMarkersByLocation = function(url) {

	// Try HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {

			$.ajax({
				'dataType': 'json',
				'type'    : 'POST',
				'async'   : false,
				'url'     : url,
				'data'    : { lat: position.coords.latitude, lng: position.coords.longitude },
				'success' : function(data) {
					//$(selector).empty();
					$.each(data, function(index, element) {
						//$(selector).append(listing_item(index + 1, element));

						// create a new LatLng point for the marker
						var lat = element.places_latitude;
						var lng = element.places_longitude;
						var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));
alert(element.places_name);
						var marker = new google.maps.Marker({
							position: point,
							map: MYMAP.map
						});

						var infoWindow = new google.maps.InfoWindow();
						var html='<p>' + element.places_name + '</p>';
						google.maps.event.addListener(marker, 'click', function() {
							infoWindow.setContent(html);
							infoWindow.open(MYMAP.map, marker);
						});
						//MYMAP.map.fitBounds(MYMAP.bounds);
						new google.maps.Marker({
							position: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
							map: MYMAP.map,
							//icon: image,
							title: element.places_name
						});

					});
				}
			});
			$(selector).listview("refresh");
		}, function() {
			handleNoGeolocation(true);
		});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
	}
}

MYMAP.getPlacesByLocation = function(selector, url) {

	// Try HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {

			$.ajax({
				'dataType': 'json',
				'type'    : 'POST',
				'async'   : false,
				'url'     : url,
				'data'    : { lat: position.coords.latitude, lng: position.coords.longitude },
				'success' : function(data) {
					$(selector).empty();
					$.each(data, function(index, element) {
						$(selector).append(listing_item(index + 1, element));
					});
				}
			});
			$(selector).listview("refresh");
		}, function() {
			handleNoGeolocation(true);
		});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
	}
}
