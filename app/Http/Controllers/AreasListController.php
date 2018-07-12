<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Place;

//Radius of Earth in meteres
define('EARTH_RADIUS', 6372795);

class AreasListController extends Controller
{
    public function showAreasList(Request $request)
    {
    	if(isset($request->delete)){
    		$this->deletePlace($request->address);
    		return redirect('/');
    	}
    	$isFiltered = false;
    	$currAddress = "";
    	$places = Place::orderBy('address')->get();
    	$addressList = Place::select('address')->orderBy('address')->get();
    	if(isset($request->address)){
    		$currAddress = $request->address;
    		$places = $this->getPlacesWithDistance($places,$currAddress);
    		$isFiltered = true;
    	}
    	return view('areaslist', compact('places', 'isFiltered', 'currAddress', 'addressList'));
    }

    private function getPlacesWithDistance($places, $currAddress)
    {
		$currPlace = Place::where('address', $currAddress)->first();
		$lat1 = $currPlace->lat;
		$long1 = $currPlace->lng;
		foreach($places as $place){
			if($place->address == $currAddress){ continue; }
			$lat2 = $place->lat;
			$long2 = $place->lng;
			$distance = $this->calculateTheDistance($lat1, $long1, $lat2, $long2);
			$tempArr[$place->address] = $distance;
		}
		arsort($tempArr);
		return collect($tempArr);
    }

    public function showAddPlace()
    {
    	return view('addplace');
    }

    public function deletePlace($address)
    {
    	$place = Place::where('address', $address)->first();
    	$place->delete();
    }

    public function savePlace(Request $request)
    {
    	$address = $request->address;
    	$place = Place::updateOrCreate(
    		['lat' => $request->lat, 'lng' => round($request->lng, 6)],
    		['address' => $address]
    	);
    	return ["The place uccessfully saved."];
    }

    //calculate the distance between 2 points with Earth form as sphere
    //returned value rounding to integer
    private function calculateTheDistance(float $lat1, float $long1, float $lat2, float $long2): float
    {
    	//coordinates to radians
    	$radlat1 = $lat1 * M_PI / 180;
	    $radlat2 = $lat2 * M_PI / 180;
	    $radlong1 = $long1 * M_PI / 180;
	    $radlong2 = $long2 * M_PI / 180;

	    // cos and sin of Latitudes
    	$coslat1 = cos($radlat1);
    	$coslat2 = cos($radlat2);
    	$sinlat1 = sin($radlat1);
    	$sinlat2 = sin($radlat2);

    	// Longitude difference
    	$delta = $radlong2 - $radlong1;
    	$cosdelta = cos($delta);
    	$sindelta = sin($delta);

    	$y = sqrt(pow($coslat2 * $sindelta, 2) + pow($coslat1 * $sinlat2 - $sinlat1 * $coslat2 * $cosdelta, 2));
			
		$x = $sinlat1 * $sinlat2 + $coslat1 * $coslat2 * $cosdelta;

		$ad = atan2($y,$x); 

		$dist = $ad * EARTH_RADIUS / 1000;

		return round($dist);
    }
}
