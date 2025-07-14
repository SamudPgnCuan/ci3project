<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!isset($mode)) $mode = 'create'; ?>
<?php if (!isset($relawan)) {
  $relawan = (object) [
    'nama' => '',
    'nik' => '',
    'alamat' => '',
    'jenis_kelamin' => '',
    'tanggal_lahir' => '',
    'komunitas' => '',
    'no_hp' => ''
  ];
} ?>

<section class="content-header">
  <div class="container-fluid">
    <h1><?= $mode === 'edit' ? 'Edit Relawan' : 'Tambah Relawan' ?></h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= $mode === 'edit' ? 'Form Edit Relawan' : 'Form Tambah Relawan' ?></h3>
        <div class="card-tools">
          <a href="<?= site_url('relawan') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url($mode === 'edit' ? 'relawan/update/' . $relawan->nik : 'relawan/store') ?>">
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama"
                   value="<?= isset($relawan) ? $relawan->nama : '' ?>" required>
          </div>

          <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" name="nik" id="nik"
                   value="<?= isset($relawan) ? $relawan->nik : '' ?>"
                   <?= $mode === 'edit' ? 'readonly' : '' ?> required>
          </div>

          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" required><?= isset($relawan) ? $relawan->alamat : '' ?></textarea>
          </div>

          <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="Laki-laki" <?= (isset($relawan) && $relawan->jenis_kelamin === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
              <option value="Perempuan" <?= (isset($relawan) && $relawan->jenis_kelamin === 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                   value="<?= isset($relawan) ? $relawan->tanggal_lahir : '' ?>" required>
          </div>

          <div class="form-group">
            <label for="komunitas">Komunitas</label>
            <input type="text" class="form-control" name="komunitas" id="komunitas"
                   value="<?= isset($relawan) ? $relawan->komunitas : '' ?>" required>
          </div>

          <div class="form-group">
            <label for="no_hp">No HP</label>
            <input type="text" class="form-control" name="no_hp" id="no_hp"
                   value="<?= isset($relawan) ? $relawan->no_hp : '' ?>" required>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= $mode === 'edit' ? 'Update' : 'Simpan' ?></button>
          <a href="<?= site_url('relawan') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</section>
