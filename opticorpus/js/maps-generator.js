/* Készítő: H.Tibor */
var gMapNoRepos = false;
var gMap = geoCode = gMapMarker = geocode = '';
function load() {
	geoCode = new google.maps.Geocoder();
	var gMapLatLng = new google.maps.LatLng(parseFloat(document.getElementById("lati").value), parseFloat(document.getElementById("longi").value));
	var gMapDefPozLoad = { zoom : 15, center : gMapLatLng, mapTypeControlOptions:{ mapTypeIds : [], style : google.maps.MapTypeControlStyle.DEFAULT }, mapTypeId : google.maps.MapTypeId.ROADMAP };
	gMap = new google.maps.Map(document.getElementById("gmap"), gMapDefPozLoad);
	gMapMarkerLoad(gMapLatLng);
}
function isAddress(inType, addressVal) {
	for(var i = 0; i < addressVal.length; i++) {
		if(addressVal[i] == inType) { return true; }
	}
	return false;
}
function LoadSearchPosition(gMapAddress, gMapStatus) {
	if(gMapStatus == google.maps.GeocoderStatus.OK) {
		var gAddress = gMapAddress[0].address_components;
		var addressCountry = addressCountryShort = addressPostCode = addressCity = addressSbLoc = addressRoute = addressStNumber = '';
		for (var i = 0; i < gAddress.length; i++) {
			if (isAddress('country', gAddress[i].types)) {
				addressCountry = gAddress[i].long_name; /* Ország */
				addressCountryShort = gAddress[i].short_name; /* Ország pl. HU */
			}
			if (isAddress('postal_code', gAddress[i].types)) {
				addressPostCode = gAddress[i].short_name; /* Ir. szám */
			}
			if (isAddress('locality', gAddress[i].types)) {
				addressCity = gAddress[i].long_name; /* Város */
			}
			if (isAddress('sublocality', gAddress[i].types)) {
				addressSbLoc = gAddress[i].short_name; /* Kerület */
			}
			if (isAddress('route', gAddress[i].types)) {
				addressRoute = gAddress[i].short_name; /* Utca */
			}
			if (isAddress('street_number', gAddress[i].types)) {
				addressStNumber = gAddress[i].long_name; /* Házszám */
			}
		}
		if(!gMapNoRepos) {
			gMap.fitBounds(gMapAddress[0].geometry.viewport); 
			gMapMarkerLoad(gMapAddress[0].geometry.location);
		} else { gMapNoRepos = false; }
		document.getElementById("irsz").value = addressPostCode;
		document.getElementById("varos").value = addressCity+((addressSbLoc)?(' '+addressSbLoc):(''));
		document.getElementById("utca").value = addressRoute+((addressStNumber)?(' '+addressStNumber):(''));
		$("#infoText").html(LoadInfoTextData());
		setTimeout(function() { FormControl(0); }, 100);
	}
}
function showAddress(address) {
	geoCode.geocode({ 'address' : address }, LoadSearchPosition);
}
function showAddressMark(pos) {
	gMapNoRepos = true;
	geoCode.geocode({ latLng: pos }, LoadSearchPosition);
}

function gMapMarkerLoad(gMapMarkerPosition) {
	if(gMapMarker) {
		google.maps.event.clearInstanceListeners(gMapMarker);
		gMapMarker.setMap(null);
		gMapMarker = null;
	}
	gMapMarker = new google.maps.Marker({
			position : gMapMarkerPosition,
			map : gMap,
			draggable : true
		});
	
	var contentString = '<div id="infoText">'+LoadInfoTextData()+'</div>';
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});
	
	google.maps.event.addListener(gMapMarker, 'click', function() {
			infowindow.open(gMap,gMapMarker);
			setTimeout(function() { $("#infoText").html(LoadInfoTextData()); }, 100);
		});
	
	google.maps.event.addListener(gMapMarker, 'dragend', function () {
		document.getElementById("lati").value = gMapMarker.getPosition().lat();
		document.getElementById("longi").value = gMapMarker.getPosition().lng();
		showAddressMark(gMapMarker.getPosition());
	});
	google.maps.event.addListener(gMapMarker, 'drag', function () {
		document.getElementById("lati").value = (gMapMarker.getPosition().lat());
		document.getElementById("longi").value = (gMapMarker.getPosition().lng());
	});
	document.getElementById("lati").value = gMapMarker.getPosition().lat();
	document.getElementById("longi").value = gMapMarker.getPosition().lng();
}

function LoadInfoTextData() {
	var InfoTextOut  = '';
	var data = {
							'cimke' : $('#map_cimke').val(),
							'irsz'  : $('#irsz').val(),
							'varos' : $('#varos').val(),
							'utca'  : $('#utca').val(),
							'tel'   : $('#map_tel').val(),
							'fax'   : $('#map_fax').val(),
							'email' : $('#map_email').val(),
							'web'   : $('#map_web').val()
						};
	if(data['cimke']) {
			InfoTextOut += '<p style="font-size:14px;"><b>'+(data['cimke'])+'</b></p>';
	}
	if(data['irsz'] || data['varos'] || data['utca']) {
			InfoTextOut += '<p style="font-size:12px;">';
			InfoTextOut += '<b>Cím:</b> ';
			InfoTextOut += (data['irsz'])+' ';
			InfoTextOut += (data['varos'])
			InfoTextOut += ((data['varos'] && data['utca'])?(', '):(''));
			InfoTextOut += (data['utca']);
			InfoTextOut += '</p>';
	}
	if(data['tel'] || data['fax']) {
			InfoTextOut += '<p style="font-size:12px;">';
			InfoTextOut += ((data['tel'])?('<b>Tel:</b> '+(data['tel'])):(''));
			InfoTextOut += ((data['tel'] && data['fax'])?(', '):(''));
			InfoTextOut += ((data['fax'])?('<b>Fax:</b> '+(data['fax'])):(''));
			InfoTextOut += '</p>';
	}
	if(data['email'] || data['web']) {
			InfoTextOut += '<p style="font-size:12px;">';
			InfoTextOut += ((data['email'])?('<b>Email:</b> <a href="mailto:'+(data['email'])+'">'+(data['email'])+'</a>'):(''));
			InfoTextOut += ((data['email'] && data['web'])?(', '):(''));
			InfoTextOut += ((data['web'])?('<b>web:</b> <a href="http://'+(data['web'])+'/" target="_blank">'+(data['web'])+'</a>'):(''));
			InfoTextOut += '</p>';
	}
	return InfoTextOut;
}

setInterval(function() {
	if($("#infoText")) {
		$("#infoText").each(function() {
			$(this).parent().parent().css({'overflow':'hidden'});
			$(this).parent().parent().parent().prev().css({'borderRadius':'8px','boxShadow':'0px 0px 9px #CCCCCC inset','zIndex':'1'});
			$(this).parent().parent().parent().parent().prev().css({'borderRadius':'8px','boxShadow':'0px 0px 9px #CCCCCC inset','zIndex':'1'});
			$(this).parent().parent().parent().parent().children(':first-child').css('zIndex','2');
			$(this).parent().parent().parent().parent().parent().children(':first-child').css('zIndex','2');
		});
	}
	if($("#gmap")) {
		$("#gmap").children(':first-child').children(':first-child').next().css('display','none');
		$("#gmap").children(':first-child').children(':first-child').next().next().css('display','none');
		$("#gmap").children(':first-child').children(':first-child').next().next().next().next().next().css('display','none');
		$("#gmap").children(':first-child').children(':first-child').next().next().next().next().next().next().children(':first-child').next().css('display','none');
		$("#gmap").children(':first-child').children(':first-child').next().next().next().next().next().next().next().children(':first-child').next().css('display','none');
	}
},200);