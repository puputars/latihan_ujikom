<?php
include '../db.php';
$db = new db();

$mode = $_GET['mode'] ?? 'add';
$nim = $_GET['nim'] ?? '';
$data = ['nim'=>'', 'nama'=>'', 'alamat'=>'', 'jurusan'=>''];

//debugging
//echo "data nim $nim";

if ($mode == 'edit' && $nim!='' ) {
    $data = $db->get_mahasiswa_by_nim($nim)->fetch_assoc();
    //debugging 
    //print_r($data);
}
?>

<div class="container-fluid">
    <h2><?= $mode === 'edit' ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' ?></h2>
    <form action="mahasiswa/action.php" method="post">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        <?php if ($mode === 'edit'): ?>
            <input type="hidden" name="nim" value="<?= htmlspecialchars($data['nim']) ?>">
        <?php endif; ?>
        <div class="form-group">
            <label>NIM</label>
            <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($data['nim']) ?>" <?= $mode === 'edit' ? 'readonly' : '' ?> required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Jurusan</label>
            <input type="text" name="jurusan" class="form-control" value="<?= htmlspecialchars($data['jurusan']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success"><?= ucfirst($mode) ?></button>
        <button type="button" class="btn btn-secondary" onclick="loadMhs()">Batal</button>
    </form>
</div>


<script>
$('form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'mahasiswa/action.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                loadMhs(); // reload list
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Unexpected error: ' + error);
        }
    });
});
</script>
