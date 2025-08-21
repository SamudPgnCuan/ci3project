<section class="content-header">
  <div class="container-fluid">
    <h1>Data Bencana</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <a href="<?= site_url('bencana/create') ?>" class="btn btn-primary">Tambah Bencana</a>
        <div class="card-tools">
          <a href="<?= site_url('welcome') ?>" class="btn btn-secondary btn">← Kembali</a>
        </div>
      </div>

      <!-- Filter -->
      <div class="card-body">
        <form id="filterForm" method="get" action="<?= site_url('bencana'); ?>" class="p-3">
          <div class="row">

            <div class="col-md-4">
              <label for="filter_kecamatan">Kecamatan</label>
              <select name="kecamatan" id="filter_kecamatan" class="form-control select2" data-selected="<?= $this->input->get('kecamatan') ?>">
                <option value="">-- Semua Kecamatan --</option>
                <?php foreach ($kecamatan_list as $k): ?>
                  <option value="<?= $k->id_kecamatan ?>" <?= $this->input->get('kecamatan') == $k->id_kecamatan ? 'selected' : '' ?>>
                    <?= $k->nama_kecamatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="filter_desa">Desa</label>
              <select name="desa" id="filter_desa" class="form-control select2" data-selected="<?= $this->input->get('desa') ?>">
                <option value="">-- Semua Desa --</option>
              </select>
            </div>

            <div class="col-md-4">
              <label for="filter_ancaman">Jenis Ancaman</label>
              <select name="id_ancaman" id="filter_ancaman" class="form-control">
                <option value="">-- Semua Ancaman --</option>
                <?php foreach ($ancaman_list as $a): ?>
                  <option value="<?= $a->id_ancaman ?>" <?= $this->input->get('id_ancaman') == $a->id_ancaman ? 'selected' : '' ?>>
                    <?= $a->nama_ancaman ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label>Tanggal Mulai</label>
              <input type="date" name="tanggal_mulai" class="form-control" value="<?= $this->input->get('tanggal_mulai') ?>">
            </div>

            <div class="col-md-4">
              <label>Tanggal Selesai</label>
              <input type="date" name="tanggal_selesai" class="form-control" value="<?= $this->input->get('tanggal_selesai') ?>">
            </div>

            <div class="col-md-12 mt-3">
              <a href="<?= site_url('bencana'); ?>" class="btn btn-secondary">Reset Filter</a>
            </div>
          </div>
        </form>
      </div>

      <!-- Data Table -->
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Tanggal</th>
              <th>Kecamatan</th>
              <th>Desa</th>
              <th>Jenis Ancaman</th>
              <th>Jumlah Korban</th>
              <th>Pembuat</th>
              <th style="width: 140px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($bencana)): ?>
              <?php foreach ($bencana as $b): ?>
                <tr>
                  <td><?= $b['tanggal_bencana'] ?></td>
                  <td><?= $b['nama_kecamatan'] ?></td>
                  <td><?= $b['nama_desa'] ?></td>
                  <td><?= $b['nama_ancaman'] ?></td>
                  <td><?= $b['jumlah_korban'] ?></td>
                  <td><?= $b['nama_pembuat'] ?></td>
                  <td class="text-center">
                    <a href="<?= site_url('bencana/edit/' . $b['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('bencana/delete/' . $b['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
        <?php
        $total_pages = ceil($total / $limit);
        ?>
        <nav class="mt-3">
          <ul class="pagination">
            <?php for ($i = 0; $i < $total_pages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="<?= site_url('bencana/index/'.$i) ?>">
                  <?= $i+1 ?>
                </a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      </div>
    </div>

    <!-- Chart Sementara -->
    <div class="card mt-4">
      <div class="card-header">
        <h3 class="card-title">Grafik ngasal</h3>
      </div>
      <div class="card-body">
        <canvas id="chartTren"></canvas>
      </div>
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const base_url = '<?= base_url() ?>';

  // Contoh script chart sementara (dummy data)
  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartTren').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
          label: 'Jumlah Bencana',
          data: [5, 3, 8, 2],
          borderWidth: 2
        }]
      },
      options: { responsive: true }
    });
  });
</script>
