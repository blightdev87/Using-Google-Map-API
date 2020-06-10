<?php

$servername = "localhost";
$database = "qicharge_caf";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
}

// Get radiuses from mysql
$query = "SELECT * FROM delivery ORDER BY id ASC";

if (mysqli_query($conn, $query)) {
    $result = mysqli_query($conn, $query);
    $json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    
    $matching_radius = null;
    $address = $_POST['address'];
    $latLng = geocode($address);

    for($i = 0; $i < sizeof($json); $i ++)
    {
        if ($json[$i]['shape_type'] == 'circle')
        {
            $distance = distance($latLng[0], $latLng[1], $json[$i]['x'], $json[$i]['y'], "K");
            if($distance * 1000 < $json[$i]['radius']) {
                // echo "Successfully in!";
                $matching_radius = $json[$i];
            } else {
                // echo "Not in!";
            }
        }
        if ($json[$i]['shape_type'] == 'polygon')
        {
            $sql = "SELECT x, y FROM polygon_path WHERE radius_id='" . $json[$i]['id'] . "'";
            $result = mysqli_query($conn, $sql);

            $vertices_x = array();    // x-coordinates of the vertices of the polygon
            $vertices_y = array(); // y-coordinates of the vertices of the polygon
            $points_polygon = mysqli_num_rows($result) - 1;  // number vertices - zero-based array
            $longitude_x = $latLng[0];  // x-coordinate of the point to test
            $latitude_y = $latLng[1];    // y-coordinate of the point to test

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($vertices_x, $row['x']);
                    array_push($vertices_y, $row['y']);
                }
            } else {
                // echo "0 results";
            }

            if ($points_polygon >= 2 && is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
                // echo "Is in polygon!";
                $matching_radius = $json[$i];
                break;
            }
            else {
                // echo "Is not in polygon";
            }
        }
    }

    if ($matching_radius)
    {
        echo 'Matching location found. Status: ' . $matching_radius['status'];
    }
    else
    {
        echo 'No matching result found.';
    }
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

// function to check if point is in polygon
function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
{
  $i = $j = $c = 0;
  for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
    if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
     ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
       $c = !$c;
  }
  return $c;
}

// function to get distance between two points
function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
    if (($lat1 == $lat2) && ($lon1 == $lon2)) 
    {
        return 0;
    }
    else 
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
    
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}

// function to geocode address, it will return false if unable to geocode address
function geocode($address){
 
    // url encode the address
    $address = urlencode($address);
     
    // google map geocode api url
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key=AIzaSyC-h_mpM0IUJKKQQDn7traYjF2jI1kZH5Q";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        // $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";
         
        // verify if data is complete
        if($lati && $longi) { //  && $formatted_address
         
            // put the data in the array
            $data_arr = array();            
             
            array_push($data_arr, $lati, $longi);
            return $data_arr;
             
        } else{
            echo "Error occured in getting geocode - 2";
            return false;
        }
         
    }
    else {
        echo "Error occured in getting geocode - 1";
        return false;
    }
}
?>