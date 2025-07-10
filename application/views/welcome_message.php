<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Dashboard | CodeIgniter 3 + AdminLTE</title>

	<!-- ===== CSS ===== -->
	<!-- Font Awesome -->
	<link rel="stylesheet"
		  href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.css'); ?>">
	<!-- AdminLTE main stylesheet -->
	<link rel="stylesheet"
		  href="<?= base_url('assets/adminlte/dist/css/adminlte.css'); ?>">
</head>

<!-- body class‐class AdminLTE -->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper"><!-- ① Pembungkus utama -->

	<!-- ===== Top Navbar ===== -->
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Burger untuk membuka sidebar -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			</li>
		</ul>
		<span class="navbar-text ml-2">CodeIgniter 3 + AdminLTE</span>
	</nav>

	<!-- ===== Sidebar ===== -->
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="<?= base_url(); ?>" class="brand-link">
			<span class="brand-text font-weight-light">CI3 AdminLTE</span>
		</a>

		<div class="sidebar">
			<!-- Menu -->
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
					<li class="nav-item">
						<a href="#" class="nav-link active">
							<i class="nav-icon fas fa-tachometer-alt"></i>
							<p>Dashboard</p>
						</a>
					</li>
					<!-- tambahkan menu lain di sini -->
				</ul>
			</nav>
		</div>
	</aside>

	<!-- ===== Konten Utama ===== -->
	<div class="content-wrapper">
		<!-- Header halaman -->
		<section class="content-header">
			<div class="container-fluid">
				<h1 class="m-0">Dashboard</h1>
			</div>
		</section>

		<!-- Isi halaman -->
		<section class="content">
			<div class="container-fluid">
				<div class="card">
					<div class="card-body">
						<p class="mb-2">Selamat datang di <strong>CodeIgniter 3 + AdminLTE</strong> :3 </p>
						<!-- <br><br> -->
						<h4>Menu Navigasi</h4>
						<ul>
							<li><a href="<?= site_url('user') ?>">Tabel User</a></li>
							<li><a href="<?= site_url('relawan') ?>">Tabel Relawan</a></li>
							<li><a href="<?= site_url('destana') ?>">Tabel Destana</a></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
	</div>

	<!-- ===== Footer ===== -->
	<footer class="main-footer text-sm">
		<strong>&copy; <?= date('Y'); ?> • My App</strong>
		<div class="float-right d-none d-sm-inline">Powered by CI3 & AdminLTE</div>
	</footer>
</div><!-- /.wrapper -->

<!-- ===== JS ===== -->
<!-- jQuery first (dibutuhkan AdminLTE & Bootstrap) -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.js'); ?>"></script>
<!-- Bootstrap  bundle -->
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.js'); ?>"></script>
<!-- AdminLTE main script -->
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.js'); ?>"></script>

<script>
  $(function () {
    // AdminLTE auto-init
    $('[data-widget="pushmenu"]').PushMenu();
  });
</script>

</body>
</html>
