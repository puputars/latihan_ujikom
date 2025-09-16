<?php

include '../db.php';
$db = new db;
$list_mahasiswa = $db->get_mahasiswa();
?>

<div class="container-fluid">
    <h2 class="h3 mb-4 text-gray-800">Data Mahasiswa</h2>
    <button class="btn btn-primary mb-3" onclick="loadForm()">Tambah Mahasiswa</button><table class="table table-bordered">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $list_mahasiswa->fetch_assoc()):?>
            <tr>
                <td><?= $row['nim']?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['jurusan'] ?></td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="loadForm('edit', '<?= $row['nim'] ?>')">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="if(confirm('Yakin ingin menghapus?')) loadForm('delete', '<?= $row['nim'] ?>')">Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>

            </tr>
        </tbody>

</div>

<script>
function loadForm(mode = 'add', nim = '') {
    $.ajax({
        url: 'mahasiswa/form.php',
        type: 'get',
        data: {mode: mode, nim: nim},
        success: function(data) {
            $('#contentData').html(data);
        }
    });
}


function loadForm(mode, nim) {
    if (mode === 'delete') {
        if (confirm("Yakin ingin menghapus?")) {
            $.post('mahasiswa/action.php', { mode: 'delete', nim: nim }, function(response) {
                if (response.status === 'success') {
                    loadMhs();
                } else {
                    alert('Gagal menghapus: ' + response.message);
                }
            }, 'json');
        }
    } else {
        $.get('mahasiswa/form.php', { mode: mode, nim: nim }, function(data) {
            $('#contentData').html(data);
        });
    }
}

</script>