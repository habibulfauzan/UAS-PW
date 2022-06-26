<?php
include '../koneksi.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(400);
        $reply['message'] = 'POST method required';
        echo json_encode($reply);
        exit();
    }

    $kd_brg = mysqli_real_escape_string($conn,$_POST['kode_barang']);
    $jumlahx = mysqli_real_escape_string($conn,$_POST['jumlah']);

    // Validation fields
    $isValidated = true;
    if(empty($kd_brg)){
        $reply['message'] = "kode barang harus diisi";
        $isValidated = false;
    }
    if(empty($jumlahx)){
        $reply['message'] = "jumlah barang keluar harus diisi";
        $isValidated = false;
    }
    // if(empty($uname)){
    //     $reply['message'] = 'username harus diisi';
    //     $isValidated = false;
    // }
    if(!$isValidated){
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }

    try{
        $queryCheck = mysqli_query($conn, "SELECT * FROM barang where `kode_barang` = $kd_brg");
        $cek2 = mysqli_num_rows($queryCheck);
        /**
         * Jika data tidak ditemukan
         * rowcount == 0
         */
        if($cek2 == 0){
            $reply['status'] = false;
            $reply['message'] = 'Kode Barang tidak ditemukan';
            echo json_encode($reply);
            http_response_code(400);
            exit(0);
        }else {
            $delete = mysqli_query($conn, "UPDATE `barang` SET `jumlah`=`jumlah`-$jumlahx WHERE `kode_barang` = $kd_brg");
            $reply['status'] = true;
            $reply['message'] = 'Barang dengan Kode Barang '.$jumlahx.' berhasil dikeluarkan';
            echo json_encode($reply);
        }
    }catch (Exception $exception){
        $reply['message'] = $exception->getMessage();
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }
    //$response = [];

// if ($execute) {
//     $response['status'] = 'succcess';
//     $response['message'] = 'data berhasil dihapus';
// } else {
//     $response['status'] = 'failed';
//     $response['message'] = 'data gagal dihapus';
// }
// $json = json_encode($response, JSON_PRETTY_PRINT);
// echo $json;
?>