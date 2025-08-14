<?php
  $segment1 = $this->uri->segment(1); 
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  
  <a href="<?= site_url('brand') ?>" class="brand-link">
    <i class="brand-image fa fa-bug" style="font-size: 2rem;"></i>
    <span class="brand-text ml-1">Menu Destana</span>
  </a>


  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="<?= site_url() ?>" class="nav-link <?= $segment1 == '' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>Beranda</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('relawan') ?>" class="nav-link <?= $segment1 == 'relawan' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-people-carry"></i>  
            <p>Data Relawan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= site_url('destana') ?>" class="nav-link <?= $segment1 == 'destana' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>Data Destana</p>
          </a>
        </li>

        <?php if ($this->session->userdata('role') === 'admin'): ?>
        <li class="nav-item">
          <a href="<?= site_url('user') ?>" class="nav-link <?= $segment1 == 'user' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user"></i>
            <p>Data User</p>
          </a>
        </li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">