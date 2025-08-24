<section class="content-header">
  <div class="container-fluid">
    <h1>Data Destana</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <a href="<?= site_url('destana/create') ?>" class="btn btn-primary">Tambah Destana</a>
        <div class="card-tools">
          <a href="<?= site_url('welcome') ?>" class="btn btn-secondary btn">← Kembali ke Halaman Utama</a>
        </div>
      </div>

      <!-- filter -->
      <div class="card-body">

        <form id="filterForm" method="get" action="<?= site_url('destana'); ?>" class="p-3">
          <div class="row">

            <div class="col-md-4">
              <label for="filter_kecamatan">Kecamatan</label>
              <select name="kecamatan" id="filter_kecamatan" class="form-control select2" data-selected="<?= $this->input->get('kecamatan') ?>">
                <option value="">-- Semua Kecamatan --</option>
                <?php foreach ($kecamatan_list as $k): ?>
                  <option
                   value="<?= $k->id_kecamatan ?>"
                   <?= ($this->input->get('kecamatan') == $k->id_kecamatan ) ? 'selected' : '' ?>> 
                   <?= $k->nama_kecamatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="filter_desa">Desa</label>
              <select name="desa" id="filter_desa" class="form-control select2" data-selected="<?= $this->input->get('desa') ?>">
                <option value="">-- Semua Desa --</option>
                <!-- dari javascript? -->
              </select>
            </div>

            <div class="col-md-4">
              <label>Tahun Pembentukan</label>
              <select name="tahun" id="filter_tahun" class="form-control">
                <option value="">-- Semua Tahun --</option>
                <?php
                  $tahun_input = $this->input->get('tahun');
                  $tahun_sekarang = date('Y');
                  for ($t = 2010; $t <= $tahun_sekarang; $t++):
                ?>
                  <option value="<?= $t ?>" <?= $tahun_input == $t ? 'selected' : '' ?>><?= $t ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label>Kelas</label>
              <select name="id_kelas" id="filter_kelas" class="form-control">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($kelas_list as $row): ?>
                  <option value="<?= $row->id_kelas ?>" <?= set_select('id_kelas', $this->input->get('id_kelas'), $this->input->get('id_kelas') == $row->id_kelas) ?>>
                    <?= $row->nama_kelas ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label>Sumber Dana</label>
              <select name="id_sumber_dana" id="filter_sumber" class="form-control">
                <option value="">-- Semua Sumber Dana --</option>
                <?php foreach ($sumber_dana_list as $row): ?>
                  <option value="<?= $row->id_sumber_dana ?>" <?= set_select('id_sumber_dana', $this->input->get('id_sumber_dana'), $this->input->get('id_sumber_dana') == $row->id_sumber_dana) ?>>
                    <?= $row->nama_sumber_dana ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label>Jenis Ancaman</label>
              <select name="id_ancaman" id="filter_ancaman" class="form-control">
                <option value="">-- Semua Ancaman --</option>
                <?php foreach ($ancaman_list as $row): ?>
                  <option value="<?= $row->id_ancaman ?>" <?= set_select('id_ancaman', $this->input->get('id_ancaman'), $this->input->get('id_ancaman') == $row->id_ancaman) ?>>
                    <?= $row->nama_ancaman ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-12 mt-3">
              <a href="<?= site_url('destana'); ?>" class="btn btn-secondary">Reset Filter</a>
            </div>

          </div>
        </form>
      </div>

      <!-- Data Table -->
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Kecamatan</th>
              <th>Desa</th>
              <th>Tahun Pembentukan</th>
              <th>Kelas</th>
              <th>Sumber Dana</th>
              <th>Jenis Bencana</th>
              <th style="width: 140px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($destana)): ?>
              <?php foreach ($destana as $d): ?>
                <tr>
                  <td><?= $d['nama_kecamatan'] ?></td>
                  <td><?= $d['nama_desa'] ?></td>
                  <td><?= $d['tahun_pembentukan'] ?></td>
                  <td><?= $d['nama_kelas'] ?></td>
                  <td><?= $d['nama_sumber_dana'] ?></td>
                  <td>
                    <?= !empty($d['ancaman']) ? implode('<br>', $d['ancaman']) : '-' ?>
                  </td>
                  <td class="text-center">
                    <button type="button" 
                        class="btn btn-info btn-sm btn-bencana" 
                        data-id="<?= $d['id'] ?>" 
                        data-desa="<?= $d['nama_desa'] ?>" 
                        data-toggle="modal" 
                        data-target="#bencanaModal">
                      Lihat Bencana
                    </button>
                    <a href="<?= site_url('destana/edit/' . $d['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= site_url('destana/delete/' . $d['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Modal Bencana -->
        <div class="modal fade" id="bencanaModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Riwayat Bencana di <span id="modalNamaDesa"></span></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              </div>
              <div class="modal-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Tanggal</th>
                      <th>Ancaman</th>
                    </tr>
                  </thead>
                  <tbody id="bencanaTableBody">
                    <tr><td colspan="3" class="text-center">Memuat data...</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

<script>
  const base_url = '<?= base_url() ?>';
</script>

<script> //buat modal
document.addEventListener('DOMContentLoaded', function () {
  // Saat tombol "Lihat Bencana" diklik
  $(document).on('click', '.btn-bencana', function () {
    const idDestana = $(this).data('id');
    const namaDesa  = $(this).data('desa');
    $('#modalNamaDesa').text(namaDesa);

    // Tampilkan loading
    $('#bencanaTableBody').html('<tr><td colspan="3" class="text-center">Memuat data...</td></tr>');

    // Fetch data ke endpoint
    fetch(base_url + 'bencana/get_by_destana/' + idDestana)
      .then(response => response.json())
      .then(data => {
        if (data.length === 0) {
          $('#bencanaTableBody').html('<tr><td colspan="3" class="text-center">Tidak ada laporan bencana</td></tr>');
          return;
        }

        let rows = '';
        data.forEach((row, i) => {
          rows += `
            <tr>
              <td>${i + 1}</td>
              <td>${row.tanggal_bencana ?? '-'}</td>
              <td>${row.nama_ancaman ?? '-'}</td>
            </tr>
          `;
        });
        $('#bencanaTableBody').html(rows);
      })
      .catch(err => {
        console.error(err);
        $('#bencanaTableBody').html('<tr><td colspan="3" class="text-center text-danger">Gagal memuat data</td></tr>');
      });
  });
});
</script>

