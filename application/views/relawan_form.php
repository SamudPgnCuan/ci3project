<h2><?= isset($relawan) ? 'Edit Relawan' : 'Tambah Relawan' ?></h2>

<!-- Tambahkan CSS untuk layout -->
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .text-danger {
        color: red;
        font-size: 0.875rem;
    }
</style>

<form action="<?= isset($relawan) ? site_url('relawan/update/' . $relawan->nik) : site_url('relawan/store') ?>" method="post">
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control"
               value="<?= set_value('nama', $relawan->nama ?? '') ?>">
        <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="nik">NIK</label>
        <input type="text" name="nik" class="form-control"
               value="<?= set_value('nik', $relawan->nik ?? '') ?>">
        <?= form_error('nik', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" class="form-control"><?= set_value('alamat', $relawan->alamat ?? '') ?></textarea>
        <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-control">
            <option value="">-- Pilih --</option>
            <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki', isset($relawan) && $relawan->jenis_kelamin == 'Laki-laki') ?>>Laki-laki</option>
            <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan', isset($relawan) && $relawan->jenis_kelamin == 'Perempuan') ?>>Perempuan</option>
        </select>
        <?= form_error('jenis_kelamin', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="tanggal_lahir">Tanggal Lahir (format: YYYY-MM-DD)</label>
        <input type="text" name="tanggal_lahir" class="form-control"
               value="<?= set_value('tanggal_lahir', $relawan->tanggal_lahir ?? '') ?>" placeholder="contoh: 2000-12-31">
        <?= form_error('tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="komunitas">Komunitas</label>
        <input type="text" name="komunitas" class="form-control"
               value="<?= set_value('komunitas', $relawan->komunitas ?? '') ?>">
        <?= form_error('komunitas', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="form-group">
        <label for="no_hp">No HP</label>
        <input type="text" name="no_hp" class="form-control"
               value="<?= set_value('no_hp', $relawan->no_hp ?? '') ?>">
        <?= form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
    </div>

    <!-- Tampilkan semua error di bawah form -->
    <?php if (validation_errors()): ?>
        <div class="text-danger mb-3">
            <strong>Periksa kembali form Anda:</strong>
            <ul>
                <?= validation_errors('<li>', '</li>') ?>
            </ul>
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('relawan') ?>" class="btn btn-secondary">Batal</a>
</form>
