<section class="content-header">
  <div class="container-fluid">
    <h1>Profil Akun</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <p><strong>Username:</strong> <?= $username; ?></p>
        <p><strong>Role:</strong> <?= $role; ?></p>
        <a href="<?= site_url('logout'); ?>" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</section>
