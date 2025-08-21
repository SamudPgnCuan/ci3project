document.addEventListener('DOMContentLoaded', function () {

  const preselectedDesaId = $('#filter_desa').data('selected');
  filterDesaOptions(preselectedDesaId);

  // Fungsi inisialisasi Select2
  function initSelect2(selector, placeholder) {
    $(selector).select2({
      placeholder: placeholder,
      allowClear: true,
      width: '100%',
      dropdownParent: $(selector).parent()
    }).on('select2:open', function () {
      setTimeout(() => {
        $('.select2-container--open .select2-search__field').focus();
      }, 0);
    });
  }

  // Inisialisasi semua dropdown
  initSelect2('#filter_kecamatan', 'Pilih Kecamatan');
  initSelect2('#filter_desa', 'Pilih Desa');
  initSelect2('#filter_organisasi', 'Pilih Organisasi');

  // Fungsi untuk memfilter desa
  function filterDesaOptions(preselectId = null) {
    const selectedKecamatanId = $('#filter_kecamatan').val();
    const desaSelect = $('#filter_desa');

    desaSelect.empty();

    // Pilih URL sesuai kondisi
    const url = selectedKecamatanId
      ? base_url + 'wilayah/get_desa_by_kecamatan/' + selectedKecamatanId
      : base_url + 'wilayah/get_all_desa';

    fetch(url)
      .then(response => response.json())
      .then(data => {
        desaSelect.append(new Option('-- Semua Desa --', 'all', false, preselectId === 'all'));
        data.forEach(desa => {
          const isSelected = desa.id_desa == preselectId;
          // simpan id_kecamatan di attribute option
          const option = new Option(desa.nama_desa, desa.id_desa, false, isSelected);
          $(option).attr('data-kecamatan', desa.id_kecamatan);
          desaSelect.append(option);
        });
        desaSelect.trigger('change.select2');
      })
      .catch(error => {
        console.error('Gagal mengambil data desa:', error);
      });
  }

  // Submit otomatis jika filter kecamatan berubah
  $('#filter_kecamatan').on('select2:select select2:clear', function () {
    filterDesaOptions();
    $('#filterForm').submit();
  });

  // Jika desa berubah → set kecamatan otomatis + submit
  $('#filter_desa').on('select2:select select2:clear', function () {
    const selectedOption = $(this).find(':selected');
    const kecamatanId = selectedOption.data('kecamatan');
    if (kecamatanId) {
      $('#filter_kecamatan').val(kecamatanId).trigger('change.select2');
    }
    $('#filterForm').submit();
  });

  // Submit otomatis jika filter organisasi berubah
  $('#filter_organisasi').on('change', function () {
    const val = $(this).val();
    const url = new URL(window.location.href);
    if (val) {
        url.searchParams.set('organisasi', val);
    } else {
        url.searchParams.delete('organisasi');
    }
    window.location.href = url.toString();
  });

});
