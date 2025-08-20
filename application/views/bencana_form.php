<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
if (!isset($bencana)) {
  $bencana = (object) [
    'id' => '',
    'id_destana' => '',
    'id_ancaman' => '',
    'tanggal_bencana' => '',
    'jumlah_korban' => '',
    'detail_kerusakan' => '',
  ];
}

switch ($mode) {
  case 'edit':
    $judul_halaman = 'Edit Bencana';
    $judul_form = 'Form Edit Bencana';
    $aksi = 'bencana/update';
    $label_tombol = 'Update';
    break;
  case 'create':
  default:
    $judul_halaman = 'Tambah Bencana';
    $judul_form = 'Form Tambah Bencana';
    $aksi = 'bencana/store';
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
          <a href="<?= site_url('bencana') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
      </div>

      <form method="post" action="<?= site_url($aksi) ?>">
        <div class="card-body">
          <?php if ($mode === 'edit'): ?>
            <input type="hidden" name="id" value="<?= $bencana->id ?>">
          <?php endif; ?>

          <div class="form-group">
            <label for="filter_kecamatan">Kecamatan</label>
            <select class="form-control" id="filter_kecamatan">
              <option value="">-- Semua Kecamatan --</option>
              <?php foreach ($kecamatan_list as $k): ?>
                <option value="<?= $k->id_kecamatan ?>"
                  <?= (isset($bencana->id_kecamatan) && $bencana->id_kecamatan == $k->id_kecamatan) ? 'selected' : '' ?>>
                  <?= $k->nama_kecamatan ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="id_destana">Desa</label>
            <select name="id_destana" id="id_destana" class="form-control" required
              data-selected="<?= $bencana->id_destana ?>">
              <option value="">-- Pilih Desa --</option>
            </select>
          </div>

          <div class="form-group">
            <label for="id_ancaman">Jenis Ancaman</label>
            <select name="id_ancaman" id="id_ancaman" class="form-control" required>
              <option value="">-- Pilih Ancaman --</option>
              <?php foreach ($ancaman_list as $row): ?>
                <option value="<?= $row->id_ancaman ?>" <?= ($row->id_ancaman == $bencana->id_ancaman) ? 'selected' : '' ?>>
                  <?= $row->nama_ancaman ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="tanggal_bencana">Tanggal Bencana</label>
            <input type="datetime-local" name="tanggal_bencana" class="form-control" value="<?= $bencana->tanggal_bencana ?>" required>
          </div>

          <div class="form-group">
            <label for="jumlah_korban">Jumlah Korban</label>
            <input type="number" name="jumlah_korban" class="form-control" value="<?= $bencana->jumlah_korban ?>">
          </div>

          <div class="form-group">
            <label for="detail_kerusakan">Detail Kerusakan</label>
            <input type="text" name="detail_kerusakan" class="form-control" value="<?= $bencana->detail_kerusakan ?>">
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-success"><?= $label_tombol ?></button>
          <a href="<?= site_url('bencana') ?>" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  const base_url = "<?= base_url() ?>";
</script>
