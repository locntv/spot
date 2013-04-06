var MYMAP = {
	map: null,
	bounds: null,
	currentMarker: null,
	geocoder: null,
	curLng: null,
	curLat: null
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

				new google.maps.Marker({
					position: new google.maps.LatLng(parseFloat(element.lat), parseFloat(element.lng)),
					map: MYMAP.map,
					//icon: image,
					title: element.note
				});

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

MYMAP.placeMarkersByLocation = function(url, icon_url) {

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

						// create a new LatLng point for the marker
						var lat = element.places_latitude;
						var lng = element.places_longitude;
						var point = new google.maps.LatLng(parseFloat(lat),parseFloat(lng));

						var image = new google.maps.MarkerImage(
							icon_url + element.id,
							new google.maps.Size(32,32),
							new google.maps.Point(0,0),
							new google.maps.Point(16,32)
						);

						var marker = new google.maps.Marker({
							//draggable: true,
							position: point,
							map: MYMAP.map,
							icon: image,
							title: element.places_name
						});

						/*var infoWindow = new google.maps.InfoWindow();
						var html = '<b>' + element.places_name + '</b><br />';
						html += element.places_address;
						infoWindow.setContent(html);
						infoWindow.open(MYMAP.map, marker);*/
					});
				}
			});

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
			MYMAP.curLat = position.coords.latitude;
			MYMAP.curLng = position.coords.longitude;
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

MYMAP.getPeopleByLocation = function(selector, url, place_id, lng, lat, is_checkin) {

	// Try HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {

			var p1 = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			var p2 = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
			var distance = google.maps.geometry.spherical.computeDistanceBetween(p1, p2) * 0.000621371;
			if ( distance > 1 ) {
				if (is_checkin) {
					// call ajax checkout
					$.ajax({
						'type'    : 'GET',
						'url'     : 'checkout/' + place_id,
						'success' : function() {
							$("#popupNoticeDialog").popup("open");
						}
					});
				} else {
					$("#popupNoticeDialog").popup("open");
				}
			} else {
				if (is_checkin) {
					// call ajax bind people
					$.ajax({
						'dataType': 'json',
						'type'    : 'GET',
						'url'     : 'people_ajax/' + place_id,
						'success' : function(data) {
							$(selector).empty();
							$.each(data, function(index, element) {
								$(selector).append(listing_item(element));
							});
							$(selector).listview("refresh");
						}
					});
					$(selector).listview("refresh");
				} else {
					// show popup to choose checkin status
					$( "#popup_place_id" ).val(place_id);
					$( "#popupDialog" ).popup( "open" );
				}
			}

		}, function() {
			handleNoGeolocation(true);
		});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
	}
}

MYMAP.getCurrentPos = function() {
	// Try HTML5 geolocation
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			MYMAP.curLat = position.coords.latitude;
			MYMAP.curLng = position.coords.longitude;
		}, function() {
			handleNoGeolocation(true);
		});
	} else {
		// Browser doesn't support Geolocation
		handleNoGeolocation(false);
	}
}
