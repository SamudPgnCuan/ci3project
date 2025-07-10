<h2>Daftar User</h2>
<a href="<?= site_url('user/create') ?>">+ Tambah User</a>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>Password</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u->username ?></td>
            <td><?= $u->nama ?></td>
            <td><?= $u->password ?></td>
            <td><?= $u->role ?></td>
            <td>
                <a href="<?= site_url('user/edit/' . $u->username) ?>">Edit</a> |
                <a href="<?= site_url('user/delete/' . $u->username) ?>" onclick="return confirm('Yakin?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= site_url('welcome') ?>" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>