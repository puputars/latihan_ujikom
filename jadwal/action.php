<?php

include '../db.php';
$db= new db();

$mode=$_POST['mode']??'';
$id=$_POST['id']??'';
$kd_dosen=$_POST['kd_dosen']??'';
$kd_matkul=$_POST['kd_matkul']??'';
$waktu=$_POST['waktu']??'';
$ruang=$_POST['ruang']??'';


try{
    if($mode=='add'){
        $db->add_jadwal($kd_dosen, $kd_matkul, $waktu, $ruang);
    }

    else if($mode=='edit'){
        $db->update_jadwal($id, $kd_dosen, $kd_matkul, $waktu, $ruang);
    }

    

    else if($mode=='delete'){
        $db->delete_jadwal($id);
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
        //echo json_encode(['status => error', 'message' => $e -> getMessage(), 'debug'   => $sql ?? '']);
        echo json_encode(['status => error', 'message' => $e -> getMessage()]);
    }
    
}

exit;






