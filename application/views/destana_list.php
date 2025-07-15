<section class="content-header">
  <div class="container-fluid">
    <h1>Data Destana</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel Destana</h3>
        <div class="card-tools">
          <a href="<?= site_url('welcome') ?>" class="btn btn-secondary btn-sm">← Kembali ke Halaman Utama</a>
        </div>
      </div>

      <form method="post" action="<?= site_url('destana/delete_bulk') ?>">
        <div class="card-body p-0">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center align-middle p-0" style="width: 50px;">
                   <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
                </th>
                <th>No</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Koordinat</th>
                <th>Jenis Bencana</th>
                <th style="width: 80px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($destana)): ?>
                <?php $no = 1; foreach ($destana as $d): ?>
                  <tr>
                    <td class="text-center align-middle p-0">
                      <input type="checkbox" name="nos[]" value="<?= $d->no ?>" style="transform: scale(1.2);">
                    </td>
                    <td><?= $no++ ?></td>
                    <td><?= $d->kecamatan ?></td>
                    <td><?= $d->desa ?></td>
                    <td><?= $d->koordinat ?></td>
                    <td><?= str_replace(',', '<br>', $d->jenis_bencana) ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('destana/edit/' . $d->no) ?>" class="btn btn-warning btn-sm">Edit</a>
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
          <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data yang dipilih?')">
            <i class="fas fa-trash-alt"></i> Hapus (centang data terlebih dahulu)
          </button>
          <a href="<?= site_url('destana/create') ?>" class="btn btn-primary">Tambah Destana</a>
        </div>
      </form>
    </div>

  </div>
</section>

<script>
  const checkAll = document.getElementById('checkAll');
  const checkboxes = document.querySelectorAll('input[name="nos[]"]');

  // pilih semua
  checkAll.addEventListener('change', function () {
    checkboxes.forEach(cb => cb.checked = this.checked);
  });

  // salah satu uncheck
  checkboxes.forEach(cb => {
    cb.addEventListener('change', function () {
      if (!this.checked) {
        checkAll.checked = false;
      } else {
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkAll.checked = allChecked;
      }
    });
  });
</script>
