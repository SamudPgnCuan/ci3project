document.addEventListener('DOMContentLoaded', function () {
  // Inisialisasi Select2 untuk filter kecamatan
  $('#filter_kecamatan').select2({
    placeholder: 'Pilih Kecamatan',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#filter_kecamatan').parent()
  }).on('select2:open', function () {
    setTimeout(() => {
      $('.select2-container--open .select2-search__field').focus();
    }, 0);
  });

  // Inisialisasi Select2 untuk filter desa
  $('#filter_desa').select2({
    placeholder: 'Pilih Desa',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#filter_desa').parent()
  }).on('select2:open', function () {
    setTimeout(() => {
      $('.select2-container--open .select2-search__field').focus();
    }, 0);
  });

  // Submit otomatis jika filter kecamatan diubah
  $('#filter_kecamatan').on('change', function () {
    $('#filterForm').submit();
  });

  // Jika ingin desa juga memicu submit otomatis, aktifkan ini:
  // $('#filter_desa').on('change', function () {
  //   $('#filterForm').submit();
  // });
});
