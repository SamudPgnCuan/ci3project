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
                <option value="">-- Semua kecamatan --</option>
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
                <option value="">-- if you see this on web something probably broke --</option>
                <!-- dari javascript :3 -->
              </select>
            </div>

            <div class="col-md-4">
              <label for="filter_organisasi">Organisasi</label>
              <select name="organisasi" id="filter_organisasi" class="form-control">
                <option value="">-- Semua Organisasi --</option>
                <?php foreach ($organisasi_list as $o): ?>
                  <option value="<?= $o->id_organisasi ?>"
                    <?= ($this->input->get('organisasi') == $o->id_organisasi) ? 'selected' : '' ?>>
                    <?= $o->nama_organisasi ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          
            <div class="col-md-12 mt-3">
              <a href="<?= site_url('relawan') ?>" class="btn btn-secondary">Reset Filter</a>
            </div>

          </div>
        </form>
      </div>

      <!-- filter sampai sini ^ ? -->

      <!-- bawah mundur -->
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Organisasi</th>
              <th>Kecamatan</th>
              <th>Desa</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($relawan)): ?>
              <?php $no = 1; foreach ($relawan as $r): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $r->nama ?></td>
                  <td><?= $r->nama_organisasi ?></td>
                  <td><?= $r->nama_kecamatan ?></td>
                  <td><?= $r->nama_desa ?></td>
                  <td style="width: 220px;">
                    <a href="<?= site_url('relawan/edit/' . $r->id) ?>" class="btn btn-sm btn-warning mr-2">Edit</a>
                    <button type="button" class="btn btn-sm btn-info mr-2" data-toggle="modal" data-target="#detailModal<?= $r->id ?>">Detail</button>
                    <a href="<?= site_url('relawan/delete/' . $r->id) ?>" 
                      class="btn btn-sm btn-danger" 
                      onclick="return confirm('Yakin ingin menghapus relawan bernama <?= addslashes($r->nama) ?>?')">
                      Delete
                    </a>
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
                          <li class="list-group-item"><strong>Organisasi:</strong> <?= $r->nama_organisasi ?></li>
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
                <td colspan="6" class="text-center">Tidak ada data.</td>
              </tr>
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
  const base_url = '<?= base_url() ?>';
</script>

