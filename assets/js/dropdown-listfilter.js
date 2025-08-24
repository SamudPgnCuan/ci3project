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

  // fungsi untuk populate daftar desa (dipanggil hanya saat page load / ketika diperlukan)
  function filterDesaOptions(preselectId = '') {
    const selectedKecamatanId = $('#filter_kecamatan').val();
    const desaSelect = $('#filter_desa');

    // clear dulu
    desaSelect.empty();

    const url = selectedKecamatanId
      ? base_url + 'wilayah/get_desa_by_kecamatan/' + selectedKecamatanId
      : base_url + 'wilayah/get_all_desa';

    fetch(url)
      .then(response => response.json())
      .then(data => {
        // default "semua" kita representasikan sebagai value kosong '' saat submit
        desaSelect.append(new Option('-- Semua Desa --', '', false, preselectId === '' || preselectId === null));

        data.forEach(desa => {
          const isSelected = String(desa.id_desa) === String(preselectId);
          const option = new Option(desa.nama_desa, desa.id_desa, false, isSelected);
          $(option).attr('data-kecamatan', desa.id_kecamatan);
          desaSelect.append(option);
        });

        // beri tahu select2 supaya render ulang
        desaSelect.trigger('change.select2');
      })
      .catch(error => console.error('Gagal mengambil data desa:', error));
  }

  // Pada page load, populate desa (jika element ada)
  if ($('#filter_desa').length) {
    filterDesaOptions(preselectedDesaId);
  }

  // ---------- helper utk submit yang menjaga semua param ----------
  // kita baca semua input/select di form dan bangun query sendiri, sehingga
  // semua param yang aktif akan selalu dikirim (tidak hilang karena submit partial).
  function submitFiltersByForm() {
    const form = document.getElementById('filterForm');
    if (!form) return;

    const fd = new FormData(form);
    const params = new URLSearchParams();

    // iterate semua pairs, tapi skip nilai kosong
    for (const [key, value] of fd.entries()) {
      // beberapa control (misalnya kita sempat menyimpan 'all'), anggap '' = semua => skip
      if (value === null) continue;
      const v = String(value).trim();
      if (v === '' || v.toLowerCase() === 'all') continue;
      params.append(key, v);
    }

    // bangun url baru dan load
    const url = window.location.origin + window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    window.location.href = url;
  }

  // variant yang hanya submit langsung (fallback) -- tidak direkomendasikan
  function fallbackSubmit() {
    $('#filterForm').submit();
  }

  // ---------- Bind event handlers ----------
  // 1) KECAMATAN: cukup submit form (jangan panggil filterDesaOptions() di sini)
  // kita biarkan page reload dan saat page load select-desanya di-populate sesuai param kecamatan.
  $('#filter_kecamatan').on('select2:select select2:clear change', function () {
    // langsung submit via submitFiltersByForm supaya semua param lain tetap ikut
    submitFiltersByForm();
  });

  // 2) DESA: ketika user pilih desa, set kecamatan otomatis (jika perlu) lalu submit
  $('#filter_desa').on('select2:select select2:clear change', function () {
    let val = $(this).val();

    // jika pilih opsi "semua" kita mengirim kosong (skipped)
    if (val === 'all') {
      $(this).val('').trigger('change.select2');
      val = '';
    } else if (val) {
      const selectedOption = $(this).find(':selected');
      const kecamatanId = selectedOption.data('kecamatan');
      if (kecamatanId) {
        // set kecamatan (ini tidak akan memicu infinite loop karena kecamatan change akan submit)
        $('#filter_kecamatan').val(kecamatanId).trigger('change.select2');
      }
    }

    // submit (pakai builder URL agar semua param dipertahankan)
    submitFiltersByForm();
  });

  // 3) Filter lain (organisasi, ancaman, tahun, tanggal, dsb)
  // Tangani dua event: select2 events dan native 'change' untuk jaga-jaga.
  $('#filter_organisasi, #filter_ancaman, #filter_tahun, #filter_bulan, #filter_tanggal_mulai, #filter_tanggal_selesai')
    .on('select2:select select2:clear change', function () {
      submitFiltersByForm();
    });

});
