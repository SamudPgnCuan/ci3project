

document.addEventListener('DOMContentLoaded', function () {
  console.log('dropdown-form.js dimuat baru 3:00');

  const currentPage = document.body.dataset.page;
  const usedParam = (currentPage === 'destana') ? '?unused=true' : '';
  
  const kecamatanSelect = document.getElementById('filter_kecamatan');
  const desaSelect = document.getElementById('filter_desa');

  if (!kecamatanSelect || !desaSelect) {
    console.warn('Elemen kecamatan atau desa tidak ditemukan. Mungkin bukan di halaman form.');
    return;
  }

  // Ambil desa terpilih dari atribut data-selected
  const preselectedDesaId = desaSelect.dataset.selected || null;

  // Fungsi untuk memuat desa berdasarkan kecamatan
  function populateDesaOptions(preselectId = null) {
    console.log('populateDesaOptions() dipanggil');

    const selectedKecamatanId = kecamatanSelect.value;

    desaSelect.innerHTML = ''; // kosongkan dulu
    const defaultOption = new Option('-- Pilih Desa --', '');
    desaSelect.appendChild(defaultOption);

    if (!selectedKecamatanId) {
      console.warn('Belum ada kecamatan dipilih');
      $(desaSelect).trigger('change.select2'); // Untuk sinkronisasi Select2
      return;
    }

    fetch(base_url + `wilayah/get_desa_by_kecamatan/` + selectedKecamatanId +usedParam)
      .then(response => response.json())
      .then(data => {
        console.log('Data desa diterima:', data);

        data.forEach(desa => {
          const option = new Option(desa.nama_desa, desa.id_desa, false, desa.id_desa == preselectId);
          desaSelect.appendChild(option);
        });

        // Trigger agar select2 refresh
        $(desaSelect).trigger('change.select2');
      })
      .catch(error => {
        console.error('Gagal mengambil data desa:', error);
      });
  }

  // Jalankan saat pertama kali untuk preselect
  populateDesaOptions(preselectedDesaId);

  // Jalankan ulang saat kecamatan berubah
  $(kecamatanSelect).on('change', function () {
    console.log('Kecamatan diubah, trigger populateDesaOptions()');
    populateDesaOptions();
  });

  // Inisialisasi Select2 (pastikan ini setelah event binding)
  $(kecamatanSelect).select2({
    placeholder: 'Pilih Kecamatan',
    allowClear: true,
    width: '100%',
    dropdownParent: $(kecamatanSelect).parent()
  });

  $(desaSelect).select2({
    placeholder: 'Pilih Desa (setelah pilih kecamatan :3)',
    allowClear: true,
    width: '100%',
    dropdownParent: $(desaSelect).parent()
  });
});
