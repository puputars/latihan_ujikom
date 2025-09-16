<?php

class db {
    private $koneksi;

    function __construct() {
        $this->koneksi = new mysqli("127.0.0.1", "root", "rootpassword", "db_pelatihan");
    } //dipanggil ketika object itu dibuat

    function get_user($username, $password) {
        $data = $this->koneksi->query("select * from tbl_user where username='$username' and password='$password'");
        return $data;
    }

    function get_mahasiswa(){
        $data_mahasiswa = $this->koneksi->query("select * FROM tbl_mahasiswa");
        return $data_mahasiswa;
    }

    function get_mahasiswa_by_nim($nim){
        $data_mahasiswa = $this->koneksi->query("select * from tbl_mahasiswa where nim='$nim'");
        return $data_mahasiswa;
    }

    function add_mahasiswa($nim, $nama, $alamat, $jurusan){
        return $this->koneksi->query("INSERT INTO tbl_mahasiswa (nim, nama, alamat, jurusan) VALUES ($nim, '$nama', '$alamat', '$jurusan')");
    }

    function delete_mahasiswa($nim){
        return $this->koneksi->query("DELETE FROM tbl_mahasiswa WHERE nim=$nim");
    }
    function update_mahasiswa($nim, $nama, $alamat, $jurusan){
        return $this->koneksi->query("UPDATE tbl_mahasiswa SET nama='$nama', alamat='$alamat', jurusan='$jurusan' WHERE nim=$nim");
    }

    function get_dosen(){
        return $this->koneksi->query("SELECT * FROM tbl_dosen");
    }

    function get_dosen_by_kd_dosen($kd_dosen){
        return $this->koneksi->query("SELECT * FROM tbl_dosen WHERE kd_dosen=$kd_dosen");
    }

    function add_dosen($kd_dosen, $nama, $alamat){
        return $this->koneksi->query("INSERT INTO tbl_dosen (kd_dosen, nama, alamat) VALUES ($kd_dosen, '$nama', '$alamat')");
    }

    function delete_dosen($kd_dosen){
        return $this->koneksi->query("DELETE FROM tbl_dosen WHERE kd_dosen=$kd_dosen");
    }

    function update_dosen($kd_dosen, $nama, $alamat){
        return $this->koneksi->query("UPDATE tbl_dosen SET nama='$nama', alamat='$alamat' WHERE kd_dosen=$kd_dosen");
    }

    function get_jadwal(){
        return $this->koneksi->query("SELECT tbl_jadwal.id as id, tbl_jadwal.kd_dosen as kd_dosen, tbl_dosen.nama as nama_dosen, tbl_jadwal.kd_matkul as kd_matkul, tbl_matkul.nama as nama_matkul, tbl_jadwal.waktu as waktu, tbl_jadwal.ruang as ruang FROM tbl_jadwal JOIN tbl_dosen ON tbl_jadwal.kd_dosen = tbl_dosen.kd_dosen JOIN tbl_matkul ON tbl_jadwal.kd_matkul = tbl_matkul.kd_matkul");
    }

    function get_jadwal_by_id($id){
        return $this->koneksi->query("SELECT tbl_jadwal.id as id, tbl_jadwal.kd_dosen as kd_dosen, tbl_dosen.nama as nama_dosen, tbl_jadwal.kd_matkul as kd_matkul, tbl_matkul.nama as nama_matkul, tbl_jadwal.waktu as waktu, tbl_jadwal.ruang as ruang FROM tbl_jadwal JOIN tbl_dosen ON tbl_jadwal.kd_dosen = tbl_dosen.kd_dosen JOIN tbl_matkul ON tbl_jadwal.kd_matkul = tbl_matkul.kd_matkul WHERE tbl_jadwal.id=$id");
    }

    function add_jadwal($kd_dosen, $kd_matkul, $waktu, $ruang){
        $sql = "INSERT INTO tbl_jadwal (kd_dosen, kd_matkul, waktu, ruang) 
            VALUES ($kd_dosen, $kd_matkul, '$waktu', '$ruang')";
    
        
        //error_log($sql);  // cek di error_log server


        //echo "INSERT INTO tbl_jadwal (kd_dosen, kd_matkul, waktu, ruang) VALUES ($kd_dosen, $kd_matkul, '$waktu', '$ruang')";
        return $this->koneksi->query($sql);
    }

    function update_jadwal($id, $kd_dosen, $kd_matkul, $waktu, $ruang){
        return $this->koneksi->query("UPDATE tbl_jadwal SET kd_dosen=$kd_dosen, kd_matkul=$kd_matkul, waktu='$waktu', ruang='$ruang' WHERE id=$id");
    }

    function delete_jadwal($id){
        return $this->koneksi->query("DELETE FROM tbl_jadwal WHERE id=$id");

    }
    function get_matkul(){
        return $this->koneksi->query("SELECT * FROM tbl_matkul");
    }
    function get_krs(){
        $sql="SELECT 
        tbl_krs.id as id,
        tbl_krs.nim as nim,
        tbl_mahasiswa.nama as nama_mahasiswa,
        tbl_krs.id_jadwal as id_jadwal,
        tbl_dosen.nama as nama_dosen,
        tbl_matkul.nama as nama_matkul,
        tbl_jadwal.ruang as ruang,
        tbl_jadwal.waktu as waktu,
        tbl_krs.kd_semester as kd_semester,
        tbl_semester.semester as semester
        FROM tbl_krs 
        JOIN tbl_mahasiswa ON tbl_krs.nim = tbl_mahasiswa.nim
        JOIN tbl_semester ON tbl_krs.kd_semester = tbl_semester.kd_semester
        JOIN tbl_jadwal ON tbl_krs.id_jadwal = tbl_jadwal.id
        JOIN tbl_dosen ON tbl_jadwal.kd_dosen = tbl_dosen.kd_dosen
        JOIN tbl_matkul ON tbl_jadwal.kd_matkul = tbl_matkul.kd_matkul";

        return $this->koneksi->query($sql);
    }

    function get_krs_by_id($id){
        $sql="SELECT 
        tbl_krs.id as id,
        tbl_krs.nim as nim,
        tbl_mahasiswa.nama as nama_mahasiswa,
        tbl_krs.id_jadwal as id_jadwal,
        tbl_dosen.nama as nama_dosen,
        tbl_matkul.nama as nama_matkul,
        tbl_jadwal.ruang as ruang,
        tbl_jadwal.waktu as waktu,
        tbl_krs.kd_semester as kd_semester,
        tbl_semester.semester as semester
        FROM tbl_krs 
        JOIN tbl_mahasiswa ON tbl_krs.nim = tbl_mahasiswa.nim
        JOIN tbl_semester ON tbl_krs.kd_semester = tbl_semester.kd_semester
        JOIN tbl_jadwal ON tbl_krs.id_jadwal = tbl_jadwal.id
        JOIN tbl_dosen ON tbl_jadwal.kd_dosen = tbl_dosen.kd_dosen
        JOIN tbl_matkul ON tbl_jadwal.kd_matkul = tbl_matkul.kd_matkul
        WHERE tbl_krs.id=$id";

        return $this->koneksi->query($sql);
    }

    function add_krs($nim, $id_jadwal, $kd_semester){
        $sql = "INSERT INTO tbl_krs (nim, id_jadwal, kd_semester) 
            VALUES ($nim, $id_jadwal, $kd_semester)";
    
        
        //error_log($sql);  // cek di error_log server


        //echo "INSERT INTO tbl_jadwal (kd_dosen, kd_matkul, waktu, ruang) VALUES ($kd_dosen, $kd_matkul, '$waktu', '$ruang')";
        return $this->koneksi->query($sql);
    }


    function update_krs($id, $nim, $id_jadwal, $kd_semester){
        return $this->koneksi->query("UPDATE tbl_krs SET nim=$nim, id_jadwal=$id_jadwal, kd_semester=$kd_semester WHERE id=$id");

    }

    function delete_krs($id){
        return $this->koneksi->query("DELETE FROM tbl_krs WHERE id=$id");

    }
    function get_semester(){
        return $this->koneksi->query("SELECT * FROM tbl_semester");
    }





}

?>
