<?php

include '../db.php';
$db= new db();

$mode=$_POST['mode']??'';
$kd_dosen=$_POST['kd_dosen']??'';
$nama=$_POST['nama']??'';
$alamat=$_POST['alamat']??'';


try{
    if($mode=='add'){
        $db->add_dosen($kd_dosen, $nama, $alamat);
    }

    else if($mode=='edit'){
        $db->update_dosen($kd_dosen, $nama, $alamat);
    }

    

    else if($mode=='delete'){
        $db->delete_dosen($kd_dosen);
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






