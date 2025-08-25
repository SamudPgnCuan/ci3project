document.addEventListener('DOMContentLoaded', function () {

  // ambil preselected id dari attribute data-selected (untuk page load)
  const preselectedDesaId = $('#filter_desa').data('selected') || '';

  // Inisialisasi Select2 jika ada
  function initSelect2(selector, placeholder) {
    if ($(selector).length) {
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
  }

  initSelect2('#filter_kecamatan', 'Pilih Kecamatan');
  initSelect2('#filter_desa', 'Pilih Desa');
  initSelect2('#filter_organisasi', 'Pilih Organisasi');
  initSelect2('#filter_ancaman', 'Pilih Ancaman');
  initSelect2('#filter_kelas', 'Pilih Kelas');
  initSelect2('#filter_sumber', 'Pilih Sumber Dana');
  initSelect2('#filter_tahun', 'Pilih Tahun');

  // fungsi untuk populate daftar desa (dipanggil pada page load dan saat kecamatan berubah)
  function filterDesaOptions(preselectId = '') {
    const selectedKecamatanId = $('#filter_kecamatan').val();
    const desaSelect = $('#filter_desa');

    if (!desaSelect.length) return;

    desaSelect.empty();

    const url = selectedKecamatanId
      ? base_url + 'wilayah/get_desa_by_kecamatan/' + selectedKecamatanId
      : base_url + 'wilayah/get_all_desa';

    fetch(url)
      .then(response => response.json())
      .then(data => {
        // representasikan opsi "Semua" sebagai value kosong ('')
        desaSelect.append(new Option('-- Semua Desa --', '', false, preselectId === '' || preselectId === null));

        data.forEach(desa => {
          const isSelected = String(desa.id_desa) === String(preselectId);
          const option = new Option(desa.nama_desa, desa.id_desa, false, isSelected);
          $(option).attr('data-kecamatan', desa.id_kecamatan);
          desaSelect.append(option);
        });

        desaSelect.trigger('change.select2');
      })
      .catch(error => console.error('Gagal mengambil data desa:', error));
  }

  // Pada page load, populate desa (jika element ada)
  if ($('#filter_desa').length) {
    filterDesaOptions(preselectedDesaId);
  }

  // ---------- helper utk submit yang menjaga semua param ----------
  function submitFiltersByForm() {
    const form = document.getElementById('filterForm');
    if (!form) return;

    const fd = new FormData(form);
    const params = new URLSearchParams();

    for (const [key, value] of fd.entries()) {
      if (value === null) continue;
      const v = String(value).trim();
      // skip empty / "all"
      if (v === '' || v.toLowerCase() === 'all') continue;
      params.append(key, v);
    }

    const url = window.location.origin + window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
  }

  // ---------- BIND EVENT HANDLERS ----------

  // kecamatan: submit (desanya akan di-populate pada next page load)
  $('#filter_kecamatan').on('select2:select select2:clear change', function () {
    submitFiltersByForm();
  });

  // desa: set kecamatan otomatis jika perlu, lalu submit
  $('#filter_desa').on('select2:select select2:clear change', function () {
    let val = $(this).val();

    if (val === 'all') {
      $(this).val('').trigger('change.select2');
      val = '';
    } else if (val) {
      const selectedOption = $(this).find(':selected');
      const kecamatanId = selectedOption.data('kecamatan');
      if (kecamatanId) {
        $('#filter_kecamatan').val(kecamatanId).trigger('change.select2');
      }
    }

    submitFiltersByForm();
  });

  // semua filter lain (organisasi, ancaman, tahun, kelas, sumber, tanggal, dsb)
  // tangani select2 events dan native change (untuk input date)
  $('#filter_organisasi, #filter_ancaman, #filter_tahun, #filter_kelas, #filter_sumber, #filter_tanggal_mulai, #filter_tanggal_selesai')
    .on('select2:select select2:clear change', function () {
      submitFiltersByForm();
    });

});
