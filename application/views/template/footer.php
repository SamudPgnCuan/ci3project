</div> <!-- /.content-wrapper -->

<!-- Main Footer -->
<footer class="main-footer text-sm">
  <strong>&copy; <?= date('Y'); ?> • My App</strong>
  <div class="float-right d-none d-sm-inline">
    Powered by CI3 & AdminLTE
  </div>
</footer>

</div> <!-- ./wrapper -->

<!-- Scripts -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js'); ?>"></script>

<!-- DataTables (opsional?) -->
<script src="<?= base_url('assets/adminlte/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>

<!-- Select2 (kalo minta aja di controller) -->
<?php if ($load_select2 === true) : ?>
  <link href="<?= base_url('assets/adminlte/plugins/select2/css/select2.min.css') ?>" rel="stylesheet">
  <script src="<?= base_url('assets/adminlte/plugins/select2/js/select2.full.min.js') ?>"></script>
  <link href="<?= base_url('assets/css/select2-custom.css') ?>" rel="stylesheet"> <!-- tambahkan ini -->
<?php endif; ?>

<!-- custom script -->
<?php if (!empty($custom_script)): ?>
  <script src="<?= base_url('assets/js/' . $custom_script) ?>"></script>
<?php endif; ?>

</body>
</html>
