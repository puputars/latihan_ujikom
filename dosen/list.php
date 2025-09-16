<?php

include '../db.php';
$db = new db;
$list_dosen = $db->get_dosen();
?>



<div class="container-fluid">
    <h2 class="h3 mb-4 text-gray-800">Data Dosen</h2>
    <button class="btn btn-primary mb-3" onclick="loadForm()">Tambah Dosen</button><table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode dosen</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = $list_dosen->fetch_assoc()):?>
            <tr>
                <td><?= $row['kd_dosen']?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="loadForm('edit', '<?= $row['kd_dosen'] ?>')">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="if(confirm('Yakin ingin menghapus?')) loadForm('delete', '<?= $row['kd_dosen'] ?>')">Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>

            </tr>
        </tbody>

</div>



<script>
function loadForm(mode = 'add', kd_dosen = '') {
    $.ajax({
        url: 'dosen/form.php',
        type: 'get',
        data: {mode: mode, kd_dosen: kd_dosen},
        success: function(data) {
            $('#contentData').html(data);
        }
    });
}


function loadForm(mode, kd_dosen) {
    if (mode === 'delete') {
        if (confirm("Yakin ingin menghapus?")) {
            $.post('dosen/action.php', { mode: 'delete', kd_dosen: kd_dosen }, function(response) {
                if (response.status === 'success') {
                    loadDosen();
                } else {
                    alert('Gagal menghapus: ' + response.message);
                }
            }, 'json');
        }
    } else {
        $.get('dosen/form.php', { mode: mode, kd_dosen: kd_dosen }, function(data) {
            $('#contentData').html(data);
        });
    }
}

</script>