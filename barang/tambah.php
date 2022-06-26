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
    $nm_brg = mysqli_real_escape_string($conn,$_POST['nama_barang']);
    $jumlah = mysqli_real_escape_string($conn,$_POST['jumlah']);
    // $admin = mysqli_real_escape_string($conn,$_POST['admin']);
    $kategori = mysqli_real_escape_string($conn,$_POST['kategori']);

    //Validation fields

    $kodeFilter = filter_var($kd_brg, FILTER_VALIDATE_INT);
    $jumlahFilter = filter_var($jumlah, FILTER_VALIDATE_INT);
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
    if(empty($nm_brg)){
        $reply['message'] = 'nama barang harus diisi';
        $isValidated = false;
    }
    if(empty($jumlah)){
        $reply['message'] = "jumlah harus format diisi";
        $isValidated = false;
    }
    // if(empty($admin)){
    //     $reply['message'] = 'nama barang harus diisi';
    //     $isValidated = false;
    // }
    if(empty($kategori)){
        $reply['message'] = "kode barang harus diisi";
        $isValidated = false;
    }

    if(!$isValidated){
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }
    
    $query =  mysqli_query($conn, "INSERT INTO `barang`(`kode_barang`, `nama_barang`, `jumlah`, `kategori`, `created_at`) VALUES ($kd_brg, '$nm_brg', $jumlah, '$kategori', default)");
    
    $response = [];

    if ($query) {
        $response['status'] = true;
        $response['message'] = 'user berhasil ditambahkan';
    } else {
        $response['status'] = false;
        $response['message'] = 'user gagal ditambahkan';
        echo json_encode($query);
    }
    $json = json_encode($response, JSON_PRETTY_PRINT);
    echo $json;
?>