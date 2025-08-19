<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= isset($row) ? 'Edit' : 'Tambah' ?> Laporan Bencana</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="p-3">
<div class="container">

  <h3 class="mb-3"><?= isset($row) ? 'Edit' : 'Tambah' ?> Laporan Bencana</h3>

  <?= validation_errors('<div class="alert alert-danger">','</div>'); ?>

  <form method="post" action="<?= isset($row) ? site_url('bencana/update/'.$row->id) : site_url('bencana/store') ?>">

    <div class="form-row">
      <div class="form-group col-md-4">
        <label>Kecamatan</label>
        <select id="input_kecamatan" class="form-control">
          <option value="">-- Pilih Kecamatan --</option>
          <?php foreach($kecamatan as $k): ?>
            <?php
              $sel = '';
              if (isset($row) && (int)$row->id_kecamatan === (int)$k->id_kecamatan) $sel = 'selected';
            ?>
            <option value="<?= $k->id_kecamatan ?>" <?= $sel ?>><?= $k->nama_kecamatan ?></option>
          <?php endforeach; ?>
        </select>
        <small class="text-muted">Digunakan untuk memfilter desa (Destana).</small>
      </div>

      <div class="form-group col-md-8">
        <label>Desa (Destana)</label>
        <select name="id_destana" id="input_destana" class="form-control" required>
          <option value="">-- Pilih Desa (yang terdaftar sebagai Destana) --</option>
          <?php if(isset($destana_opsi)): ?>
            <?php foreach($destana_opsi as $d): ?>
              <?php
                $label = $d->nama_desa . ' (' . $d->nama_kecamatan . ')';
                $sel = (isset($row) && (int)$row->id_destana === (int)$d->id_destana) ? 'selected' : '';
              ?>
              <option value="<?= $d->id_destana ?>" <?= $sel ?>><?= $label ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label>Tanggal & Jam Kejadian</label>
        <?php
          $valTanggal = isset($row)
            ? date('Y-m-d\TH:i', strtotime($row->tanggal_bencana))
            : date('Y-m-d\TH:i');
        ?>
        <input type="datetime-local" name="tanggal_bencana" class="form-control" required value="<?= $valTanggal ?>">
      </div>
      <div class="form-group col-md-4">
        <label>Jenis Bencana</label>
        <select name="id_ancaman" class="form-control">
          <option value="">-- Pilih --</option>
          <?php foreach($ancaman as $a): ?>
            <?php
              $sel = (isset($row) && (int)$row->id_ancaman === (int)$a->id_ancaman) ? 'selected' : '';
            ?>
            <option value="<?= $a->id_ancaman ?>" <?= $sel ?>><?= $a->nama_ancaman ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label>Jumlah Korban</label>
        <input type="number" name="jumlah_korban" class="form-control" min="0"
               value="<?= isset($row) ? (int)$row->jumlah_korban : 0 ?>" required>
      </div>
    </div>

    <div class="form-group">
      <label>Detail Kerusakan</label>
      <textarea name="detail_kerusakan" rows="4" class="form-control"
                placeholder="Ringkas tapi jelas..."><?= isset($row) ? html_escape($row->detail_kerusakan) : '' ?></textarea>
    </div>

    <div class="d-flex justify-content-between">
      <a href="<?= site_url('bencana') ?>" class="btn btn-secondary">Kembali</a>
      <button class="btn btn-primary"><?= isset($row) ? 'Update' : 'Simpan' ?></button>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function(){
  // Saat kecamatan berubah → load opsi destana (desa) di kecamatan tsb
  $('#input_kecamatan').on('change', function(){
    const id_kecamatan = this.value;
    $('#input_destana').html('<option>Memuat...</option>');
    $.get('<?= site_url('bencana/ajax_destana_options') ?>', {id_kecamatan}, function(html){
      $('#input_destana').html(html);
    });
  });
});
</script>
</body>
</html>
