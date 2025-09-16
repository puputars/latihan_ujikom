<?php
include '../db.php';
$db = new db();

$mode = $_GET['mode'] ?? 'add';
$kd_dosen = $_GET['kd_dosen'] ?? '';
$data = ['kd_dosen'=>'','nama'=>'', 'alamat'=>''];

if ($mode === 'edit' && $kd_dosen !== '') {
    $data = $db->get_dosen_by_kd_dosen($kd_dosen)->fetch_assoc();
}

// --- persiapan variabel untuk form ---
$hiddenNim = '';
$readonly  = '';

if ($mode === 'edit') {
    $hiddenNim = '<input type="hidden" name="kd_dosen" value="' . htmlspecialchars($data['kd_dosen']) . '">';
    $readonly  = 'readonly';
}
?>

<div class="container-fluid">
    <h2><?= $mode === 'edit' ? 'Edit Dosen' : 'Tambah Dosen' ?></h2>
    <form action="dosen/action.php" method="post">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        <?= $hiddenNim ?>
        <div class="form-group">
            <label>kd_dosen</label>
            <input type="text" name="kd_dosen" class="form-control"
                   value="<?= htmlspecialchars($data['kd_dosen']) ?>"
                   <?= $readonly ?> required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control"
                   value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-success"><?= ucfirst($mode) ?></button>
        <button type="button" class="btn btn-secondary" onclick="loadDosen()">Batal</button>
    </form>
</div>

<script>
$('form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'dosen/action.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                loadDosen(); // reload list
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
