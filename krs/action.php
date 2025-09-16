<?php

include '../db.php';
$db= new db();

$mode=$_POST['mode']??'';
$id=$_POST['id']??'';
$nim=$_POST['nim']??'';
$id_jadwal=$_POST['id_jadwal']??'';
$kd_semester=$_POST['kd_semester']??'';


try{
    if($mode=='add'){
        $db->add_krs($nim, $id_jadwal, $kd_semester);
    }

    else if($mode=='edit'){
        $db->update_krs($id, $nim, $id_jadwal, $kd_semester);
    }

    

    else if($mode=='delete'){
        $db->delete_krs($id);
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






