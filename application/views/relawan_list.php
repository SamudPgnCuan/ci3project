<section class="content-header">
  <div class="container-fluid">
    <h1>Data Relawan</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Tabel Relawan</h3>
        <div class="card-tools">
          <a href="<?= site_url('welcome') ?>" class="btn btn-secondary btn-sm">← Kembali ke Halaman Utama</a>
        </div>
      </div>

      <form id="relawanForm" method="post">
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center align-middle p-0" style="width: 50px;" >
                  <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
                </th>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Komunitas</th>
                <th>No HP</th>
                <th style="width: 90px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($relawan)): ?>
                <?php $no = 1; foreach ($relawan as $r): ?>
                  <tr>
                    <td class="text-center align-middle p-0">
                      <input type="checkbox" name="niks[]" value="<?= $r->nik ?>" style="transform: scale(1.2);">
                    </td>
                    <td><?= $no++ ?></td>
                    <td><?= $r->nama ?></td>
                    <td><?= $r->nik ?></td>
                    <td><?= $r->alamat ?></td>
                    <td><?= $r->jenis_kelamin ?></td>
                    <td><?= $r->tanggal_lahir ?></td>
                    <td><?= $r->komunitas ?></td>
                    <td><?= $r->no_hp ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('relawan/edit/' . $r->nik) ?>" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="10" class="text-center">Tidak ada data.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
          <?php if (!empty($relawan)): ?>
            <button type="submit" formaction="<?= site_url('relawan/delete_bulk') ?>" class="btn btn-danger" onclick="return confirm('Hapus data yang dipilih?')">
                <i class="fas fa-trash-alt"></i> Hapus (centang data terlebih dahulu)
            </button>
          <?php else: ?>
            <div></div>
          <?php endif; ?>

          <a href="<?= site_url('relawan/create') ?>" class="btn btn-primary">Tambah Relawan</a>
        </div>
      </form>
    </div>

  </div>
</section>

<script>
  document.getElementById('checkAll').addEventListener('change', function () {
    const checkboxes = document.querySelectorAll('input[name="niks[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
  });
</script>
