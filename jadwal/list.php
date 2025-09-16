<?php

include '../db.php';
$db = new db;
$list_jadwal = $db->get_jadwal();
?>


<div class="container-fluid">
    <h2 class="h3 mb-4 text-gray-800">Data Jadwal</h2>
    <button class="btn btn-primary mb-3" onclick="loadForm()">Tambah Jadwal</button><table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Dosen</th>
                <th>Nama Dosen</th>
                <th>Kode Matkul</th>
                <th>Nama Matkul</th>
                <th>Waktu</th>
                <th>Ruang</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $list_jadwal->fetch_assoc()):?>
            <tr>
                <td><?= $row['id']?></td>
                <td><?= $row['kd_dosen']?></td>
                <td><?= $row['nama_dosen'] ?></td>
                <td><?= $row['kd_matkul'] ?></td>
                <td><?= $row['nama_matkul'] ?></td>
                <td><?= $row['waktu'] ?></td>
                <td><?= $row['ruang'] ?></td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="loadForm('edit', '<?= $row['id'] ?>')">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="if(confirm('Yakin ingin menghapus?')) loadForm('delete', '<?= $row['id'] ?>')">Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>

            </tr>
        </tbody>

</div>


<script>
function loadForm(mode = 'add', id = '') {
    $.ajax({
        url: 'jadwal/form.php',
        type: 'get',
        data: {mode: mode, id: id},
        success: function(data) {
            $('#contentData').html(data);
        }
    });
}


function loadForm(mode, id) {
    if (mode === 'delete') {
        if (confirm("Yakin ingin menghapus?")) {
            $.post('jadwal/action.php', { mode: 'delete', id: id }, function(response) {
                if (response.status === 'success') {
                    loadJadwal();
                } else {
                    alert('Gagal menghapus: ' + response.message);
                }
            }, 'json');
        }
    } else {
        $.get('jadwal/form.php', { mode: mode, id: id }, function(data) {
            $('#contentData').html(data);
        });
    }
}

</script>