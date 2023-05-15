<?php
header('Content-Type: application/json');
include 'DatabaseConfig.php';
$conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);


$id = $_GET['id_user'];
$query = "SELECT * FROM users WHERE id_user = $id";
$response = array();
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $response[] = $row;
}
echo json_encode(array('data' => $response));
// echo json_encode($response);