<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
if ($mode !== 'create' && $mode !== 'edit') {
  show_error("Mode tidak valid: harus 'create' atau 'edit'", 500);
}

if (!isset($relawan)) {
  $relawan = (object) [
    'nama' => '',
    'nik' => '',
    'alamat' => '',
    'jenis_kelamin' => '',
    'tanggal_lahir' => '',
    'komunitas' => '',
    'no_hp' => ''
  ];
}

// Variabel dinamis tergantung mode
switch ($mode) {
  case 'edit':
    $judul_halaman = 'Edit Relawan';
    $judul_form = 'Form Edit Relawan';
    $aksi = 'relawan/update/' . $relawan->nik;
    $label_tombol = 'Update';
    $readonly_nik = 'readonly';
    break;

  case 'create':
  default:
    $judul_halaman = 'Tambah Relawan';
    $judul_form = 'Form Tambah Relawan';
    $aksi = 'relawan/store';
    $label_tombol = 'Simpan';
    $readonly_nik = '';
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
          <a href="<?= site_url('relawan') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url($aksi) ?>">
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama"
                   value="<?= $relawan->nama ?>" required>
          </div>

          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" name="nik" id="nik"
                   value="<?= $relawan->nik ?>" <?= $readonly_nik ?> required>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" required><?= $relawan->alamat ?></textarea>
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="Laki-laki" <?= $relawan->jenis_kelamin === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
              <option value="Perempuan" <?= $relawan->jenis_kelamin === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                   value="<?= $relawan->tanggal_lahir ?>" required>
          </div>

          <div class="form-group">
            <label for="komunitas">Komunitas</label>
            <input type="text" class="form-control" name="komunitas" id="komunitas"
                   value="<?= $relawan->komunitas ?>" required>
          </div>

          <div class="form-group">
            <label for="no_hp">No HP</label>
            <input type="text" class="form-control" name="no_hp" id="no_hp"
                   value="<?= $relawan->no_hp ?>" required>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= $label_tombol ?></button>
          <a href="<?= site_url('relawan') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</section>
