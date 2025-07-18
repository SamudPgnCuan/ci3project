  <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

  <?php
  if ($mode !== 'create' && $mode !== 'edit') {
    show_error("Mode tidak valid: harus 'create' atau 'edit'", 500);
  }

  if (!isset($destana)) {
    $destana = (object) [
      'id' => '',
      'id_kecamatan' => '',
      'id_desa' => '',
      'id_kelas' => '',
      'id_sumber_dana' => '',
      'tahun_pembentukan' => '',
      'jenis_bencana' => []
    ];
  }

  switch ($mode) {
    case 'edit':
      $judul_halaman = 'Edit Destana';
      $judul_form = 'Form Edit Destana';
      $aksi = 'destana/update';
      $label_tombol = 'Update';
      break;
    case 'create':
    default:
      $judul_halaman = 'Tambah Destana';
      $judul_form = 'Form Tambah Destana';
      $aksi = 'destana/store';
      $label_tombol = 'Simpan';
      break;
  }
  ?>

  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $judul_halaman ?></h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?= $judul_form ?></h3>
          <div class="card-tools">
            <a href="<?= site_url('destana') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
          </div>
        </div>

        <form method="post" action="<?= site_url($aksi) ?>">
          <div class="card-body">
            <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <?php if ($mode === 'edit'): ?>
              <input type="hidden" name="id" value="<?= $destana->id ?>">
            <?php endif; ?>

            <div class="form-group">
              <label for="id_kecamatan">Kecamatan</label>
              <select name="id_kecamatan" id="id_kecamatan" class="form-control" required>
                <option value="">-- Pilih Kecamatan --</option>
                <?php foreach ($kecamatan_list as $row): ?>
                  <option value="<?= $row->id_kecamatan ?>" <?= ($row->id_kecamatan == $destana->id_kecamatan) ? 'selected' : '' ?>>
                    <?= $row->nama_kecamatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="id_desa">Desa</label>
              <select name="id_desa" id="id_desa" class="form-control" required <?= empty($desa_list) ? 'disabled' : '' ?>>
                <?php if (empty($desa_list)): ?>
                  <option value="">-- Pilih Kecamatan Dahulu --</option>
                <?php else: ?>
                  <option value="">-- Pilih Desa --</option>
                  <?php foreach ($desa_list as $row): ?>
                    <option value="<?= $row->id_desa ?>" <?= ($row->id_desa == $destana->id_desa) ? 'selected' : '' ?>>
                      <?= $row->nama_desa ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="tahun_pembentukan">Tahun Pembentukan</label>
              <input type="number" class="form-control" name="tahun_pembentukan" id="tahun_pembentukan"
                    value="<?= isset($destana->tahun_pembentukan) ? $destana->tahun_pembentukan : '' ?>" required>
            </div>

            <div class="form-group">
              <label for="id_sumber_dana">Sumber Dana</label>
              <select name="id_sumber_dana" id="id_sumber_dana" class="form-control" required>
                <option value="">-- Pilih Sumber Dana --</option>
                <?php foreach ($sumber_dana_list as $row): ?>
                  <option value="<?= $row->id_sumber_dana ?>" <?= ($row->id_sumber_dana == $destana->id_sumber_dana) ? 'selected' : '' ?>>
                    <?= $row->nama_sumber_dana ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="id_kelas">Kelas</label>
              <select name="id_kelas" id="id_kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas_list as $row): ?>
                  <option value="<?= $row->id_kelas ?>" <?= ($row->id_kelas == $destana->id_kelas) ? 'selected' : '' ?>>
                    <?= $row->nama_kelas ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Ancaman</label>
              <div class="d-flex flex-wrap gap-2">
                <?php
                $terpilih = isset($destana->jenis_bencana) ? $destana->jenis_bencana : [];
                foreach ($ancaman_list as $a):
                  $checked = in_array($a->id_ancaman, $terpilih) ? 'checked' : '';
                ?>
                <div class="form-check me-3" style="min-width: 200px;">
                  <input class="form-check-input" type="checkbox" name="jenis_bencana[]" value="<?= $a->id_ancaman ?>" id="ancaman<?= $a->id_ancaman ?>" <?= $checked ?> style="transform: scale(1.3); margin-right: 8px;">
                  <label class="form-check-label" for="ancaman<?= $a->id_ancaman ?>" style="font-size: 1rem;">
                    <?= $a->nama_ancaman ?>
                  </label>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-success"><?= $label_tombol ?></button>
            <a href="<?= site_url('destana') ?>" class="btn btn-secondary">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const selectedDesaId = "<?= $destana->id_desa ?>";

    document.getElementById('id_kecamatan').addEventListener('change', function () {
      const id_kecamatan = this.value;
      const desaDropdown = document.getElementById('id_desa');

      desaDropdown.innerHTML = '<option value="">Memuat data...</option>';
      desaDropdown.disabled = true;

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
          desaDropdown.innerHTML = '';
          desaDropdown.disabled = false;

          if (data.length > 0) {
            desaDropdown.innerHTML = '<option value="">-- Pilih Desa --</option>';
            data.forEach(desa => {
              const selected = desa.id_desa == selectedDesaId ? 'selected' : '';
              desaDropdown.innerHTML += `<option value="${desa.id_desa}" ${selected}>${desa.nama_desa}</option>`;
            });
          } else {
            desaDropdown.innerHTML = '<option value="">Tidak ada desa tersedia</option>';
          }
        })
        .catch(err => {
          console.error('Fetch Error:', err);
          desaDropdown.innerHTML = '<option value="">Gagal memuat desa</option>';
        });
      } else {
        desaDropdown.innerHTML = '<option value="">-- Pilih Kecamatan Dahulu --</option>';
        desaDropdown.disabled = true;
      }
    });
  });
  </script>

