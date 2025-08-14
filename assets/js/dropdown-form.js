document.addEventListener('DOMContentLoaded', function () {
  console.log('dropdown-form.js dimuat baru 11 40');

  const currentPage = document.body.dataset.page;
  const kecamatanSelect = document.getElementById('filter_kecamatan');
  const desaSelect = document.getElementById('filter_desa');

  if (!kecamatanSelect || !desaSelect) {
    console.warn('Elemen kecamatan atau desa tidak ditemukan. Mungkin bukan di halaman form.');
    return;
  }

  const preselectedDesaId = desaSelect.dataset.selected || null;

  let usedParam = '';
  if (currentPage === 'destana') {
    usedParam = '?unused=true';
    if (preselectedDesaId) {
      usedParam += `&aktif=${preselectedDesaId}`;
    }
  }

  function populateDesaOptions(preselectId = null) {
    console.log('populateDesaOptions() dipanggil');

    const selectedKecamatanId = kecamatanSelect.value;

    desaSelect.innerHTML = '';
    const defaultOption = new Option('-- Pilih Desa --', '');
    desaSelect.appendChild(defaultOption);

    if (!selectedKecamatanId) {
      console.warn('Belum ada kecamatan dipilih');
      $(desaSelect).trigger('change.select2');
      return;
    }

    fetch(base_url + `wilayah/get_desa_by_kecamatan/` + selectedKecamatanId + usedParam)
      .then(response => response.json())
      .then(data => {
        console.log('Data desa diterima:', data);

        data.forEach(desa => {
          const option = new Option(desa.nama_desa, desa.id_desa, false, desa.id_desa == preselectId);
          desaSelect.appendChild(option);
        });

        $(desaSelect).trigger('change.select2');
      })
      .catch(error => {
        console.error('Gagal mengambil data desa:', error);
      });
  }

  populateDesaOptions(preselectedDesaId);

  $(kecamatanSelect).on('change', function () {
    console.log('Kecamatan diubah, trigger populateDesaOptions()');
    populateDesaOptions();
  });

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

  $('#id_organisasi').select2({
    placeholder: 'Pilih Organisasi',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#id_organisasi').parent()
  });
});
