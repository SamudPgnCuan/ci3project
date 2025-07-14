<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
  <div class="container-fluid">
    <h1><?= isset($destana) ? 'Edit Destana' : 'Tambah Destana' ?></h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= isset($destana) ? 'Form Edit Destana' : 'Form Tambah Destana' ?></h3>
        <div class="card-tools">
          <a href="<?= site_url('destana') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url(isset($destana) && isset($destana->no) ? 'destana/update/' . $destana->no : 'destana/store') ?>">
        <div class="card-body">

          <?php if (isset($destana) && isset($destana->no)): ?>
            <input type="hidden" name="no" value="<?= $destana->no ?>">
          <?php endif; ?>

          <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" id="kecamatan"
                   value="<?= isset($destana) ? $destana->kecamatan : '' ?>" required>
          </div>

          <div class="form-group">
            <label for="desa">Desa</label>
            <input type="text" class="form-control" name="desa" id="desa"
                   value="<?= isset($destana) ? $destana->desa : '' ?>" required>
          </div>

        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= isset($destana) ? 'Update' : 'Simpan' ?></button>
          <a href="<?= site_url('destana') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>

  </div>
</section>
