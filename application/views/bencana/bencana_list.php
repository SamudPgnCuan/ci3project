<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Data Bencana</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
  <style>
    .filter-group .form-control { min-width: 180px; }
  </style>
</head>
<body class="p-3">
<div class="container-fluid">

  <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $this->session->flashdata('success'); ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Bencana</h3>
    <a href="<?= site_url('bencana/create'); ?>" class="btn btn-primary">+ Tambah Laporan</a>
  </div>

  <!-- Filter -->
  <form class="mb-3" method="get">
    <div class="form-row filter-group">
      <div class="col-auto">
        <label>Kecamatan</label>
        <select name="id_kecamatan" id="filter_kecamatan" class="form-control">
          <option value="">-- Semua --</option>
          <?php foreach($kecamatan as $k): ?>
            <option value="<?= $k->id_kecamatan ?>" <?= ($filters['id_kecamatan']==$k->id_kecamatan?'selected':'') ?>>
              <?= $k->nama_kecamatan ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto">
        <label>Desa</label>
        <select name="id_desa" id="filter_desa" class="form-control">
          <option value="">-- Semua --</option>
          <!-- akan diisi via AJAX saat kecamatan dipilih -->
        </select>
      </div>
      <div class="col-auto">
        <label>Jenis Bencana</label>
        <select name="id_ancaman" class="form-control">
          <option value="">-- Semua --</option>
          <?php foreach($ancaman as $a): ?>
            <option value="<?= $a->id_ancaman ?>" <?= ($filters['id_ancaman']==$a->id_ancaman?'selected':'') ?>>
              <?= $a->nama_ancaman ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto">
        <label>Dari Tanggal</label>
        <input type="date" name="tanggal_mulai" value="<?= html_escape($filters['tanggal_mulai']) ?>" class="form-control">
      </div>
      <div class="col-auto">
        <label>Sampai Tanggal</label>
        <input type="date" name="tanggal_selesai" value="<?= html_escape($filters['tanggal_selesai']) ?>" class="form-control">
      </div>
      <div class="col-auto align-self-end">
        <button class="btn btn-secondary">Terapkan</button>
      </div>
    </div>
  </form>

  <div class="card mb-4">
    <div class="card-body table-responsive">
      <table id="tbl-bencana" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Tanggal Kejadian</th>
            <th>Kecamatan</th>
            <th>Desa</th>
            <th>Jenis</th>
            <th>Korban</th>
            <th>Dibuat</th>
            <th>Dibuat Pada</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $r): ?>
            <tr>
              <td><?= date('Y-m-d H:i', strtotime($r->tanggal_bencana)) ?></td>
              <td><?= $r->nama_kecamatan ?></td>
              <td><?= $r->nama_desa ?></td>
              <td><?= $r->nama_ancaman ?: '-' ?></td>
              <td><?= (int)$r->jumlah_korban ?></td>
              <td><?= $r->nama_pembuat ?></td>
              <td><?= date('Y-m-d H:i', strtotime($r->created_at)) ?></td>
              <td>
                <a href="<?= site_url('bencana/edit/'.$r->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= site_url('bencana/delete/'.$r->id) ?>" class="btn btn-sm btn-danger"
                   onclick="return confirm('Hapus laporan ini?')">Hapus</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Grafik -->
  <div class="row">
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">Tren Kejadian per Bulan</div>
        <div class="card-body">
          <canvas id="chartTren"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">Total Korban per Kecamatan</div>
        <div class="card-body">
          <canvas id="chartKorban"></canvas>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
$(function(){
  $('#tbl-bencana').DataTable({
    pageLength: 10,
    order: [[0,'desc']]
  });

  // preload desa filter ketika page terbuka (jika kecamatan sudah dipilih)
  const selectedDesa = "<?= (int)$filters['id_desa'] ?>";
  const selectedKec  = "<?= (int)$filters['id_kecamatan'] ?>";
  if (selectedKec) {
    loadDesaFilter(selectedKec, selectedDesa);
  }
  $('#filter_kecamatan').on('change', function() {
    loadDesaFilter(this.value, "");
  });
  function loadDesaFilter(id_kecamatan, selected) {
    $('#filter_desa').html('<option>Memuat...</option>');
    $.get('<?= site_url('bencana/ajax_destana_options') ?>', {id_kecamatan}, function(html){
      // html berisi <option value="id_destana">Desa (Kec)</option>
      // tapi untuk filter kita perlu id_desa, maka alternatif:
      // Ubah endpoint jika mau, atau gunakan endpoint lain khusus filter.
      // Simpel-nya: kita isi dropdown dengan <option data-id-desa ...> lalu abaikan 'name'
      $('#filter_desa').html('<option value="">-- Semua --</option>');
      // Karena endpoint mengembalikan id_destana, untuk filter by desa (id_desa)
      // kamu bisa membuat endpoint khusus. Untuk sekarang biarkan kosong
      // ATAU sesuaikan model->list agar juga menerima id_destana.
      // (Jika ingin cepat: ganti name="id_desa" jadi name="id_destana_filter" dan handle di controller)
    });
  }

  // CHARTS
  fetch('<?= site_url('bencana/chart_tren') ?>')
    .then(r=>r.json())
    .then(json=>{
      new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
          labels: json.labels,
          datasets: [{ label: 'Kejadian', data: json.data }]
        }
      });
    });

  fetch('<?= site_url('bencana/chart_korban_per_kecamatan') ?>')
    .then(r=>r.json())
    .then(json=>{
      new Chart(document.getElementById('chartKorban'), {
        type: 'bar',
        data: {
          labels: json.labels,
          datasets: [{ label: 'Total Korban', data: json.data }]
        }
      });
    });
});
</script>
</body>
</html>
