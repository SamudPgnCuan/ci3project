<section class="content-header">
  <div class="container-fluid">
    <h1>Data User</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      
      <div class="card-header">
        <a href="<?= site_url('user/create') ?>" class="btn btn-primary">Tambah User</a>
        <div class="card-tools">
          <a href="<?= site_url() ?>" class="btn btn-secondary">← Kembali ke Beranda</a>
        </div>
      </div>

      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Username</th>
              <th>Nama</th>
              <th style="width: 240px;">Password</th>
              <th>Role</th>
              <th style="width: 140px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= $user->username ?></td>
                  <td><?= $user->nama ?></td>
                  <td style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="togglePassword('<?= $user->username ?>')">
                      <i class="fa fa-eye"></i>
                    </button>
                    <span class="masked-password" id="masked_<?= $user->username ?>">••••••••</span>
                    <span class="real-password d-none" id="real_<?= $user->username ?>"><?= $user->password ?></span>
                  </td>
                  <td><?= $user->role ?></td>
                  <td class="text-center">
                    <a href="<?= site_url('user/edit/' . $user->username) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('user/delete/' . $user->username) ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus user <?= $user->username ?>?')">
                       Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer d-flex justify-content-between">
        <!-- maybe put something here -->
      </div>
    </div>

  </div>
</section>

<script>
  function togglePassword(username) {
    const masked = document.getElementById('masked_' + username);
    const real = document.getElementById('real_' + username);

    if (real.classList.contains('d-none')) {
      real.classList.remove('d-none');
      masked.classList.add('d-none');
    } else {
      real.classList.add('d-none');
      masked.classList.remove('d-none');
    }
  }
</script>
