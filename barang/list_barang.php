<?php 
include '../koneksi.php';
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers:*');

    $sql = $conn->query("SELECT * FROM barang");
    $users = array();
    if ($sql->num_rows > 0) {
    while($row = $sql->fetch_assoc()) {
        $response = $row;
        array_push($users, $row);
    }
    $result['list_barang'] = $users;
        $json2 = json_encode($result, JSON_PRETTY_PRINT);
        echo $json2;
}
?>