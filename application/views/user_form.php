<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
if ($mode !== 'create' && $mode !== 'edit') {
    show_error("Mode tidak valid: harus 'create' atau 'edit'", 500);
}

if (!isset($user)) {
    $user = (object) [
        'username' => '',
        'nama' => '',
        'password' => '',
        'role' => '',
    ];
}

switch ($mode) {
    case 'edit':
        $judul_halaman = 'Edit User';
        $judul_form = 'Form Edit User';
        $aksi = 'user/update/' . $user->username;
        $label_tombol = 'Update';
        break;

    case 'create':
    default:
        $judul_halaman = 'Tambah User';
        $judul_form = 'Form Tambah User';
        $aksi = 'user/store';
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
    <form action="<?= site_url($aksi) ?>" method="post">
      <div class="card card-dark">
        <div class="card-header"><h3 class="card-title"><?= $judul_form ?></h3></div>
        <div class="card-body">

          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" value="<?= set_value('username', $user->username) ?>" <?= $mode === 'edit' ? 'readonly' : '' ?> required>
          </div>

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" value="<?= set_value('nama', $user->nama) ?>" required>
          </div>

          <div class="form-group">
            <label for="password">Password <?= $mode === 'edit' ? '(biarkan kosong jika tidak ingin diubah)' : '' ?></label>
            <input type="password" name="password" class="form-control" id="password" minlength="8" <?= $mode === 'create' ? 'required' : '' ?>>
            <div class="form-check mt-1">
              <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()" style="transform: scale(1.2); transform-origin: left;">
              <label class="form-check-label" for="showPassword">Tampilkan Password</label>
            </div>
          </div>

          <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" id="role" required>
              <option value="">-- Pilih Role --</option>
              <option value="admin" <?= set_value('role', $user->role) === 'admin' ? 'selected' : '' ?>>Admin</option>
              <option value="petugas" <?= set_value('role', $user->role) === 'petugas' ? 'selected' : '' ?>>Petugas</option>
            </select>
          </div>

        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= $label_tombol ?></button>
          <a href="<?= site_url('user') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </div>
    </form>
  </div>
</section>

<script>
function togglePassword() {
  const pwInput = document.getElementById("password");
  pwInput.type = pwInput.type === "password" ? "text" : "password";
}
</script>
