<section class="content-header">
  <div class="container-fluid">
    <h1>Data User</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel User</h3> <br />
        <div class="card-tools">
          <a href="<?= site_url() ?>" class="btn btn-secondary btn-sm">Kembali ke Beranda</a>
        </div>
      </div>

      <form id="userForm" method="post">
        <div class="card-body p-0">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center align-middle p-0" style="width: 50px;" >
                  <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
                </th>
                <th>Username</th>
                <th>Nama</th>
                <th>Password</th>
                <th>Role</th>
                <th style="width: 90px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td class="text-center align-middle p-0">
                      <input type="checkbox" name="user_ids[]" value="<?= $user->username ?>" style="transform: scale(1.2);">
                    </td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->nama ?></td>
                    <td><?= $user->password ?></td>
                    <td><?= $user->role ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('user/edit/' . $user->username) ?>" class="btn btn-sm btn-warning">Edit</a>
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
          <?php if (!empty($users)): ?>
            <button type="submit" formaction="<?= site_url('relawan/delete_bulk') ?>" class="btn btn-danger" onclick="return confirm('Hapus data yang dipilih?')">
                <i class="fas fa-trash-alt"></i> Hapus (centang data terlebih dahulu)
            </button>
          <?php else: ?>
            <div></div>
          <?php endif; ?>

          <a href="<?= site_url('user/create') ?>" class="btn btn-primary">Tambah User</a>
        </div>
      </form>
    </div>

  </div>
</section>

<script>
  document.getElementById('checkAll').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>
