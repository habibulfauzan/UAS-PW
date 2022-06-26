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

    $kd_ktgri = mysqli_real_escape_string($conn,$_POST['id']);
    $nama = mysqli_real_escape_string($conn,$_POST['nama']);

    //Validation fields
    $kodeFilter = filter_var($kd_ktgri, FILTER_VALIDATE_INT);

    $isValidated = true;
    if($kodeFilter === false){
        $reply['error'] = "Kode Barang harus format INT";
        $isValidated = false;
    }
    if(empty($kd_ktgri)){
        $reply['message'] = "kode kategori harus diisi";
        $isValidated = false;
    }
    if(empty($nama)){
        $reply['message'] = 'nama kategori harus diisi';
        $isValidated = false;
    }

    if(!$isValidated){
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }

    try{
        $queryCheck = mysqli_query($conn, "SELECT * FROM kategori where `id` = $kd_ktgri");
        $cek = mysqli_num_rows($queryCheck);
        /**
         * Jika data tidak ditemukan
         * rowcount == 0
         */
        if($cek == 0){
            $reply['message'] = 'Kategori '.$kd_brg. ' tidak ditemukan';
            echo json_encode($reply);
            http_response_code(400);
            exit(0);
        }
    }catch (Exception $exception){
        $reply['message'] = $exception->getMessage();
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }

    $query =  "UPDATE `kategori` SET `nama`='$nama' WHERE id = $kd_ktgri";
    $execute = $conn->query($query);
    $response = [];

    if ($execute) {
        $response['status'] = true;
        $response['message'] = 'Data berhasil diubah';
    } else {
        $response['status'] = false;
        $response['message'] = 'Data gagal diubah';
    }
    $json = json_encode($response, JSON_PRETTY_PRINT);
    echo $json;
?>
