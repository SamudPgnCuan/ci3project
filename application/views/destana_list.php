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

      <form id="destanaForm" method="post">
        <div class="card-body p-0">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center align-middle p-0" style="width: 50px;">
                  <input type="checkbox" id="checkAll" style="transform: scale(1.2);" ></th>
                <th>Nomor</th>
                <th>Kecamatan</th>
                <th>Desa</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($destana)): ?>
                <?php foreach ($destana as $d): ?>
                  <tr>
                    <td class="text-center align-middle p-0"><input type="checkbox" name="desa_ids[]" value="<?= $d->desa ?>" style="transform: scale(1.2);"></td>
                    <td><?= $d->no ?></td>
                    <td><?= $d->kecamatan ?></td>
                    <td><?= $d->desa ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="3" class="text-center">Tidak ada data.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
          <a href="<?= site_url('destana/create') ?>" class="btn btn-primary">Tambah Destana</a>
          <?php if (!empty($destana)): ?>
            <div>
              <button type="button" id="editButton" class="btn btn-warning">Edit</button>
              <button type="submit" formaction="<?= site_url('relawan/delete_bulk') ?>" class="btn btn-danger" onclick="return confirm('Hapus data yang dipilih?')">
                <i class="fas fa-trash-alt"></i> Hapus (centang data terlebih dahulu)
            </button>
            </div>
          <?php endif; ?>
        </div>
      </form>
    </div>

  </div>
</section>

<!-- Script: Validasi checkbox untuk Edit -->
<script>
  document.getElementById('editButton').addEventListener('click', function () {
    const checked = document.querySelectorAll('input[name="desa_ids[]"]:checked');
    if (checked.length === 0) {
      alert('Silakan pilih satu data untuk diedit.');
    } else if (checked.length > 1) {
      alert('Hanya boleh memilih satu data untuk diedit.');
    } else {
      const no = checked[0].value;
      window.location.href = '<?= site_url("destana/edit/") ?>' + no;
    }
  });

  document.getElementById('checkAll').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="desa_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>
