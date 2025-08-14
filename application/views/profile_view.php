<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <h1>Profil Saya</h1>
  </div>
</section>

<!-- Main Content -->
<section class="content">
  <div class="container-fluid">
    
    <div class="card card-primary ">
      <div class="card-body box-profile">

        <div class="text-center mb-3">
          <i class="fas fa-user-circle fa-5x text-primary"></i>
        </div>

        <h3 class="profile-username text-center">
          <?= htmlspecialchars($user->nama ?? 'Tidak Diketahui', ENT_QUOTES, 'UTF-8') ?>
        </h3>

        <p class="text-muted text-center">
          <?= ucfirst($user->role ?? 'Tidak Ada Role') ?>
        </p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Username</b>
            <span class="float-right"><?= htmlspecialchars($user->username ?? '-', ENT_QUOTES, 'UTF-8') ?></span>
          </li>
          <li class="list-group-item">
            <b>Nama</b>
            <span class="float-right"><?= htmlspecialchars($user->nama ?? '-', ENT_QUOTES, 'UTF-8') ?></span>
          </li>
          <li class="list-group-item">
            <b>Role</b>
            <span class="float-right"><?= ucfirst($user->role ?? '-') ?></span>
          </li>
        </ul>

        <div class="text-center">
          <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
          <a href="<?= site_url('profile/edit') ?>" class="btn btn-primary ml-2">
            <i class="fas fa-edit"></i> Edit Profil
          </a>
        </div>

      </div>
    </div>

  </div>
</section>
