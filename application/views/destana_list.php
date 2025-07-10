<h2>Data Destana</h2>
<a href="<?= site_url('destana/create') ?>">Tambah Destana</a>
<table border="1" cellpadding="5">
    <tr>
        <th>Kecamatan</th>
        <th>Desa</th>
    </tr>
    <?php foreach ($destana as $d): ?>
    <tr>
        <td><?= $d->kecamatan ?></td>
        <td><?= $d->desa ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="<?= site_url('welcome') ?>" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>