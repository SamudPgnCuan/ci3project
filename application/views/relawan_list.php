<h2>Data Relawan</h2>
<a href="<?= site_url('relawan/create') ?>">Tambah Relawan</a>
<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NIK</th>
        <th>Alamat</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Komunitas</th>
        <th>No HP</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; foreach ($relawan as $r): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $r->nama ?></td>
        <td><?= $r->nik ?></td>
        <td><?= $r->alamat ?></td>
        <td><?= $r->jenis_kelamin ?></td>
        <td><?= $r->tanggal_lahir ?></td>
        <td><?= $r->komunitas ?></td>
        <td><?= $r->no_hp ?></td>
        <td>
            <a href="<?= site_url('relawan/edit/' . $r->nik) ?>">Edit</a> |
            <a href="<?= site_url('relawan/delete/' . $r->nik) ?>" onclick="return confirm('Hapus data?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="<?= site_url('welcome') ?>" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>