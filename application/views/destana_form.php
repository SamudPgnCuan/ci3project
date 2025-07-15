<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
if ($mode !== 'create' && $mode !== 'edit') {
  show_error("Mode tidak valid: harus 'create' atau 'edit'", 500);
}

if (!isset($destana)) {
  $destana = (object) [
    'no' => '',
    'kecamatan' => '',
    'desa' => '',
    'koordinat' => '',
    'jenis_bencana' => ''
  ];
}

switch ($mode) {
  case 'edit':
    $judul_halaman = 'Edit Destana';
    $judul_form = 'Form Edit Destana';
    $aksi = 'destana/update/' . $destana->no;
    $label_tombol = 'Update';
    break;

  case 'create':
  default:
    $judul_halaman = 'Tambah Destana';
    $judul_form = 'Form Tambah Destana';
    $aksi = 'destana/store';
    $label_tombol = 'Simpan';
    break;
}
?>

<section class="content-header">
  <div class="container-fluid">
    <h1><?= $judul_halaman ?></h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= $judul_form ?></h3>
        <div class="card-tools">
          <a href="<?= site_url('destana') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url($aksi) ?>">
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <?php if ($mode === 'edit'): ?>
            <input type="hidden" name="no" value="<?= $destana->no ?>">
          <?php endif; ?>

          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" id="kecamatan"
                   value="<?= $destana->kecamatan ?>" required>
          </div>

          <div class="form-group">
            <label for="desa">Desa</label>
            <input type="text" class="form-control" name="desa" id="desa"
                   value="<?= $destana->desa ?>" required>
          </div>

          <div class="form-group">
            <label for="koordinat">Koordinat</label>
            <input type="text" class="form-control" name="koordinat" id="koordinat"
                  value="<?= $destana->koordinat ?>" placeholder="-7.123456, 110.123456" required>
          </div>

          <div class="form-group">
            <label for="jenis_bencana">Jenis Bencana</label>
            <select name="jenis_bencana[]" id="jenis_bencana" class="form-control" multiple required>
              <?php
                $opsi = [
                  'Abrasi', 'Banjir', 'Banjir Bandang', 'Gempa Bumi', 'Karhutla',
                  'Kebakaran', 'Kekeringan', 'Gunung Meletus', 'Puting Beliung',
                  'Tanah Longsor', 'Tsunami', 'Bencana Lain'
                ];
                $terpilih = isset($destana->jenis_bencana) ? explode(',', $destana->jenis_bencana) : [];

                foreach ($opsi as $bencana) {
                  $selected = in_array(trim($bencana), $terpilih) ? 'selected' : '';
                  echo "<option value=\"$bencana\" $selected>$bencana</option>";
                }
              ?>
            </select>
            <small class="form-text text-muted">Gunakan Ctrl / Cmd untuk memilih lebih dari satu</small>
          </div>


        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= $label_tombol ?></button>
          <a href="<?= site_url('destana') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</section>
