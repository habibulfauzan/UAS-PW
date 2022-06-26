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
    // $nm_brg = mysqli_real_escape_string($conn,$_POST['nama_barang']);
    $jumlah = mysqli_real_escape_string($conn,$_POST['jumlah']);
    // $admin = mysqli_real_escape_string($conn,$_POST['admin']);
    // $kategori = mysqli_real_escape_string($conn,$_POST['kategori']);

    //Validation fields
    $kodeFilter = filter_var($kd_brg, FILTER_VALIDATE_INT);
    // $jumlahFilter = filter_var($jumlah, FILTER_VALIDATE_INT);
    // $adminFilter = filter_var($admin, FILTER_VALIDATE_INT);

    $isValidated = true;
    if($kodeFilter === false){
        $reply['error'] = "Kode Barang harus format INT";
        $isValidated = false;
    }
    if($jumlahFilter === false){
        $reply['error'] = "Jumlah harus format INT";
        $isValidated = false;
    }
    // if($adminFilter === false){
    //     $reply['error'] = "Admin harus format INT";
    //     $isValidated = false;
    // }
    if(empty($kd_brg)){
        $reply['message'] = "kode barang harus diisi";
        $isValidated = false;
    }
    // if(empty($nm_brg)){
    //     $reply['message'] = 'nama barang harus diisi';
    //     $isValidated = false;
    // }
    if(empty($jumlah)){
        $reply['message'] = "jumlah harus format diisi";
        $isValidated = false;
    }
    // if(empty($kategori)){
    //     $reply['message'] = "kode barang harus diisi";
    //     $isValidated = false;
    // }

    if(!$isValidated){
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }

    try{
        $queryCheck = mysqli_query($conn, "SELECT * FROM barang where `kode_barang` = $kd_brg");
        $cek = mysqli_num_rows($queryCheck);
        /**
         * Jika data tidak ditemukan
         * rowcount == 0
         */
        if($cek == 0){
            $reply['message'] = 'Barang '.$kd_brg. ' tidak ditemukan';
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

    $query =  "UPDATE `barang` SET `jumlah`=$jumlah WHERE kode_barang = $kd_brg ";
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
