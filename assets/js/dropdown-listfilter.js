document.addEventListener('DOMContentLoaded', function () {

  // make sure preselectedDesaId is a string ('' if not set)
  const preselectedDesaId = $('#filter_desa').data('selected') || '';
  filterDesaOptions(preselectedDesaId);

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

  initSelect2('#filter_kecamatan', 'Pilih Kecamatan');
  initSelect2('#filter_desa', 'Pilih Desa');
  initSelect2('#filter_organisasi', 'Pilih Organisasi');

  function filterDesaOptions(preselectId = '') {
    const selectedKecamatanId = $('#filter_kecamatan').val();
    const desaSelect = $('#filter_desa');

    desaSelect.empty();

    const url = selectedKecamatanId
      ? base_url + 'wilayah/get_desa_by_kecamatan/' + selectedKecamatanId
      : base_url + 'wilayah/get_all_desa';

    fetch(url)
      .then(response => response.json())
      .then(data => {
        // Gunakan 'all' sebagai value supaya Select2 menampilkannya
        const isSelectedAll = (preselectId === '' || preselectId === null || preselectId === 'all');
        desaSelect.append(new Option('-- Semua Desa --', 'all', false, isSelectedAll));

        data.forEach(desa => {
          const isSelected = String(desa.id_desa) === String(preselectId);
          const option = new Option(desa.nama_desa, desa.id_desa, false, isSelected);
          $(option).attr('data-kecamatan', desa.id_kecamatan);
          desaSelect.append(option);
        });

        // Jika preselectId sebenarnya kosong (''), kita tetap ingin Select2 menampilkan placeholder
        // tapi supaya ketika user submit sebagai "semua", kita akan convert 'all' -> ''
        desaSelect.trigger('change.select2');
      })
      .catch(error => {
        console.error('Gagal mengambil data desa:', error);
      });
  }

  // Kalau kecamatan berubah -> reload desa dan submit
  $('#filter_kecamatan').on('select2:select select2:clear', function () {
    filterDesaOptions();
    $('#filterForm').submit();
  });

  // Jika desa berubah → set kecamatan otomatis + submit
  $('#filter_desa').on('select2:select select2:clear', function () {
    let val = $(this).val();

    // Jika user memilih opsi "Semua Desa" (value 'all'), ubah ke '' sebelum submit
    if (val === 'all') {
      // set element value ke empty (sebagai representasi "semua")
      $(this).val('').trigger('change.select2');
      val = '';
    } else if (val) {
      // pilih desa spesifik -> set kecamatan sesuai data attribute
      const selectedOption = $(this).find(':selected');
      const kecamatanId = selectedOption.data('kecamatan');
      if (kecamatanId) {
        $('#filter_kecamatan').val(kecamatanId).trigger('change.select2');
      }
    }

    // Submit form (GET). Karena kita telah mengosongkan value kalau 'all', backend akan menerima kosong.
    $('#filterForm').submit();
  });

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
