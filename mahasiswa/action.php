<?php

include '../db.php';
$db= new db();

$mode=$_POST['mode']??'';
$nim=$_POST['nim']??'';
$nama=$_POST['nama']??'';
$jurusan=$_POST['jurusan']??'';
$alamat=$_POST['alamat']??'';


try{
    if($mode=='add'){
        $db->add_mahasiswa($nim, $nama, $jurusan, $alamat);
    }

    else if($mode=='edit'){
        $db->update_mahasiswa($nim, $nama, $jurusan, $alamat);
    }

    

    else if($mode=='delete'){
        $db->delete_mahasiswa($nim);
    }


    else {
        echo "Wrong mode";
    }
    echo json_encode(['status'=>'success']);
} catch(Exception $e){
    $errorMsg = $e -> getMessage();
    if (str_contains($errorMsg, 'foreign key constraint fails')){
        echo json_encode(['status => error', 'message' => 'Data sudah dipakai di tabel lain (FOREIGN KEY)']);
    }
    else{
        echo json_encode(['status => error', 'message' => $e -> getMessage()]);
    }
    
}

exit;






