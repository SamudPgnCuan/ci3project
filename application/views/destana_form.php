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
              <label for="filter_kecamatan">Kecamatan</label>
              <select name="id_kecamatan" class="form-control" id="filter_kecamatan" required>
                <option value="">-- Pilih Kecamatan --</option>
                <?php foreach ($kecamatan_list as $k): ?>
                  <option 
                  value="<?= $k->id_kecamatan ?>" 
                  <?= $destana->id_kecamatan == $k->id_kecamatan  ? 'selected' : '' ?>>
                  <?= $k->nama_kecamatan ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="filter_desa">Desa</label>
              <select name="id_desa" id="filter_desa" class="form-control" required 
              data-selected="<?= isset($destana->id_desa) ? $destana->id_desa : '' ?>">
                <option value="">-- if you see this something went wrong --</option>
                <!-- dari ajax lagi? -->
              </select>
            </div>

            <div class="form-group">
              <label for="tahun_pembentukan">Tahun Pembentukan</label>
              <?php $tahun_sekarang = date('Y'); ?>
              <select name="tahun_pembentukan" class="form-control" required>
                <option value="">-- Pilih Tahun --</option>
                <?php
                  $tahun_terpilih = isset($destana->tahun_pembentukan) ? $destana->tahun_pembentukan : '';
                  $tahun_sekarang = max(2010, date('Y'));
                  for ($tahun = 2010; $tahun <= $tahun_sekarang; $tahun++) {
                    $selected = $tahun == $tahun_terpilih ? 'selected' : '';
                    echo "<option value=\"$tahun\" $selected>$tahun</option>";
                  }
                ?>
              </select>
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
  const base_url = "<?= base_url() ?>";
</script>

