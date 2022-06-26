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

    $id_kategori = mysqli_real_escape_string($conn,$_POST['id']);

    // Validation fields
    $idFilter = filter_var($id_kategori, FILTER_VALIDATE_INT);
    $isValidated = true;
    if($idFilter === false){
        $reply['error'] = "ID Kategori harus format INT";
        $isValidated = false;
    }
    if(empty($id_kategori)){
        $reply['message'] = "id kategori harus diisi";
        $isValidated = false;
    }
    if(!$isValidated){
        echo json_encode($reply);
        http_response_code(400);
        exit(0);
    }

    try{
        $queryCheck = mysqli_query($conn, "SELECT * FROM kategori where `id` = $id_kategori");
        $cek2 = mysqli_num_rows($queryCheck);
        /**
         * Jika data tidak ditemukan
         * rowcount == 0
         */
        if($cek2 == 0){
            $reply['status'] = false;
            $reply['message'] = 'Kategori tidak ditemukan';
            echo json_encode($reply);
            http_response_code(400);
            exit(0);
        }else {
            $delete = mysqli_query($conn, "DELETE FROM `kategori` WHERE id = $id_kategori");
            $reply['status'] = true;
            $reply['message'] = 'Kategori '.$id_kategori.' berhasil dihapus';
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