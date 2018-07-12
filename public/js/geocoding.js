var geocoder;
var map;
var _address = null;
var _location = null;


 $(document).ready(function()
 {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
});

function initMap()
{
	geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(44.616, 33.525);
    var mapOptions = {
      zoom: 8,
      center: latlng
    }
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
}

function codeAddress() 
{
    _address = $('#address').val();
    geocoder.geocode( { 'address': _address}, function(results, status) {
      if (status == 'OK') {
      	$('#save').removeClass("btn-danger");
      	$('#save').addClass("btn-success");
      	_location = results[0].geometry.location;
        map.setCenter(_location);
        var marker = new google.maps.Marker({
            map: map,
            position: _location
        });
      } else {
      	$('#save').removeClass("btn-success");
      	$('#save').addClass("btn-danger");
      }
    });
}

function savePlace()
{
	if(_location == null || _address == null){ return; }
	 $.ajax({
	  type:'POST',
	  url:'/saveplace',
	  dataType : 'json',
	  data:{ address : _address, lat : _location.lat(), lng : _location.lng() },
	  success:function(response){
	  	   alert(response);
	  	   _location = null;
	  	   _address = null;
  		},
  	  error: function (jqXHR, exception) {
	        var msg = '';
	        if (jqXHR.status === 0) {
	            msg = 'Not connect.\n Verify Network.';
	        } else if (jqXHR.status == 404) {
	            msg = 'Requested page not found. [404]';
	        } else if (jqXHR.status == 500) {
	            msg = 'Internal Server Error [500].';
	        } else if (exception === 'parsererror') {
	            msg = 'Requested JSON parse failed.';
	        } else if (exception === 'timeout') {
	            msg = 'Time out error.';
	        } else if (exception === 'abort') {
	            msg = 'Ajax request aborted.';
	        } else {
	            msg = 'Uncaught Error.\n' + jqXHR.responseText;
	        }
	        alert(msg);
    	}
 	});
}
