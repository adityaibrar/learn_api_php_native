<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //update user
    include 'DatabaseConfig.php';
    $conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

    //read JSON from client
    $json = file_get_contents('php://input', true);
    $obj = json_decode($json);

    //get JSON object
    $user_id = $obj->id_user;
    $fullname = $obj->username;
    $email = $obj->email;
    $password = $obj->password;

    $query_update = "UPDATE users SET username = '$fullname', email = '$email' ,password = '$password' WHERE id_user = '$user_id'";

    $query = mysqli_query($conn, $query_update);
    $check = mysqli_affected_rows($conn);
    $json_array = array();
    $response = "";

    if ($check > 0) {
        $response = array(
            'code' => 200,
            'status' => 'Data sudah diperbaharui!'
        );
    } else {
        $response = array(
            'code' => 400,
            'status' => 'Gagal diperbaharui!'
        );
    }

    print(json_encode($response));
    mysqli_close($conn);
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //select spesific user
    include 'DatabaseConfig.php';
    $conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

    $user_id = $_GET['id_user'];

    $query_update = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_fetch_array(mysqli_query($conn, $query_update));
    $json_array = array();
    $response = "";

    if (isset($result)) {
        $data = mysqli_query($conn, $query_update);
        while ($row = mysqli_fetch_assoc($data)) {
            $json_array = $row;
        }
        $response = array(
            'code' => 200,
            'status' => 'Sukses',
            'user_list' => $json_array
        );
    } else {
        $response = array(
            'code' => 404,
            'status' => 'Data tidak ditemukan!',
            'user_list' => $json_array
        );
    }
    print(json_encode($response));
    mysqli_close($conn);
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    //delete spesific user
    include 'DatabaseConfig.php';
    $conn = mysqli_connect($HostName, $HostUser, $HostPass, $DatabaseName);

    $user_id = $_GET['id_user'];

    $query_delete = "DELETE FROM users WHERE id_user = '$user_id'";
    $result = mysqli_query($conn, $query_delete);
    $check = mysqli_affected_rows($conn);
    $json_array = array();
    $response = "";

    if ($check > 0) {
        $response = array(
            'code' => 200,
            'status' => 'Data terhapus!'
        );
    } else {
        $response = array(
            'code' => 404,
            'status' => 'Gagal dihapus!'
        );
    }
    print(json_encode($response));
    mysqli_close($conn);
}
