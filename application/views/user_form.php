<h2><?= $mode === 'edit' ? 'Edit' : 'Tambah' ?> User</h2>

<form method="post" action="<?= site_url($mode === 'edit' ? 'user/update/' . $user->username : 'user/store') ?>">
    <p>
        <label>Username:</label><br>
        <input type="text" name="username" value="<?= isset($user) ? $user->username : '' ?>" <?= $mode === 'edit' ? 'readonly' : '' ?> required>
    </p>
    <p>
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?= isset($user) ? $user->nama : '' ?>" required>
    </p>
    <p>
        <label>Password:</label><br>
        <input type="text" name="password" value="<?= isset($user) ? $user->password : '' ?>" required>
    </p>
    <p>
        <label>Role:</label><br>
        <input type="text" name="role" value="<?= isset($user) ? $user->role : '' ?>" required>
    </p>
    <p>
        <button type="submit">Simpan</button>
        <a href="<?= site_url('user') ?>">Batal</a>
    </p>
</form>
