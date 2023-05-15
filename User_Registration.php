<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'DatabaseConfig.php';
    $conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

    //read JSON FROM client
    $json = file_get_contents('php://input', true);
    $obj = json_decode($json);

    //get JSON object
    $fullname = $obj->username;
    $email = $obj->email;
    $password = $obj->password;

    $query_check = "SELECT * FROM users WHERE email = '$email'";
    $check = mysqli_fetch_array(mysqli_query($conn, $query_check));
    $json_array = array();
    $response = "";

    if (isset($check)) {
        $response = array(
            'code' => 406,
            'status' => 'User has been registered!'
        );
    } else {
        $query_insert = "insert into users (email, password, username) values 
            ('$email', '$password', '$fullname')";
        if (mysqli_query($conn, $query_insert)) {
            $response = array(
                'code' => 201,
                'status' => 'User Registered'
            );
        } else {
            $response = array(
                'code' => 405,
                'status' => 'Registered Error!'
            );
        }
    }

    print(json_encode($response));
    mysqli_close($conn);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'DatabaseConfig.php';
    $conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);
    $query_insert = "SELECT * FROM users";
    $result = mysqli_query($conn, $query_insert);
    $json_array = array();
    $response = "";

    if (isset($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $json_array[] = $row;
        }
        $response = array(
            'code' => 200,
            'status' => 'Successful',
            'user_list' => $json_array
        );
    } else {
        $response = array(
            'code' => 400,
            'status' => 'Error',
            'user_list' => 0
        );
    }
    print(json_encode($response));
    mysqli_close($conn);
}
