<section class="content-header">
  <div class="container-fluid">
    <h1>Data Relawan</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <a href="<?= site_url('relawan/create') ?>" class="btn btn-primary">Tambah Relawan</a>
        <div class="card-tools">
          <a href="<?= site_url('welcome') ?>" class="btn btn-secondary btn">← Kembali ke Halaman Utama</a>
        </div>
      </div>

      <!-- filter -->
      <div class="card-body">

        <form method="get" id="filterForm" action="<?= site_url('relawan') ?>">
          <div class="row">
            
            <div class="col-md-4">
              <label for="filter_kecamatan">Kecamatan</label>
              <select name="kecamatan" id="filter_kecamatan" class="form-control">
                <option value="">-- Semua Kecamatan --</option>
                <?php foreach ($kecamatan_list as $k): ?>
                  <option 
                  value="<?= $k->id_kecamatan  ?>" 
                  <?= ($this->input->get('kecamatan') == $k->id_kecamatan ) ? 'selected' : '' ?>>
                  <?= $k->nama_kecamatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label for="filter_desa">Desa</label>
              <select name="desa" id="filter_desa" class="form-control" data-selected="<?= $this->input->get('desa') ?>">
                <option value="">-- Semua Desa --</option>
                <!-- dari javascript i think -->
              </select>
            </div>
          </div>

            <div class="col-md-12 mt-3">
              <a href="<?= site_url('relawan') ?>" class="btn btn-secondary">Reset</a>
            </div>

          </div>
        </form>
      </div>

      <!-- filter sampai sini ^ ? -->

      <form id="relawanForm" method="post" action="<?= site_url('relawan/delete_bulk') ?>">
        <div class="card-body table-responsive p-0">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th class="text-center align-middle p-0" style="width: 50px;">
                  <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
                </th>
                <th>No</th>
                <th>Nama</th>
                <th>Komunitas</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th style="width: 120px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($relawan)): ?>
                <?php $no = 1; foreach ($relawan as $r): ?>
                  <tr>
                    <td class="text-center align-middle p-0">
                      <input type="checkbox" name="ids[]" value="<?= $r->id ?>" style="transform: scale(1.2);">
                    </td>
                    <td><?= $no++ ?></td>
                    <td><?= $r->nama ?></td>
                    <td><?= $r->komunitas ?></td>
                    <td><?= $r->nama_kecamatan ?></td>
                    <td><?= $r->nama_desa ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('relawan/edit/' . $r->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal<?= $r->id ?>">Detail</button>
                    </td>
                  </tr>

                  <!-- Modal Detail -->
                  <div class="modal fade" id="detailModal<?= $r->id ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $r->id ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="detailModalLabel<?= $r->id ?>">Detail Relawan: <?= $r->nama ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <ul class="list-group">
                            <li class="list-group-item"><strong>NIK:</strong> <?= $r->nik ?></li>
                            <li class="list-group-item"><strong>Alamat:</strong> <?= $r->alamat ?></li>
                            <li class="list-group-item"><strong>Jenis Kelamin:</strong> <?= $r->jenis_kelamin ?></li>
                            <li class="list-group-item"><strong>Tempat Lahir:</strong> <?= $r->tempat_lahir ?></li>
                            <li class="list-group-item"><strong>Tanggal Lahir:</strong> <?= $r->tanggal_lahir ?></li>
                            <li class="list-group-item"><strong>Komunitas:</strong> <?= $r->komunitas ?></li>
                            <li class="list-group-item"><strong>Kecamatan:</strong> <?= $r->nama_kecamatan ?></li>
                            <li class="list-group-item"><strong>Desa:</strong> <?= $r->nama_desa ?></li>
                            <li class="list-group-item"><strong>Pekerjaan:</strong> <?= $r->pekerjaan ?></li>
                            <li class="list-group-item"><strong>No HP:</strong> <?= $r->no_hp ?></li>
                          </ul>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center">Tidak ada data.</td>
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
        </div>
      </form>
    </div>

  </div>
</section>

<script>
var base_url = '<?= base_url() ?>';
</script>

<!-- testttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt -->

<button type="button" onclick="testDesa()" class="btn btn-info">Test Load Desa</button>
<button type="button" onclick="debugDataStructure()" class="btn btn-warning">Debug Data</button>

<script>
function testDesa() {
    const kecamatanId = $('#filter_kecamatan').val() || 1;
    
    $.get(base_url + 'relawan/get_desa_by_kecamatan?kecamatan=' + kecamatanId)
        .done(function(data) {
            console.log('Raw data:', data);
            console.log('Data type:', typeof data);
            console.log('Is array:', Array.isArray(data));
            
            // Reset dropdown
            $('#filter_desa').empty().append(new Option('-- Semua Desa --', ''));
            
            // Handle different data types
            let processedData = [];
            
            if (typeof data === 'string') {
                try {
                    processedData = JSON.parse(data);
                } catch (e) {
                    alert('Error: Data bukan JSON valid');
                    return;
                }
            } else if (Array.isArray(data)) {
                processedData = data;
            } else {
                alert('Error: Data bukan array. Type: ' + typeof data);
                return;
            }
            
            // Add options
            if (processedData && processedData.length > 0) {
                processedData.forEach(function(desa) {
                    if (desa && desa.nama_desa && desa.id_desa) {
                        $('#filter_desa').append(new Option(desa.nama_desa, desa.id_desa));
                    }
                });
                $('#filter_desa').trigger('change');
                alert('Berhasil! ' + processedData.length + ' desa loaded');
            } else {
                alert('Tidak ada data desa');
            }
        })
        .fail(function(xhr, status, error) {
            alert('AJAX gagal: ' + error);
        });
}

function debugDataStructure() {
    const kecamatanId = $('#filter_kecamatan').val() || 1;
    
    $.get(base_url + 'relawan/get_desa_by_kecamatan?kecamatan=' + kecamatanId)
        .done(function(data) {
            console.log('=== DATA DEBUG ===');
            console.log('Raw data:', data);
            console.log('Type:', typeof data);
            console.log('Is Array:', Array.isArray(data));
            
            if (data && data.length > 0) {
                console.log('First item:', data[0]);
            }
            
            alert('Debug selesai! Cek console untuk detail');
        });
}
</script>

