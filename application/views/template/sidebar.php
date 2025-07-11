<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= site_url() ?>" class="brand-link">
    <span class="brand-text font-weight-light">CI3 AdminLTE</span>
  </a>

  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="<?= site_url() ?>" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Beranda</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('user') ?>" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Tabel User</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('relawan') ?>" class="nav-link">
            <i class="nav-icon fas fa-people-carry"></i>
            <p>Tabel Relawan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('destana') ?>" class="nav-link">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>Tabel Destana</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
