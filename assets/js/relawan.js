

document.addEventListener('DOMContentLoaded', function () {

  const preselectedDesaId = $('#filter_desa').data('selected');
  filterDesaOptions(preselectedDesaId); 

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
    placeholder: 'pilih kecamatan dulu? :3',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#filter_desa').parent()
  }).on('select2:open', function () {
    setTimeout(() => {
      $('.select2-container--open .select2-search__field').focus();
    }, 0);
  });

   // Fungsi untuk memfilter desa berdasarkan kecamatan
  function filterDesaOptions(preselectId = null) {

  const selectedKecamatanId = $('#filter_kecamatan').val(); //i forgor why this needs .val()
  const desaSelect = $('#filter_desa');

  desaSelect.empty(); // Hapus semua opsi sebelumnya

  if (!selectedKecamatanId) {
    //desaSelect.append(new Option('-- pilih kecamatan dulu --')); 
    desaSelect.trigger('change.select2'); // Paksa refresh
    return;
  }

  // Ambil data desa
  fetch(base_url + 'relawan/get_desa_by_kecamatan?kecamatan=' + selectedKecamatanId)
    .then(response => response.json())
    .then(data => {
      desaSelect.append(new Option('-- Semua Desa --', 'all', false, preselectId === 'all')); // Tambahkan default

      data.forEach(desa => {
        const isSelected = desa.id_desa == preselectId;
        const option = new Option(desa.nama_desa, desa.id_desa, false, isSelected);
        desaSelect.append(option);
      });
      
      console.log("Isi dropdown setelah diubah:", $('#filter_desa').html());

      desaSelect.trigger('change.select2'); // Penting: sinkronisasi ulang setelah semua opsi ditambahkan
    })
    .catch(error => {
      console.error('Gagal mengambil data desa:', error);
    });
}


  // Submit otomatis jika filter kecamatan diubah
  $('#filter_kecamatan').on('change', function () {
    filterDesaOptions(); 
    $('#filterForm').submit();
  });

  //Jika ingin desa juga memicu submit otomatis, aktifkan ini:
  $('#filter_desa').on('change', function () {
    $('#filterForm').submit();
  });
});
