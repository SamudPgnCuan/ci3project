<!-- Mulai dari bagian konten AdminLTE -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar User</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Card AdminLTE -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel User</h3>
                    <div class="card-tools">
                        <a href="<?= site_url('user/create') ?>" class="btn btn-sm btn-primary">Tambah User</a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user->username ?></td>
                                        <td><?= $user->nama ?></td>
                                        <td><?= $user->password ?></td>
                                        <td><?= $user->role ?></td>
                                        <td>
                                            <a href="<?= site_url('user/edit/' . $user->username) ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="<?= site_url('user/delete/' . $user->username) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <a href="<?= site_url() ?>" class="btn btn-secondary">Kembali ke Beranda</a>
                </div>
            </div>

        </div>
    </section>
</div>
