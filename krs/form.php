<?php
include '../db.php';
$db = new db();

$mode = $_GET['mode'] ?? 'add';
$id = $_GET['id'] ?? '';
$data = ['id'=>'-'];

if ($mode === 'edit' && $id !== '') {
    $data = $db->get_krs_by_id($id)->fetch_assoc();
}

$jadwalList= $db->get_jadwal();
$mahasiswaList = $db->get_mahasiswa();
$semesterList = $db->get_semester();
// --- persiapan variabel untuk form ---
$hiddenId = '';
$readonly  = '';

if ($mode === 'edit') {
    $hiddenId = '<input type="hidden" name="id" value="' . htmlspecialchars($data['id']) . '">';
}
?>

<div class="container-fluid">
    <h2><?= $mode === 'edit' ? 'Edit KRS' : 'Tambah KRS' ?></h2>
    <form action="dosen/action.php" method="post">
        <input type="hidden" name="mode" value="<?= $mode ?>">
        <?= $hiddenId ?>
        <div class="form-group">
            <label>id</label>
            <input type="text" name="id" class="form-control"
                   value="<?= htmlspecialchars($data['id']) ?>"
                   readonly required>
        </div>

         <div class="form-group">
            <label>NIM - Nama Mahasiswa</label>
            <select name="nim" class="form-control" required>
                <option value="">---Pilih Mahasiswa---</option>
                <?php while ($mahasiswa= $mahasiswaList->fetch_assoc()):?>
                    <?php
                     $selected = ($mahasiswa['nim'] == $data['nim'])?'selected':'';
                     $label = $mahasiswa['nim'] . ' - ' . $mahasiswa['nama'];
                    ?>
                <option value="<?=htmlspecialchars($mahasiswa['nim'])?>"<?=$selected?>>
                    <?=htmlspecialchars($label)?>
                    </option>   
                <?php endwhile;?>
            </select>
        </div>

        
        <div class="form-group">
            <label>Jadwal</label>
            <select name="id_jadwal" class="form-control" required>
                <option value="">---Pilih Jadwal---</option>
                <?php while ($jadwal= $jadwalList->fetch_assoc()):?>
                    <?php
                     $selected = ($jadwal['id'] == $data['id_jadwal'])?'selected':'';
                     $label = $jadwal['id'] . ' - ' . $jadwal['nama_dosen'] . ' - ' . $jadwal['nama_matkul'] . ' - ' . $jadwal['waktu'] . ' - ' . $jadwal['ruang'];
                    ?>
                <option value="<?=htmlspecialchars($jadwal['id'])?>"<?=$selected?>>
                    <?=htmlspecialchars($label)?>
                    </option>   
                <?php endwhile;?>
            </select>
        </div>
       
        <div class="form-group">
            <label>Kode Semester - Semester</label>
            <select name="kd_semester" class="form-control" required>
                <option value="">---Pilih Semester---</option>
                <?php while ($semester= $semesterList->fetch_assoc()):?>
                    <?php
                     $selected = ($semester['kd_semester'] == $data['kd_semester'])?'selected':'';
                     $label = $semester['kd_semester'] . ' - ' . $semester['semester'];
                    ?>
                <option value="<?=htmlspecialchars($semester['kd_semester'])?>"<?=$selected?>>
                    <?=htmlspecialchars($label)?>
                    </option>   
                <?php endwhile;?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success"><?= ucfirst($mode) ?></button>
        <button type="button" class="btn btn-secondary" onclick="loadKRS()">Batal</button>
    </form>
</div>

<script>
$('form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'krs/action.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                loadKRS(); // reload list
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
