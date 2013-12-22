<?php

ini_set('memory_limit', '-1');
set_time_limit(0);
date_default_timezone_set("Asia/Kolkata");
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');


$places = array();

$places = $_POST["places"];

$queryString = $_POST["queryString"];

if(isset($_POST["radius"]))
	$radius = $_POST["radius"];
else {
	echo "Places not set!!";
	exit();
}

$tempString = str_replace(" ", "_", $queryString);

$fileName = str_replace(",", "", $tempString);

$dateString = date("d-M-y");

$fileName = $fileName."--".$dateString.".csv";

$fd = fopen("./genfiles/".$fileName,'w+');

# Start writing to CSV file


$placeName = "";

for($i = 0; $i < count($places) ; $i++) {
	
	// echo "<br />".$places[$i]."<br />";
	
	$tempArray = explode("#",$places[$i]);
	$placeName = $tempArray[0];
	
	$latLongArray = explode("&",$tempArray[1]);
	
	$latitude = $latLongArray[0];
	$longitude = $latLongArray[1];
		
	$thisLine[] = $placeName;
	$thisLine[] = $latitude;
	$thisLine[] = $longitude;
	$thisLine[] = $radius;
	
	fputcsv($fd, $thisLine);
	
	unset($thisLine);
	
	$thisLine = array(); 
	
}

fclose($fd);

echo "<a href=\"./genfiles/".$fileName."\">".$fileName."</a>";

exit();

?>
