<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
if (!isset($mode) || ($mode !== 'create' && $mode !== 'edit')) {
  show_error("Mode tidak valid: harus 'create' atau 'edit'", 500);
}
if (!isset($user)) {
  $user = (object)[
    'username' => '',
    'nama' => '',
    'password' => '',
    'role' => ''
  ];
}
?>

<section class="content-header">
  <div class="container-fluid">
    <h1>
      <?php switch ($mode):
        case 'edit': echo 'Edit User'; break;
        case 'create': echo 'Tambah User'; break;
      endswitch; ?>
    </h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <?php switch ($mode):
            case 'edit': echo 'Form Edit User'; break;
            case 'create': echo 'Form Tambah User'; break;
          endswitch; ?>
        </h3>
        <div class="card-tools">
          <a href="<?= site_url('user') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url($mode === 'edit' ? 'user/update/' . $user->username : 'user/store') ?>">
        <div class="card-body">
          <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username"
                   value="<?= $user->username ?>" <?= $mode === 'edit' ? 'readonly' : '' ?> required>
          </div>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" value="<?= $user->nama ?>" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password" id="password" value="<?= $user->password ?>" required>
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <input type="text" class="form-control" name="role" id="role" value="<?= $user->role ?>" required>
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
