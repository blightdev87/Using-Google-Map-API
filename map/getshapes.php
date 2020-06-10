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

$lng = $_POST['lng'];
$lat = $_POST['lat'];


$query = "SELECT * FROM delivery ORDER BY id ASC";

if (mysqli_query($conn, $query)) {
    $result = mysqli_query($conn, $query);
    $json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    for($i = 0; $i < sizeof($json); $i ++)
    {
        if ($json[$i]['shape_type'] == 'polygon')
        {
            $path = array();
            $sql = "SELECT x, y FROM polygon_path WHERE radius_id='" . $json[$i]['id'] . "'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    array_push($path, array($row['x'], $row['y']));
                }
            } else {
                echo "0 results";
            }

            $json[$i]['path'] = $path;
        }
    }
    echo json_encode($json);
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>

