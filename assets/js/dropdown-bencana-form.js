document.addEventListener('DOMContentLoaded', function () {
  console.log('dropdown-bencana-form.js aktif');

  const kecamatanSelect = document.getElementById('filter_kecamatan');
  const destanaSelect   = document.getElementById('id_destana');

  if (!kecamatanSelect || !destanaSelect) {
    console.warn('Elemen kecamatan atau destana tidak ditemukan. Mungkin bukan di halaman form bencana.');
    return;
  }

  const preselectedDestanaId = destanaSelect.dataset.selected || null;

  /**
   * Populate desa sesuai kecamatan.
   * Jika kecamatan kosong → ambil semua destana.
   */
  function populateDestanaOptions(preselectId = null) {
    const selectedKecamatanId = kecamatanSelect.value;
    let url = base_url + 'wilayah/get_destana_by_kecamatan';
    if (selectedKecamatanId) {
      url += '/' + selectedKecamatanId;
    }

    destanaSelect.innerHTML = '';
    const defaultOption = new Option('-- Pilih Desa --', '');
    destanaSelect.appendChild(defaultOption);

    fetch(url)
      .then(response => response.json())
      .then(data => {
        console.log('Data destana diterima:', data);

        data.forEach(item => {
          const option = new Option(
            `${item.nama_desa} (${item.nama_kecamatan})`,
            item.id_destana,
            false,
            item.id_destana == preselectId
          );
          option.dataset.kecamatan = item.id_kecamatan; // simpan id_kecamatan di attribute
          destanaSelect.appendChild(option);
        });

        $(destanaSelect).trigger('change.select2');
      })
      .catch(error => {
        console.error('Gagal mengambil data destana:', error);
      });
  }

  // Inisialisasi awal (jika ada preselected)
  populateDestanaOptions(preselectedDestanaId);

  // Update desa saat kecamatan berubah
  $(kecamatanSelect).on('change', function () {
    populateDestanaOptions();
  });

  // Jika user memilih desa → set otomatis kecamatan
  $(destanaSelect).on('change', function () {
    const selectedOption = destanaSelect.options[destanaSelect.selectedIndex];
    if (selectedOption && selectedOption.dataset.kecamatan) {
      const desaKecamatanId = selectedOption.dataset.kecamatan;

      if (desaKecamatanId && kecamatanSelect.value !== desaKecamatanId) {
        const selectedDestanaId = destanaSelect.value; // simpan desa yg dipilih

        // set kecamatan
        $(kecamatanSelect).val(desaKecamatanId).trigger('change');

        // setelah desa ter-reload, pilih kembali desa yang tadi
        setTimeout(() => {
          $(destanaSelect).val(selectedDestanaId).trigger('change');
        }, 300);
      }
    }
  });


  // Select2 init
  $(kecamatanSelect).select2({
    placeholder: 'Pilih Kecamatan',
    allowClear: true,
    width: '100%',
    dropdownParent: $(kecamatanSelect).parent()
  });

  $(destanaSelect).select2({
    placeholder: 'Pilih Desa',
    allowClear: true,
    width: '100%',
    dropdownParent: $(destanaSelect).parent()
  });
});
