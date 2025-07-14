<h2>Tambah Data Destana</h2>
<form action="<?= site_url('destana/store') ?>" method="post">

    <label for="kecamatan">Kecamatan</label><br>
    <input type="text" name="kecamatan" required><br><br>

    <label for="desa">Desa</label><br>
    <input type="text" name="desa" required><br><br>

    <button type="submit">Simpan</button>
</form>
