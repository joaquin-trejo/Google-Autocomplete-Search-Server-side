<?php
/*
This file will be used for listing autocomplete results.
Google autocomplete api (json) will be used to fetch data.


*/

Class Autocomplete{

  public function suggest_location(){
        header("Cache-Control: private, max-age=86400");
			  header("Expires: ".gmdate('r', time()+86400));
        $query = 'pune '.$this->input->get('q',TRUE);
	    	$apikey='<API KEY>';
	    	$url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?key='.$apikey.'&types=geocode&sensor=true&language=en&location=18.526817,73.856564&radius=12000&input='.urlencode($query);
	    	$ch = curl_init();
	    	curl_setopt($ch, CURLOPT_URL, $url);
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    	$data1 = curl_exec($ch);
	    	curl_close($ch);
	    	$details = json_decode($data1, true);
	    	header("Content-Type: application/json");
	    	$json =  "{\"results\": [";
	    	foreach($details['predictions'] as $key=>$row) {
	    		$arr[] = "{\"id\": \"".$row['reference']."\", \"value\": \"".$row['description']."\"}";
	    	}
	    	$json .= implode(", ", $arr);
	    	echo $json . "]}";
  
  }
  public function get_geocode(){
      $query = 'https://maps.googleapis.com/maps/api/place/details/json?reference='.urlencode($this->input->get('location',TRUE)).'&sensor=true&key=AIzaSyAt_gCyokXmulA4L33EWKg_SrR34c6t7dU';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $query);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($ch); // execute curl session
			curl_close($ch); // close curl session
			$details = json_decode($data, true);
	    $map['lat'] = $details['result']['geometry']['location']['lat'];
	    $map['long'] = $details['result']['geometry']['location']['lng'];
	    return json_encode($map);
  }


}




?>
