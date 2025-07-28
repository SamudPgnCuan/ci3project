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

   // Fungsi untuk memfilter desa berdasarkan kecamatan
  function filterDesaOptions() {
    const selectedKecamatanId = $('#filter_kecamatan').val(); // ID numerik
    const desaSelect = $('#filter_desa');

    desaSelect.empty(); // Bersihkan dropdown desa

    if (!selectedKecamatanId) {
      desaSelect.trigger('change');
      return;
    }

    fetch(base_url + 'relawan/get_desa_by_kecamatan?kecamatan=' + selectedKecamatanId)
      .then(response => response.json())
      .then(data => {
        desaSelect.append(new Option('', '', true, true)); // Tambahkan opsi kosong

        data.forEach(desa => {
          desaSelect.append(new Option(desa.nama_desa, desa.id_desa));
        });

        desaSelect.trigger('change');
      })
      .catch(error => {
        console.error('Gagal mengambil data desa:', error);
      });
  }



  // Submit otomatis jika filter kecamatan diubah
  $('#filter_kecamatan').on('change', function () {
    $('#filterForm').submit();
  });

  //Jika ingin desa juga memicu submit otomatis, aktifkan ini:
  $('#filter_desa').on('change', function () {
    $('#filterForm').submit();
  });
});
