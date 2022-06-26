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
    $nm_ktgri = mysqli_real_escape_string($conn,$_POST['nama']);

    
    $isValidated = true;
    if(empty($nm_ktgri)){
        $reply['message'] = "nama kategori harus diisi";
        $isValidated = false;
    }

    if(!$isValidated){
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }
    
    $query =  mysqli_query($conn, "INSERT INTO `kategori`(`nama`, `created_at`) VALUES ('$nm_ktgri', default)");
    
    $response = [];

    if ($query) {
        $response['status'] = true;
        $response['message'] = 'kategori berhasil ditambahkan';
    } else {
        $response['status'] = false;
        $response['message'] = 'kategori gagal ditambahkan';
        echo json_encode($query);
    }
    $json = json_encode($response, JSON_PRETTY_PRINT);
    echo $json;
?>