<?php
//if latitude and longitude are submitted
if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
    //send request and receive json data by latitude and longitude
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false';
    $json = @file_get_contents($url);
    console.log($json);
    $data = json_encode($json);
    console.log($json);
    //if request status is successful
    if($status == "OK"){
        //return Json to ajax
        echo $json;
    }else{
        console.log('status not ok for getLocation()');
    }
}
?>