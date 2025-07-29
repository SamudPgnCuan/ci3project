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
    'tempat_lahir' => '',
    'tanggal_lahir' => '',
    'komunitas' => '',
    'id_kecamatan' => '',
    'id_desa' => '',
    'pekerjaan' => '',
    'no_hp' => ''
  ];
}

switch ($mode) {
  case 'edit':
    $judul_halaman = 'Edit Relawan';
    $judul_form = 'Form Edit Relawan';
    $aksi = 'relawan/update/' . $relawan->id;
    $label_tombol = 'Update';
    break;

  case 'create':
  default:
    $judul_halaman = 'Tambah Relawan';
    $judul_form = 'Form Tambah Relawan';
    $aksi = 'relawan/store';
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
              value="<?= $relawan->nik ?>" required 
              pattern="\d{16}" maxlength="16" inputmode="numeric"
              title="NIK harus terdiri dari 16 digit angka ;) ">
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" required><?= $relawan->alamat ?></textarea>
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="L" <?= $relawan->jenis_kelamin === 'L' ? 'selected' : '' ?>>Laki-laki</option>
              <option value="P" <?= $relawan->jenis_kelamin === 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="tempat_lahir">Tempat Lahir</label>
            <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                   value="<?= $relawan->tempat_lahir ?>" required>
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
            <label for="kecamatan">Kecamatan</label>
            <select name="kecamatan" class="form-control" id="id_kecamatan" required>
              <option value="">-- Pilih Kecamatan --</option>
              <?php foreach ($kecamatan_list as $k): ?>
                <option 
                value="<?= $k->id_kecamatan ?>" 
                <?= $relawan->id_kecamatan == $k->id_kecamatan ? 'selected' : '' ?>>
                <?= $k->nama_kecamatan ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="id_desa">Desa</label>
            <select name="id_desa" class="form-control" id="id_desa" required>
              <option value="">-- Pilih Desa --</option>
              <?php foreach ($desa_list as $d): ?>
                <option value="<?= $d->id_desa ?>" <?= $relawan->id_desa == $d->id_desa ? 'selected' : '' ?>>
                  <?= $d->nama_desa ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="pekerjaan">Pekerjaan</label>
            <input type="text" class="form-control" name="pekerjaan" id="pekerjaan"
              value="<?= $relawan->pekerjaan ?>" required>
          </div>

          <div class="form-group">
            <label for="no_hp">No HP</label>
            <input type="text" class="form-control" name="no_hp" id="no_hp"
                  value="<?= $relawan->no_hp ?>" required
                  pattern="\d+" inputmode="numeric"
                  title="No HP hanya boleh berisi angka saja :D">
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
