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

$status = $_POST['status'];
$delivery_fee = $_POST['delivery_fee'];
$minimum_amount = $_POST['minimum_amount'];
$free_delivery = $_POST['free_delivery'];
$delivery_fee_settings = $_POST['delivery_fee_settings'];
$delivery_ready_time = $_POST['delivery_ready_time'];
$available_times = $_POST['available_times'];
$shape_type = $_POST['shape_type'];
$path = json_decode($_POST['path']);
$x = $_POST['x'];
$y = $_POST['y'];
$radius = $_POST['radius'];

$sql = "INSERT INTO delivery (status, deliveryFee, minAmmount, freeDelivery, deliveryFeeSettings, deliveryReadyTime, availableTimes, shape_type, radius, x, y)
      VALUES ('$status','$delivery_fee','$minimum_amount','$free_delivery','$delivery_fee_settings','$delivery_ready_time','$available_times', '$shape_type', '$radius','$x','$y');";

if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";

      $last_id = $conn->insert_id;
      if ($shape_type == 'polygon')
      {
            $sql = "INSERT INTO polygon_path (radius_id, x, y) VALUES ('1', '111', '222')";
            if (mysqli_query($conn, $sql)) {
                  echo "New polygon_dot created successfully";                  
            } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            for ($i = 0; $i < sizeof($path); $i += 2)
            {
                  $sql = "INSERT INTO polygon_path (radius_id, x, y) VALUES ('$last_id', '" . $path[$i] . "', '" . $path[$i + 1] . "')";
                  if (mysqli_query($conn, $sql)) {
                        echo "New polygon_dot created successfully";                  
                  } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                  }
            }
      }
} else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>

