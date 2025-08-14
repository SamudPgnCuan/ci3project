<section class="content-header">
  <div class="container-fluid">
    <h1>Edit Profil</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <?php if (validation_errors()): ?>
      <div class="alert alert-danger"><?= validation_errors() ?></div>
    <?php endif; ?>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Form Edit Profil</h3>
      </div>
      <form method="post" action="<?= site_url('profile/update') ?>">
        <div class="card-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8') ?>" readonly>
          </div>
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= set_value('nama', $user->nama) ?>" required>
          </div>
          <div class="form-group">
            <label>Password (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
          </div>
        </div>
        <div class="card-footer">
          <a href="<?= site_url('profile') ?>" class="btn btn-secondary">Batal</a>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>

  </div>
</section>
