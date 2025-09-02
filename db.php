<?php

class db {
    private $koneksi;

    function __construct() {
        $this->koneksi = new mysqli("127.0.0.1", "root", "rootpassword", "db_pelatihan");
    }

    function get_user($username, $password) {
        $data = $this->koneksi->query("select * from tbl_user where username='$username' and password='$password'");
        return $data;
    }
}

?>
