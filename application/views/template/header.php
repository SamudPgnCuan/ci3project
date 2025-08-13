<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Dashboard | CI3 + AdminLTE</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">

  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="hold-transition layout-fixed sidebar-mini" data-page="<?= $this->router->class ?>">
  <!-- sidebar-collapse -->
  <!--  sidebar-mini sidebar-no-expand| no expandnya gak work grrrrrrrrrrrr -->

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <span class="navbar-text ml-2">ini cara makenya gimana ya</span>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user-circle"></i>
          <?= $this->session->userdata('nama') ?: 'Tidak Diketahui' ?>
          <i class="fas fa-caret-down ml-1"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right p-3 shadow-lg" style="min-width: 250px;">
          <div class="text-center mb-2">
            <i class="fas fa-user-circle fa-3x text-primary"></i>
          </div>
          <h6 class="dropdown-header text-center">
            <?= $this->session->userdata('nama') ?>
          </h6>
          <p class="text-muted text-center mb-1">
            <small><?= ucfirst($this->session->userdata('role') ?? 'Tidak Ada Role') ?></small>
          </p>
          <div class="dropdown-divider"></div>
          <a href="<?= site_url('profile') ?>" class="dropdown-item">
            <i class="fas fa-id-card"></i> Profil Saya
          </a>
          <div class="dropdown-divider"></div> <!-- pemisah -->
          <a href="<?= site_url('auth/logout') ?>" class="dropdown-item text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>

  </nav>
