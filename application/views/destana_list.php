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
        
        <form method="get" action="<?= site_url('destana'); ?>" class="p-3">
          <div class="row">

            <div class="col-md-4">
              <label>Kecamatan</label>
              <select name="id_kecamatan" id="filter_kecamatan" class="form-control">
                <option value="">-- Semua Kecamatan --</option>

                <?php foreach ($kecamatan_list as $row): ?>
                  <option value="<?= $row->id_kecamatan ?>" <?= set_select('id_kecamatan', $this->input->get('id_kecamatan'), $this->input->get('id_kecamatan') == $row->id_kecamatan) ?>>
                    <?= $row->nama_kecamatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label>Desa</label>
              <select name="id_desa" id="filter_desa" class="form-control">
                <option value="">-- Semua Desa --</option>
                <?php foreach ($desa_list as $row): ?>
                  <option value="<?= $row->id_desa ?>" <?= set_select('id_desa', $this->input->get('id_desa'), $this->input->get('id_desa') == $row->id_desa) ?>>
                    <?= $row->nama_desa ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label>Tahun Pembentukan</label>
              <select name="tahun" class="form-control">
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
              <select name="id_kelas" class="form-control">
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
              <select name="id_sumber_dana" class="form-control">
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
              <select name="id_ancaman" class="form-control">
                <option value="">-- Semua Ancaman --</option>
                <?php foreach ($ancaman_list as $row): ?>
                  <option value="<?= $row->id_ancaman ?>" <?= set_select('id_ancaman', $this->input->get('id_ancaman'), $this->input->get('id_ancaman') == $row->id_ancaman) ?>>
                    <?= $row->nama_ancaman ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-12 mt-3">
              <button type="submit" class="btn btn-primary">Filter</button>
              <a href="<?= site_url('destana'); ?>" class="btn btn-secondary">Reset</a>
            </div>
          </div>
        </form>
      </div>

      <!-- filter sampe sini ^ -->

      <form method="post" action="<?= site_url('destana/delete_bulk') ?>">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th class="text-center align-middle p-0" style="width: 50px;">
                <input type="checkbox" id="checkAll" style="transform: scale(1.2);">
              </th>
              <th>Kecamatan</th>
              <th>Desa</th>
              <th>Tahun Pembentukan</th>
              <th>Kelas</th>
              <th>Sumber Dana</th>
              <th>Jenis Bencana</th>
              <th style="width: 80px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($destana)): ?>
              <?php foreach ($destana as $d): ?>
                <tr>
                  <td class="text-center align-middle p-0">
                    <input type="checkbox" name="ids[]" value="<?= $d['id'] ?>" style="transform: scale(1.2);">
                  </td>
                  <td><?= $d['nama_kecamatan'] ?></td>
                  <td><?= $d['nama_desa'] ?></td>
                  <td><?= $d['tahun_pembentukan'] ?></td>
                  <td><?= $d['nama_kelas'] ?></td>
                  <td><?= $d['nama_sumber_dana'] ?></td>
                  <td>
                    <?= !empty($d['ancaman']) ? implode('<br>', $d['ancaman']) : '-' ?>
                  </td>
                  <td class="text-center">
                    <a href="<?= site_url('destana/edit/' . $d['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="8" class="text-center">Tidak ada data.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="card-footer d-flex justify-content-between">
          <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data yang dipilih?')">
            <i class="fas fa-trash-alt"></i> Hapus (centang data terlebih dahulu)
          </button>
        </div>
      </form>

    </div>

  </div>
</section>

<script>
  //bagian checkall
  const checkAll = document.getElementById('checkAll');
  const checkboxes = document.querySelectorAll('input[name="ids[]"]');

  checkAll.addEventListener('change', function () {
    checkboxes.forEach(cb => cb.checked = this.checked);
  });

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
  //^ bagian check all

  //bagian filter
  document.getElementById('filter_kecamatan').addEventListener('change', function () {
    const id_kecamatan = this.value;
    const desaDropdown = document.getElementById('filter_desa');

    if (id_kecamatan) {
      fetch("<?= site_url('destana/get_desa_by_kecamatan') ?>", {
        method: "POST",
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id_kecamatan=${encodeURIComponent(id_kecamatan)}`
      })
      .then(response => response.json())
      .then(data => {
        desaDropdown.innerHTML = '<option value="">-- Pilih Desa --</option>';
        data.forEach(desa => {
          desaDropdown.innerHTML += `<option value="${desa.id_desa}">${desa.nama_desa}</option>`;
        });
      })
      .catch(err => {
        console.error('Fetch Error:', err);
        desaDropdown.innerHTML = '<option value="">-- Gagal memuat desa --</option>';
      });
    } else {

      // Reset ke semua desa jika tidak ada kecamatan
      desaDropdown.innerHTML = '<option value="">-- Semua Desa --</option>';
      <?php foreach ($desa_list as $row): ?>
        desaDropdown.innerHTML += '<option value="<?= $row->id_desa ?>"><?= $row->nama_desa ?></option>';
      <?php endforeach; ?>
    }
  });
</script>
