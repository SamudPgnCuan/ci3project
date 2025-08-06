<section class="content-header">
  <div class="container-fluid">
    <h1>Data User</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel User</h3>
        <div class="card-tools">
          <a href="<?= site_url() ?>" class="btn btn-secondary btn-sm">← Kembali ke Beranda</a>
        </div>
      </div>

      <form method="post" action="<?= site_url('user/delete_bulk') ?>">
        <div class="card-body p-0">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center" style="width: 50px;">
                  <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
                </th>
                <th>Username</th>
                <th>Nama</th>
                <th>Password</th>
                <th>Role</th>
                <th style="width: 80px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td class="text-center align-middle p-0">
                      <input type="checkbox" name="usernames[]" value="<?= $user->username ?>" style="transform: scale(1.2);">
                    </td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->nama ?></td>
                    <td>
                      <span class="masked-password" id="masked_<?= $user->username ?>">••••••••</span>
                      <span class="real-password d-none" id="real_<?= $user->username ?>"><?= $user->password ?></span>
                      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="togglePassword('<?= $user->username ?>')">
                        <i class="fa fa-eye"></i>
                      </button>
                    </td>
                    <td><?= $user->role ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('user/edit/' . $user->username) ?>" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
          <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data yang dipilih?')">
            <i class="fas fa-trash-alt"></i> Hapus (centang data terlebih dahulu)
          </button>
          <a href="<?= site_url('user/create') ?>" class="btn btn-primary">Tambah User</a>
        </div>
      </form>
    </div>

  </div>
</section>

<script>
  const checkAll = document.getElementById('checkAll');
  const checkboxes = document.querySelectorAll('input[name="usernames[]"]');

  checkAll.addEventListener('change', function () {
    checkboxes.forEach(cb => cb.checked = this.checked);
  });

  checkboxes.forEach(cb => {
    cb.addEventListener('change', function () {
      checkAll.checked = Array.from(checkboxes).every(cb => cb.checked);
    });
  });

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
