@extends('layouts.structure')
@section('content')
<p></p>
<input class="form-control" id="address" type="textbox" placeholder="address" onchange="codeAddress()">
<button type="button" id="save" class="btn btn-block" onclick="savePlace()">Save</button>
 <div id="map" style="min-height: 800px;"></div>
<script type="text/javascript" src="/js/geocoding.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUDBsuCxyESI7iX1LO_uL0gk1AvZTarSo&callback=initMap"
    async defer></script>

@endsection 