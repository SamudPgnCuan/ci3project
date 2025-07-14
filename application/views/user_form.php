<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
  <div class="container-fluid">
    <h1><?= $mode === 'edit' ? 'Edit User' : 'Tambah User' ?></h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= $mode === 'edit' ? 'Form Edit User' : 'Form Tambah User' ?></h3>
        <div class="card-tools">
          <a href="<?= site_url('user') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url($mode === 'edit' ? 'user/update/' . $user->username : 'user/store') ?>">
        <div class="card-body">

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username"
                   value="<?= isset($user) ? $user->username : '' ?>"
                   <?= $mode === 'edit' ? 'readonly' : '' ?> required>
          </div>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama"
                   value="<?= isset($user) ? $user->nama : '' ?>" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password" id="password"
                   value="<?= isset($user) ? $user->password : '' ?>" required>
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <input type="text" class="form-control" name="role" id="role"
                   value="<?= isset($user) ? $user->role : '' ?>" required>
          </div>

        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= $mode === 'edit' ? 'Update' : 'Simpan' ?></button>
          <a href="<?= site_url('user') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>

  </div>
</section>
