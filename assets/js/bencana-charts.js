document.addEventListener('DOMContentLoaded', function() {
  const startYear = 2010;
  const endYear = new Date().getFullYear();

  const selectYear = document.getElementById('selectYear');
  for (let y = endYear; y >= startYear; y--) {
    const opt = document.createElement('option');
    opt.value = y;
    opt.text = y;
    selectYear.appendChild(opt);
  }
  selectYear.value = endYear;

  let chartYearly = null;
  let chartMonthly = null;

  function buildFilterParams() {
    const params = new URLSearchParams();

    const kec = document.getElementById('filter_kecamatan') || document.getElementById('kecamatan');
    const desa = document.getElementById('filter_desa') || document.getElementById('desa');
    const anc  = document.getElementById('filter_ancaman') || document.getElementById('id_ancaman') || document.getElementById('ancaman');
    const tmul = document.getElementById('filter_tanggal_mulai') || document.getElementById('tanggal_mulai');
    const tsls = document.getElementById('filter_tanggal_selesai') || document.getElementById('tanggal_selesai');

    if (kec && kec.value) params.append('kecamatan', kec.value);
    if (desa && desa.value) params.append('desa', desa.value);
    if (anc && anc.value) params.append('id_ancaman', anc.value);
    if (tmul && tmul.value) params.append('tanggal_mulai', tmul.value);
    if (tsls && tsls.value) params.append('tanggal_selesai', tsls.value);

    return params;
  }

  async function drawYearly() {
    try {
      const params = buildFilterParams();
      const url = base_url + 'bencana/stats_yearly?' + params.toString();

      const res = await fetch(url);
      const data = await res.json();

      const ctx = document.getElementById('chartYearly').getContext('2d');
      if (chartYearly) chartYearly.destroy();

      chartYearly = new Chart(ctx, {
        type: 'line',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Jumlah kejadian per tahun',
            data: data.data,
            fill: false,
            tension: 0.2,
            pointRadius: 4
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: true } },
          scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
      });
    } catch (err) {
      console.error('drawYearly error', err);
    }
  }

  async function drawMonthly(year) {
    try {
      const params = buildFilterParams();
      params.append('year', year);

      const url = base_url + 'bencana/stats_monthly?' + params.toString();

      const res = await fetch(url);
      const data = await res.json();

      const ctx = document.getElementById('chartMonthly').getContext('2d');
      if (chartMonthly) chartMonthly.destroy();

      chartMonthly = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Jumlah kejadian - ' + data.year,
            data: data.data
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false } },
          scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
      });
    } catch (err) {
      console.error('drawMonthly error', err);
    }
  }

  // inisialisasi
  drawYearly();
  drawMonthly(selectYear.value);

  // event change/select
  selectYear.addEventListener('change', function() {
    drawMonthly(this.value);
  });

  // tombol refresh (jika ada)
  const btnRefresh = document.getElementById('btnRefreshCharts');
  if (btnRefresh) {
    btnRefresh.addEventListener('click', function() {
      drawYearly();
      drawMonthly(selectYear.value);
    });
  }

  // jika filter di halaman berubah
  document.addEventListener('change', function(e){
    const idsToWatch = ['filter_kecamatan','filter_desa','filter_ancaman','tanggal_mulai','tanggal_selesai','kecamatan','desa','ancaman'];
    if (e.target && idsToWatch.indexOf(e.target.id) !== -1) {
      drawYearly();
      drawMonthly(selectYear.value);
    }
  });
});
