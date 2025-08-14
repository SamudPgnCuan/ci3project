<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

	<!-- maybe i should make .css? but this part only used once for now i think? -->
  <style> 
    body {
      background: url('<?= base_url("assets/img/idmap_vector.jpg") ?>') no-repeat center center fixed;
      background-size: cover;
      background-color: #f7f7f7;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      max-width: 650px;
      width: 100%;
			min-height: 420px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    .brand-side {
      background-color: #343a40; /* or pake bg-primary di html */
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }

    .form-side {
      background-color: white;
      padding: 2rem;
    }
		.logo-container {
			display: flex;
			align-items: center; /* Vertikal rata tengah */
			gap: 15px; /* Jarak antar logo */
			margin-bottom: 1.5rem;
		}
		.logo-container img {
			max-height: 80px; /* Supaya tinggi seragam */
			object-fit: contain; /* Biar proporsi terjaga */
		}
  </style>
</head>

<body>
<div class="login-card d-flex">
  <!-- Kiri: Brand -->
  <div class="brand-side col-md-6">
    <div class="logo-container">
			<img src="<?= base_url('assets/img/logo_kebumen.png') ?>" alt="Logo Kebumen">
			<img src="<?= base_url('assets/img/logo_destana.png') ?>" alt="Logo Destana">
		</div>
    <h3>Destana Kebumen</h3>
    <!--  <p>Deskripsi singkat</p>  -->
  </div>

  <!-- Kanan: Form -->
  <div class="form-side col-md-6">
    <h4 class="mb-4">Login</h4>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger">
        <?= $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('auth/login') ?>" method="post">
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
  </div>
</div>

</body>
</html>
