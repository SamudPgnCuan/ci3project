

<section class="content-header">
  <div class="container-fluid">
    <h1><?= isset($relawan) ? 'Edit Relawan' : 'Tambah Relawan' ?></h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-body">
        <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        <?= form_open(isset($relawan) ? 'relawan/update/' . $relawan->nik : 'relawan/store'); ?>

        <div class="form-group">
          <label for="nama">Nama</label>
          <input type="text" class="form-control" name="nama" value="<?= set_value('nama', $relawan->nama ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label for="nik">NIK</label>
          <input type="text" class="form-control" name="nik" value="<?= set_value('nik', $relawan->nik ?? '') ?>" required <?= isset($relawan) ? 'readonly' : '' ?>>
        </div>

        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea class="form-control" name="alamat" required><?= set_value('alamat', $relawan->alamat ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <label for="jenis_kelamin">Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-control" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki', ($relawan->jenis_kelamin ?? '') === 'Laki-laki') ?>>Laki-laki</option>
            <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan', ($relawan->jenis_kelamin ?? '') === 'Perempuan') ?>>Perempuan</option>
          </select>
        </div>

        <div class="form-group">
          <label for="tanggal_lahir">Tanggal Lahir</label>
          <input type="date" class="form-control" name="tanggal_lahir" value="<?= set_value('tanggal_lahir', $relawan->tanggal_lahir ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label for="komunitas">Komunitas</label>
          <input type="text" class="form-control" name="komunitas" value="<?= set_value('komunitas', $relawan->komunitas ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label for="no_hp">No HP</label>
          <input type="text" class="form-control" name="no_hp" value="<?= set_value('no_hp', $relawan->no_hp ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= site_url('relawan') ?>" class="btn btn-secondary">Kembali</a>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</section>
