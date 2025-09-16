<?php
include '../db.php';
$db = new db();

$mode = $_GET['mode'] ?? 'add';
$id = $_GET['id'] ?? '';
$data = ['id'=>'-', 'kd_dosen'=>'', 'nama_dosen'=>'', 'kd_matkul'=>'', 'nama_matkul', 'waktu'=>'', 'ruang'=>''];

if ($mode === 'edit' && $id !== '') {
    $data = $db->get_jadwal_by_id($id)->fetch_assoc();
}

$dosenList= $db->get_dosen();

$matkulList= $db->get_matkul();
// --- persiapan variabel untuk form ---
$hiddenNim = '';
$readonly  = '';

if ($mode === 'edit') {
    $hiddenNim = '<input type="hidden" name="id" value="' . htmlspecialchars($data['id']) . '">';
}
?>

<div class="container-fluid">
    <h2><?= $mode === 'edit' ? 'Edit Dosen' : 'Tambah Dosen' ?></h2>
    <form action="dosen/action.php" method="post">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        <?= $hiddenNim ?>
        <div class="form-group">
            <label>id</label>
            <input type="text" name="id" class="form-control"
                   value="<?= htmlspecialchars($data['id']) ?>"
                   readonly required>
        </div>
        <div class="form-group">
            <label>Kode Dosen - Nama Dosen</label>
            <select name="kd_dosen" class="form-control" required>
                <option value="">---Pilih Dosen---</option>
                <?php while ($dosen= $dosenList->fetch_assoc()):?>
                    <?php
                     $selected = ($dosen['kd_dosen'] == $data['kd_dosen'])?'selected':'';
                     $label = $dosen['kd_dosen'] . ' - ' . $dosen['nama'];
                    ?>
                <option value="<?=htmlspecialchars($dosen['kd_dosen'])?>"<?=$selected?>>
                    <?=htmlspecialchars($label)?>
                    </option>   
                <?php endwhile;?>
            </select>
        </div>
        <div class="form-group">
            <label>Kode Matkul - Nama Matkul</label>
            <select name="kd_matkul" class="form-control" required>
                <option value="">---Pilih Matkul---</option>
                <?php while ($matkul= $matkulList->fetch_assoc()):?>
                    <?php
                     $selected = ($matkul['kd_matkul'] == $data['kd_matkul'])?'selected':'';
                     $label = $matkul['kd_matkul'] . ' - ' . $matkul['nama'];
                    ?>
                <option value="<?=htmlspecialchars($matkul['kd_matkul'])?>"<?=$selected?>>
                    <?=htmlspecialchars($label)?>
                    </option>   
                <?php endwhile;?>
            </select>
        </div>

        <div class="form-group">
            <label>Waktu</label>
            <input type="text" name="waktu" class="form-control" placeholder="19.00 - 20.00 WIB"
                   value="<?= htmlspecialchars($data['waktu']) ?>" required>
        </div>
        <div class="form-group">
            <label>Ruang</label>
            <input type="text" name="ruang" class="form-control" placeholder="V.601"
                   value="<?= htmlspecialchars($data['ruang']) ?>" required>
        </div>
        
        <button type="submit" class="btn btn-success"><?= ucfirst($mode) ?></button>
        <button type="button" class="btn btn-secondary" onclick="loadJadwal()">Batal</button>
    </form>
</div>

<script>
$('form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'jadwal/action.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                loadJadwal(); // reload list
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
